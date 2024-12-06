<?elements
class grid
string title lb "Název"
string url size "30" lb "URL"
string annot lb "Poznámka"
bind status lb "Status" list "1,ok,9,failed"
string lastrun_at date "d.m.Y H:i" lb "Spuštěno"
bind inactive list "0,inactive,1," skip field "active"
link lnrun route "tests/run/id:{id}" lb "spustit" skip
link lnadd route "tests/add" lb "Přidat test" skip
link lnimport route "tests/import" lb "Importovat" skip
link lnedit route "tests/edit/id:{id}" lb "Editovat" skip
pager pager
?>
<style>
	.status-1 {
		color:green;
	}
	.status-9 {
		color:red;
	}
</style>


<h1>{project_title}</h1>
<table class="grid">
<tr>
	<th>{title.lb}</th>
	<th>{url.lb}</th>
	<th>{status.lb}</th>
	<th>{lastrun_at.lb}</th>
	<th></th>
</tr>
{block items}
  <tr class="link {inactive}" onclick="{lnedit.js}">
  	<td>{title}</td>
  	<td><a href="{base_url}{url}" class="stop-propagation" target="_blank">{url}</a></td>
  	<td><i class="fa fa-circle status-{status.value}"></i> {status}</td>
  	<td>{lastrun_at}</td>
  	<td align="right" class="stop-propagation" width="100"><a href="javascript:void()" onclick="template_form_load_diff({id})">náhled</a> {lnrun}</td>
  </tr>
{block else}
<tr>
	<td colspan="6">Žádné položky nenalezeny.</td>
</tr>
{/block}
</table>
<div class="pager">{pager} | {pager.total} záznamů</div>

<p>{lnadd} | {lnimport}</p>

<button onclick="document.location='?r=tests/run-all&project_id={project_id}'">Spustit vše</button>

<script>

function init()
{
	$scrollDiv = [];
  $('body').on('keydown', scrollDiv); 
}

$(document).ready(init);
</script>