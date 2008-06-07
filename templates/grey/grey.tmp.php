<?php
/*
A.I.R.C.O
template
@author #urk team
*/

echo <<< TEMPLATE
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="all" href="templates/{$template}/style.css" />
	<title>#channel A.I.R.C.O</title>
</head>
<body{$bodyLoad}>
<div class="container">
	<div class="header">
		<a href="index.php" title="home"><img src="images/home.png" width="30" height="30" alt="home" /></a>
		<a href="index.php?mod=logs" title="logs"><img src="images/logs.png" width="30" height="30" alt="logs" /></a>
		<a href="index.php?mod=quotes" title="quotes"><img src="images/quotes.png" width="30" height="30" alt="quotes" /></a>
		<a href="index.php?mod=pics" title="pics"><img src="images/pics.png" width="30" height="30" alt="pics" /></a>
		{$extraButtons}
		<a href="index.php?mod=logout" title="logout"><img src="images/logout.png" width="30" height="30" alt="logout" /></a>
		#channel {$headerText}
	</div>
	<div class="nav">
		<form method="post">
			<input type="text" name="search" value="zoeken" onfocus="this.value=''" />
			<input class="search" type="image" src="images/search.png" />
		</form>
		{$crumbs}
	</div>
	<div class="main">
		{$content}
	</div>
</div>
</body>
</html>
TEMPLATE;
?>
