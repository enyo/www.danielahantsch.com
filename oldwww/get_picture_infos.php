var picture_infos = new Array ();

<?php

	require_once ('inc/picture_infos.php');

	if (!isset ($_GET['picture_name']) || !isset ($picture_infos[$_GET['picture_name']])) { $picture_name = 'not_available'; }
	else                                                                                  { $picture_name = $_GET['picture_name']; }
	$tpi = $picture_infos[$picture_name];
?>
picture_infos['title']    = '<?php echo $tpi['title']; ?>';
picture_infos['year']     = '<?php echo $tpi['year']; ?>';
picture_infos['material'] = '<?php echo $tpi['material']; ?>';
picture_infos['size']     = '<?php echo $tpi['size']; ?>';
picture_infos['price']    = '<?php echo $tpi['price']; ?>';
