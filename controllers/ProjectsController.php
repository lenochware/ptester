<?php

class ProjectsController extends PCController
{

public $db;

function __construct($app)
{
  parent::__construct($app);
  $this->db = $this->app->db;
}

function indexAction() {
  $grid = new PCGrid('tpl/projects/list.tpl');
  $grid->setQuery('select * from projects order by position, title');
  return $grid;
}

function editAction($id)
{
  $form = new PCForm('tpl/projects/form.tpl');
  $form->values = $this->db->select('projects', ['id' => $id]);
  $form->enable('update', 'delete');
  return $form;
}

function addAction()
{
  $form = new PCForm('tpl/projects/form.tpl');
  $form->enable('insert');
  return $form;
}

function insertAction()
{
  $form = new PCForm('tpl/projects/form.tpl');

  $form->values['created_at'] = date("Y-m-d H:i:s");

  $id = $form->insert('projects');
  $this->app->message("Projekt přidán.");
  $this->redirect('projects/edit/id:' . $id);
}

function updateAction($id)
{
  $form = new PCForm('tpl/projects/form.tpl');
  $form->update('projects', ['id' => $id]);
  $this->app->message("Projekt uložen.");
  $this->redirect('projects/edit/id:' . $id);
}

function deleteAction($id)
{
  $project = $this->model('projects', $id);

  if ($project->tests->count()) {
    $this->app->error("Nelze smazat, obsahuje testy.");
  }

  $project->delete();
  $this->app->message("Projekt smazán.");
  $this->redirect('projects');
}

}

?>