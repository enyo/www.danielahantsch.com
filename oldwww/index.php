<?php
	require_once ('inc/ini.php');
	require_once ('inc/sitemap.php');
	$SITE = 'default';
	foreach ($sitemap as $this_short=>$this_display)
	{
		if (isset ($_GET[$this_short]))
		{
			$SITE = $this_short;
			break;
		}
	}

	$site_functions = 'inc/functions.' . $SITE . '.php';
	if (is_file ($site_functions)) { include ($site_functions); }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Matthias Loitsch" />
	<meta name="description" content="Daniela Hantsch" />
	<meta name="keywords" content="Daniela Hantsch Malerin Künstlerin" />

	<title>Daniela Hantsch</title>

	<style type="text/css">
		@import "style/default.css";
<?php
	$site_css = 'style/site.' . $SITE . '.css';
	if (is_file ($site_css)) echo "\t\t" . '@import "' . $site_css . '";' . "\n";
?>
	</style>


<?php
	$site_js = 'js/site.' . $SITE . '.js';
	if (is_file ($site_js)) echo "\t" . '<script type="text/javascript" src="' . $site_js . '"></script>' . "\n";
?>
	<script type="text/javascript" src="js/menu.js"></script>

	<script type="text/javascript">
	<!--
<?php
			$pics = array ();
			foreach ($sitemap as $this_short=>$this_display)
			{
				$pics[] = '"' . $this_short . '"';
			}
			$pics = implode (', ', $pics);
?>

			var Menu = new Menu ([<?php echo $pics; ?>]);
	-->
	</script>

</head>
<body onload="javascript: Menu.set_active ('<?php echo $SITE; ?>');">




<div id="container">

	<div id="header">
		<a href="/" title="home"><img src="pics/daniela_hantsch.gif" width="155" height="16" alt="" /></a>
	</div>

	<div id="menu">
		<div id="menu_links">
			<ul>
<?php
				foreach ($sitemap as $this_short=>$this_display)
				{
?>
				<li><a title="<?php echo $this_short; ?>" href="./?<?php echo $this_short; ?>" accesskey="<?php echo $access[$this_short]; ?>" class="link"
				       onclick=    "javascript: Menu.set_active ('<?php echo $this_short; ?>');"
				       onmouseover="javascript: Menu.mouse_over ('<?php echo $this_short; ?>');"
				       onmouseout= "javascript: Menu.mouse_out  ('<?php echo $this_short; ?>');"><img id="img_<?php echo $this_short; ?>" src="pics/menu/<?php echo $this_short; ?>.gif"    height="16" alt="<?php echo $this_short; ?>" /></a></li>
<?php
				}
?>

			</ul>
		</div>
	</div>

	<div id="content">
<!-- Included Content // -->

<?php include ('sites/' . $SITE . '.php'); ?>

<!-- // Included Content -->
	</div>

</div>



</body>
</html>