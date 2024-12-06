<?php

use pclib\Str;

class TestsController extends PCController
{

public $db;

function __construct($app)
{
	parent::__construct($app);
	$this->db = $this->app->db;
}

function indexAction()
{
	$project = $this->model('projects', $this->getProjectId());

  $grid = new PCGrid('tpl/tests/list.tpl', 'tests');
  
  $grid->setQuery(
  	"select * from tests where project_id='{0}'
  	~ and status='{status}'
  	~ and title like '%{title}%'
  	~ and annot like '%{annot}%'", $project->id
  );

  //$grid->filter['project_id'] = $project->id;
  $grid->values['project_title'] = $project->title;
  $grid->values['base_url'] = $project->base_url;

  $search = new SearchForm($grid, ['title', 'annot', 'status']);

  return $search.$grid;
}

function runAction($id)
{
	$test = $this->model('tests', $id);

	$tester = new TestRunner;
	$tester->run($test);
	$this->app->message("Test <b>".$test->title."</b> byl spuštěn.");
	$this->redirect('tests');
}

function runAllAction()
{
  set_time_limit(0);

	$tests = $this->getTests($this->getProjectId());
	$tester = new TestRunner;
	$result = $tester->runAll($tests);
	$message = Str::format("Dokončeno: {ok} ok, {failed} selhalo. Čas: {time}s", $result);

	$percent = 100 * $result['ok'] / ($result['ok'] + $result['failed']);
	$message .= ' <meter id="m1" min="0" max="100" low="33" high="99" optimum="100" value="'.$percent.'">';

	$project = $this->model('projects', $this->getProjectId());
	$project->status = $result['failed']? 9 : 1;
	$project->status_text = $message;
	$project->lastrun_at = date("Y-m-d H:i:s");
	$project->save();

	$this->app->message($message);

	$this->redirect('tests');
}


function diffAction($id)
{
	$test = $this->model('tests', $id);

	$this->app->layout->_TITLE = $test->title;
	$url = "document.location='?r=tests/accept&id=$id'";
  return '<h2>' . $test->title . '</h2><button type="button" onclick="'.$url.'">Akceptovat test</button><div id="navig-links"></div><hr>' . Diff::toTable(Diff::compare($test->template, $test->body));
}

function editAction($id)
{
	$form = new PCForm('tpl/tests/form.tpl');
	$form->values = $this->db->select('tests', ['id' => $id]);
	$form->enable('update', 'delete');
	return $form;
}

function addAction()
{
	$form = new PCForm('tpl/tests/form.tpl');
	$form->enable('insert');
	$form->values['xpath'] = '//body';
	return $form;
}

function acceptAction($id)
{
	$test = $this->model('tests', $id);
	$test->template = $test->body;
	$test->status = 1;
	$test->save();
	$this->redirect('tests');
}

function acceptAllAction()
{
	$tests = $this->getTests($this->getProjectId());

	foreach ($tests as $test) {
		$test->template = $test->body;
		$test->status = 1;
		$test->save();
	}

	$project = $this->model('projects',$this->getProjectId());
	$project->status = 1;
	$project->status_text = "Všechny testy akceptovány.";

	$this->app->message("Všechny testy akceptovány.");

	$this->redirect('tests');
}

function insertAction()
{
	$form = new PCForm('tpl/tests/form.tpl');

	$form->values['created_at'] = date("Y-m-d H:i:s");
	$form->values['project_id'] = $this->getProjectId();

	$id = $form->insert('tests');
	$this->app->message("Test přidán.");
	$this->redirect('tests');
}

function updateAction($id)
{
	$form = new PCForm('tpl/tests/form.tpl');
	$form->values['status'] = 0;
	$form->update('tests', ['id' => $id]);
	$this->app->message("Test uložen.");
	$this->redirect('tests/edit/id:' . $id);
}

function deleteAction($id)
{
	$test = $this->model('tests', $id);
	$test->delete();
	$this->app->message("Test smazán.");
	$this->redirect('tests');
}

function importAction()
{
  $form = new PCForm('tpl/tests/import.tpl');

  if ($form->submitted) {
    $rows = explode("\r\n" , $form->values['rows']);

    foreach ($rows as $row) {
    	$field = explode(';', $row);

      $test = $this->model('tests');
      $test->title = $field[0];
      $test->url = $field[1] ?? $field[0];
      $test->project_id = $this->getProjectId();
      $test->created_at = date("Y-m-d H:i:s");
      $test->save();
    }

    $this->app->message("Testy naimportovány.");
    $this->redirect('tests');

  }

  return $form;  
}

protected function getTests()
{
	return $this->selection('tests')->where("active=1 and project_id='{0}'", $this->getProjectId());
	//return $this->db->selectAll("select * from tests where project_id='{0}'", $project_id);
}

protected function getProjectId()
{
	if (!empty($_GET['project_id'])) {
		$_SESSION['project_id'] = (int)$_GET['project_id'];
	}

	return $_SESSION['project_id'];
}


}

?>