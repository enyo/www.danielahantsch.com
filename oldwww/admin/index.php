<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Matthias Loitsch" />
	<meta name="description" content="Daniela Hantsch" />
	<meta name="keywords" content="Daniela Hantsch Malerin Künstlerin" />

	<title>Daniela Hantsch | Admin</title>

	<style type="text/css">
		body
		{
			background-color: white;
			padding: 0px;
			margin: 0px;
		}
		
		body, h1, div, input, textarea
		{
			font-family: verdana, tahoma, sans-serif;
			font-size: 12px;
		}


		input, textarea
		{
			width: 450px;
		}
		textarea
		{
			height: 200px;
		}

		#content
		{
			width: 850px;
			border: 1px solid gray;
			background-color: white;
			margin: 20px auto 20px auto;
			padding: 10px 20px;
		}
		
		.page
		{
			page-break-after: always;
		}

		td
		{
			padding: 3px 10px;
			background-color: silver;
		}


	</style>

</head>
<body>


<div id="content">
<?php
if (isset ($_POST['mail']))
{
	try
	{
		$mail = $_POST['mail'];
		if (empty ($mail['subject']) ||
			empty ($mail['recipients']) ||
			empty ($mail['text'])) { throw new Exception ('Bitte alles ausfüllen.'); }
		
		$recipients = explode ("\n", $mail['recipients']);

		// Additional headers
		$eol = "\n";
		$from = 'Admin Daniela Hantsch <kontakt@danielahantsch.com>';
		$headers  = 'From: '.$from.$eol;
		$headers .= 'Reply-To: '.$from.$eol; 
		$headers .= 'Content-type: text/plain; charset=utf-8' . $eol;
		// Mail it
		foreach ($recipients as $this_recipient)
		{
			if (!empty ($this_recipient))
			{
				mail($this_recipient, ($mail['subject']), (wordwrap ($mail['text'], 70)), $headers);
			}
		}
		
		
		echo '<div style="font-size: 14px; color: green; font-weight: bold;">Das Mail wurde erfolgreich versendet.</div>';
	}
	catch (Exception $e)
	{
	
		echo '<div style="font-size: 14px; color: red; font-weight: bold;">'.$e->getMessage ().'</div>';
	}

}
	

?>

	<form id="the_form" action="." method="post">
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td>
				Subject:
			</td>
			<td>
				<input type="text" value="<?php echo @$_POST['mail']['subject']; ?>" name="mail[subject]" /><br />
			</td>
		</tr>
		<tr>
			<td valign="top">
				Empfänger:<br />
				1 empfaenger pro zeile<br />
			</td>
			<td>
				<textarea name="mail[recipients]"><?php
					$recipients =@$_POST['mail']['recipients']; 
					if (empty ($recipients))
					{
						$recipients = '';
						$addresses = file ('../newsletter_addresses.txt');
						$i = 0;
						foreach ($addresses as $this_line)
						{
							$this_line = trim ($this_line);
							if (!empty ($this_line))
							{
								switch ($i)
								{
									case 0:
										$i ++;
										$ADDR_ID = $this_line;
										break;
									case 1:
										$i ++;
										$ADDR_NAME = $this_line;
										break;
									case 2:
										$i = 0;
										$ADDR_EMAIL = $this_line;
										$recipients .= $ADDR_NAME . ' <'. $ADDR_EMAIL.'>'."\n";
								}
							}
						}

					}
					echo $recipients;
				?></textarea><br />
			</td>
		</tr>
		<tr>
			<td valign="top">
				Text:<br />
			</td>
			<td>
				<textarea name="mail[text]"><?php
					$text = @$_POST['mail']['text'];
					echo (empty ($text))?"\n\n\n-- \nhttp://www.danielahantsch.com\n":$text;
				?></textarea>
			</td>
		</tr>
	</table>
	<input type="button" onclick="javascript: this.disabled='true'; document.getElementById ('the_form').submit (); undefined;" value="ABSENDEN!" name="mail[submit]" />
	</form>
</div>


</body>
</html>