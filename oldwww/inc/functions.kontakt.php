<?php
	function is_correct_email($email)
	{
		$arobaspos = strrpos( $email , "@");
		$pointpos = strrpos( $email , ".");
		
		if( !$arobaspos || $arobaspos == 0 || $pointpos < $arobaspos )
		{
			return False;
		}
		else
		{
			return True;
		}
	}
?>