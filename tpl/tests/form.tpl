<?elements
class form name "testform" html5
input title lb "Titulek" required
input url lb "Url" required size "50/255"
input xpath lb "Filtrovat" size "50/255" hint "(xpath)"
input xpath_exclude lb "Vyloučit" size "50/255" hint "(xpath)"
text annot lb "Poznámka" size "60x3"
check active lb "Aktivní"
button insert lb "Přidat" noprint skip
button update lb "Uložit" noprint skip
button delete lb "Smazat" noprint confirm "Opravdu smazat?" skip
button run lb "Spustit" route "tests/run/id:{id}" skip
?>
<h2>Test</h2>
<table class="form">
{form.fields}
<tr><td colspan="3">{insert} {update} {delete} {run}</td></tr>
<tr><td colspan="3">Položky označené (*) jsou povinné.</td></tr>
</table>