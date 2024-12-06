<?elements
head HEAD scripts "css/site.css,css/menu.css,js/jquery.js,js/global.js"
messages PRECONTENT noescape
string CONTENT noescape
string TITLE
string MENU noescape
string VERSION
navig NAVIG
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>PTester{if TITLE} | {TITLE}{/if}</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  {HEAD}
</head>
<body>
<div id="site-top">
<h1><span class="fa fa-bug"></span> PTester</h1>
<div style="position: absolute; top: 80px; left: 10px;">{NAVIG}</div>
<div style="position: absolute; top: 108px; right: 10px;">{VERSION}</div>
</div>
<div id="menu">{MENU}</div>

<div id="site-content">
{PRECONTENT}{CONTENT}
</div>
<div class="site-footer"></div>
<script>
$(document).ready(initGlobal);
</script>
</body>
</html>