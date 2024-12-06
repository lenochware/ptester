<?elements
class form name "projectform" html5
input title lb "Titulek" required
input base_url lb "Base Url" size "50/255"
text annot lb "Poznámka" size "60x3"
button insert lb "Přidat" noprint skip
button update lb "Uložit" noprint skip
button delete lb "Smazat" noprint confirm "Opravdu smazat?" skip
?>
<h2>Projekt</h2>
<table class="form">
{form.fields}
<tr><td colspan="3">{insert} {update} {delete}</td></tr>
<tr><td colspan="3">Položky označené (*) jsou povinné.</td></tr>
</table>