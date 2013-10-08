<?php







function suffix ($filename)
{
	$parts = explode ('.', $filename);
	
	return ($parts[count ($parts) - 1]);
}











?>