<?php
	require_once ('../inc/ini.php');
	require_once ('../inc/functions.galerie.php');

	$gallery_list = array ();
	
	$gallery_count = 0;

	$GALLERIES = './';

	if ($dh = opendir ($GALLERIES))
	{
		while (($file = readdir ($dh)) !== false)
		{
			if ($file != '.' && $file != '..' && is_dir ($GALLERIES . $file))
			{
				$gallery_list[] = "'" . $file . "'";
				if ($gh = opendir ($GALLERIES . $file))
				{
					$gallery_pictures[$gallery_count] = array ();
					if (!is_dir ($GALLERIES . $file . '/thumbs')) { mkdir ($GALLERIES . $file . '/thumbs'); }

					while (($picture = readdir ($gh)) !== false)
					{
						if (suffix ($picture) == 'jpg')
						{
							$thumbnail = $GALLERIES . $file . '/thumbs/thumb.' . $picture . '.png';
							if (!is_file ($thumbnail))
							{
								create_thumbnail ($thumbnail, $GALLERIES . $file . '/' . $picture);
							}
						}
					}
				}
	
				$gallery_count ++;
	
			}
		}
		closedir($dh);
	}


define ('THUMB_X', 120);
define ('THUMB_Y', 75);

function create_thumbnail ($target, $source)
{

	echo 'Target: ' . $target . '<br />';
	echo 'Source: ' . $source . '<br />';



	if (!is_file ($source)) { exit ('File does not exist'); }

	$dimensions = getimagesize ($source);

	$target_width  = 120;
	$target_height = 75;
	$source_width  = $dimensions[0];
	$source_height = $dimensions[1];

	$source_im = imagecreatefromjpeg ($source);
	$target_im = imagecreatetruecolor ($target_width, $target_height);
	$bg_color = imagecolorallocate ($target_im, 234, 234, 234);
	imagefill ($target_im, 1, 1, $bg_color);



	$target_proportions = $target_width / $target_height;
	$source_proportions = $source_width / $source_height;

	if ($source_proportions > $target_proportions)
	{
		// IMAGE TOO WIDE
		$XXX = 0;
// 		$target_width  = $target_width;
		$tmp = $target_width / $source_proportions;
		$YYY = round (($target_height - $tmp) / 2);
		$target_height = $tmp;
	}
	elseif ($source_proportions < $target_proportions)
	{
		// IMAGE TOO HIGH
		$YYY = 0;
// 		$target_height  = $target_height;
		$tmp = $target_height * $source_proportions;
		$XXX = round (($target_width - $tmp) / 2);
		$target_width = $tmp;
	}
	else
	{
		// IMAGE HAS PERFECT PROPORTIONS
		$XXX = 0;
		$YYY = 0;
	}

	echo 'Width: ' . $source_width . '<br />';
	echo 'Height: ' . $source_height . '<br />';

	echo '<br />';
	
	
	imagecopyresampled ($target_im, $source_im, $XXX, $YYY, 0, 0, $target_width, $target_height, $source_width, $source_height);

// Creating the image
	imagejpeg ($target_im, $target);
	imagedestroy($target_im);
	imagedestroy($source_im);


}

?>