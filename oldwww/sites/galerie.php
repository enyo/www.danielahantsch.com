<div id="galleries"></div>


<div id="thumbnails"></div>


<div id="picture"><img src="pics/kategorie_auswaehlen.gif" width="616" height="27" alt="bitte eine kategorie ausw&auml;hlen" /></div>


<div id="navigation">
	<span id="pic_ids"></span>
	<a href="javascript: Gallery.previous_picture ();">voriges</a> /
	<a href="javascript: Gallery.next_picture ();">n&auml;chstes</a>
</div>



<script type="text/javascript">
<!--
<?php

$GALLERIES = 'galleries/';



$gallery_list = array ();

$gallery_count = 0;

if ($dh = opendir ($GALLERIES))
{
	while (($file = readdir ($dh)) !== false)
	{
		$tmp_pictures = array ();
		if ($file != '.' && $file != '..' && is_dir ($GALLERIES . $file))
		{
			$gallery_list[] = "'" . $file . "'";
			if ($gh = opendir ($GALLERIES . $file))
			{
				$gallery_pictures[$gallery_count] = array ();

				while (($picture = readdir ($gh)) !== false)
				{
					if (suffix ($picture) == 'jpg')
					{
						$tmp_pictures[$picture] = true;
					}
				}
			}

			ksort ($tmp_pictures);
			foreach ($tmp_pictures as $this_picture=>$trash)
			{
				$gallery_pictures[$gallery_count][] = "'" . $this_picture . "'";
			}

			$gallery_count ++;

		}
	}
	closedir($dh);
}



?>
	Gallery.set_galleries ([<?php echo implode (',', $gallery_list); ?>]);
<?php
	foreach ($gallery_pictures as $this_gallery_id=>$this_pictures)
	{
		$picture_array = implode (',', $this_pictures);
?>
	Gallery.set_pictures (<?php echo $this_gallery_id; ?>, [<?php echo $picture_array; ?>]);
<?php
	}
?>
-->
</script>
