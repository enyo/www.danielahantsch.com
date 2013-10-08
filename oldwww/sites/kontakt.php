<?php

	$FILENAME = 'newsletter_addresses.txt';

?>

<a href="mailto: kontakt@danielahantsch.com">kontakt@danielahantsch.com</a>

<div id="address">
	<h1>Adresse:</h1>
	Schreygasse 12 / 8<br />
	A - 1020 Wien<br />
</div>


<div id="newsletter">
	<h1>Newsletter</h1>
	Wenn Sie über Ausstellungen und Informationen von Daniela Hantsch informiert werden wollen ,
	abonnieren Sie den Newsletter.<br><br>
	<?php
		if (isset ($_GET['remove_address']) && isset ($_GET['remove_id']))
		{
			$removed = false;
			$addresses = file ($FILENAME);
			$remaining_addresses = '';

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
							if ($ADDR_EMAIL != $_GET['remove_address'] || $ADDR_ID != $_GET['remove_id'])
							{
								$remaining_addresses .= $ADDR_ID."\n";
								$remaining_addresses .= $ADDR_NAME."\n";
								$remaining_addresses .= $ADDR_EMAIL."\n\n";
							}
							else
							{
								$removed = true;
							}
							break;
					}
				}
			}
			if ($removed)
			{
				echo '<div class="success">Ihre Adresse wurde erfolgreich vom Newsletter entfernt.</div>';
				file_put_contents ($FILENAME, $remaining_addresses);
			}
			else
			{
				echo '<div class="error">Ihre E-Mail Adresse konnte leider nicht entfernt werden.<br />Wenden Sie sich bitte an den Administrator.</div>';
			}
		}
		elseif (!isset ($_POST['newsletter']))
		{
	?>
	<form action="./?kontakt" method="post"> 
		Name: <input type="text" value="" name="newsletter[name]" />
		E-mail: <input type="text" value="" name="newsletter[mail]" />
		<input type="submit" name="newsletter[submit]" value="Absenden" />
	</form>
	<?php
	}
	else
	{
		try
		{
			$NEW_NAME = trim (str_replace (array("\r\n", "\n\r", "\n", "\r"), " ", $_POST['newsletter']['name']));
			$NEW_MAIL = trim (str_replace (array("\r\n", "\n\r", "\n", "\r"), " ", $_POST['newsletter']['mail']));

			if (empty ($NEW_NAME))
			{
				throw new Exception ('Bitte füllen Sie ihren Namen aus.');
			}
			if (empty ($NEW_MAIL) || !is_correct_email ($NEW_MAIL))
			{
				throw new Exception ('Ihre E-Mail Adresse ist nicht valide.');
			}

			$addresses = file ($FILENAME);
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
// 							echo $ADDR_ID . '-' . $ADDR_NAME . '-'.$ADDR_EMAIL.'<br>';
							if ($ADDR_EMAIL == $NEW_MAIL) { throw new Exception ('Sie haben den Newsletter schon abonniert.'); }
							break;
					}
				}
			}
			$NEW_RANDOM = md5 (rand (1, 99999));
			$content = file_get_contents ($FILENAME)."\n";
			$content .= $NEW_RANDOM."\n";
			$content .= $NEW_NAME."\n";
			$content .= $NEW_MAIL."\n";
			
			file_put_contents ($FILENAME, $content);
			$eol = "\n";
			$from = 'Admin Daniela Hantsch <admin@danielahantsch.com>';
			$headers  = 'From: '.$from.$eol;
			$headers .= 'Reply-To: '.$from.$eol; 
			$headers .= 'Content-type: text/plain; charset=utf-8' . $eol;
			mail ($NEW_NAME . ' <'.$NEW_MAIL.'>', 'Danke fuer die Newsletter Abonierung.', wordwrap ("
$NEW_NAME,

Danke dass Sie den Newsletter auf www.danielahantsch.com abonniert haben.
Dies ist ein Bestätigungs E-mail.
Sollten Sie diesen Newsletter nicht selbst abonniert haben, oder entscheiden sich wieder abzumelden, benutzen Sie bitte diesen Link:
http://www.danielahantsch.com/?kontakt&remove_address=".rawurlencode ($NEW_MAIL)."&remove_id=$NEW_RANDOM

Danke.

-- 
www.danielahantsch.com
", 70), $headers);
			
			echo '<div class="success">Ihre Adresse wurde erfolgreich hinzugefügt.<br>Ein Bestätigungs E-mail wurde Ihnen geschickt.<br>Danke.</div>';
		}
		catch (Exception $e)
		{
			echo '<div class="error">'.$e->getMessage ().'</div>';
		}
	}
	?>
</div>


<div id="imprint">
	<h1>Impressum</h1>
	<h2>Administration:</h2>
	Matthias Loitsch<br />
	<a href="mailto: admin@danielahantsch.com">admin@danielahantsch.com</a>
</div>
