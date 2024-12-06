<?elements
class grid
string title lb "Název"
bind status lb "Status" list "1,ok,9,failed"
string status_text lb "Výsledek" noescape
string lastrun_at date "d.m.Y H:i" lb "Spuštěno"
link lntests route "tests/project_id:{id}"
link lnrun route "projects/run/id:{id}" lb "spustit" skip
link lnadd route "projects/add" lb "Přidat projekt" skip
link lnedit route "projects/edit/id:{id}" lb "Editovat" skip
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


<h1>Projekty</h1>


<table class="grid">
<tr>
	<th>{title.lb}</th>
	<th>{status.lb}</th>
	<th>{status_text.lb}</th>
	<th>{lastrun_at.lb}</th>
	<th></th>
</tr>
{block items}
  <tr class="link" onclick="{lntests.js}">
  	<td><i class="fa fa-cube" style="color:gray"></i> {title}</td>
  	<td><i class="fa fa-circle status-{status.value}"></i> {status}</td>
  	<td>{status_text}</td>
  	<td>{lastrun_at}</td>
  	<td align="right">{lnedit}</td>
  </tr>
{block else}
<tr>
	<td colspan="6">Žádné položky nenalezeny.</td>
</tr>
{/block}
</table>
<div class="pager">{pager} | {pager.total} záznamů</div>  

<p>{lnadd}</p>