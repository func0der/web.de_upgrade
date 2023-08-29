<?php
/**
 * @author func0der
 *
 * Please report bugs to the above contact places ;)
 */
?>
<html>
	<head>
		<title>Web.de-Account auf 500MB/1000MB erweitern</title>
		<meta http-equiv="language" content="DE">
	</head>
	<body>
		<h1>Web.de Postfach auf 1000MB erweitern ohne Toolbar und ohne MailChecker</h1>
		<h2>Vorwort</h2>
		<div id="foreword">
			Zu allererst einmal lasst euch bitte nicht von dem Design der Seite abschrecken.<br />
			Ich bin Programmierer und kein Designer und hatte nach der Entwicklung dieses Skripts auch keine Lust mehr mit CSS rumzuspielen. ;P <br />
			Ich hoffe, ihr schaut euch die Seite trotzdem an und seht den eigentlichen Nutzen darin.
		</div>

		<h2>F&uuml;r wen ist diese Seite?</h2>
		<div id="site">
			<p>
				Wie viele der Besucher wissen, hat Web.de angefangen eine Erweiterung des maximalen Speicherplatzes f&uuml;r Emails anzubieten. So stellen sie jetzt anstatt 12 MB bis zu 1000 MB bereit, was genau wie die 12 MB bzw. 500 MB vorher schon lange nicht mehr zeitgem&auml;&szlig; ist.
			</p>
			<p>
				Web.de will ja auch eigentlich keine Free-User und daher muss man auch bei diesem Upgrade eine bittere Pille schlucken: die Installation der Web.de-Toolbar und der anschlie&szlig;ende Login in dieser.
			</p>
			<p>
Und so, weil keiner von uns es mag irgendwelche bl&ouml;den Toolbars zu installieren, die uns durch das Internet verfolgen, habe ich dieses Skript geschrieben, dass diesen ganzen Prozess einfach simuliert. So bekommt man trotzem, was man will ohne den M&uuml;ll zu installieren, den man nicht braucht.
			</p>
			<p>
				Am besten lest ihr euch erst einmal die gesamte Seite durch, bevor ihr das Upgrade-Formular benutzt.
			</p>
		</div>

		<h2>Wie funktioniert es?</h2>
		<div id="tutorial">
			<ol>
				<li>
					Haltet eure volle Web.de-E-Mail-Adresse bereit und das Password bereit.<br />
					Falls ihr mehr als eine habt: Kein Problem, f&uuml;gt sie einfach in das Textfeld unten ein und lass sowohl das Feld f&uuml;r "Email" als auch das Feld f&uuml;r "Passwort" leer.
				</li>
				<li>
					F&uuml;llt das Formular unten aus.
				</li>
				<li>
					Wartet bis das Skript durch gelaufen ist.
				</li>
				<li>
					Loggt euch in euren Web.de-Account ein.<br />
					Falls ihr schon vorher eingeloggt wart, dann m&uuml;sst ihr euch einmal &uuml;ber den Button links ausloggen und danach wieder ein. <br />
					I habe keine Ahnung, warum das so ist. Ich vermute mal, dass das daran liegt, dass ich das Skript nur bis zu dem Punkt kopiert habe, der zum Upgrade n&ouml;tig war.
				</li>
			</ol>
		</div>
		
		<h2>Upgrade-Formular</h2>
		<div id="upgradeForm">
			<form action="index.php" method="post" accept-charset="utf-8">
				<div id="single">
					<fieldset>
						<legend>Einzel-Upgrade</legend>
						<label for="email">E-Mail</label>
						<input type="text" name="email" id="email" />
						<label for="password">Passwort</label>
						<input type="password" name="password" id="password" />
						<span>(Abschicken-Button unten)</span>
					</fieldset>
				</div>
				<p>
					oder
				</p>
				<div id="multi" style="margin-top: 10px;">
					<fieldset>
						<legend>Bulk-Upgrade</legend>
						<div class="explanation" style="margin-bottom: 10px;">
							Bitte gebt die Addressen wie folgt an<br />
							<b>emailAdresse:passwort</b><br />
							Zum Beispiel: <b>name@web.de:gugu123</b><br />
							Gebt bitte nur eine Adresse pro Zeile ein.
						</div>
						<label for="address_list">Adressen-Liste</label><br />
						<textarea name="address_list" rows="12" cols="50"></textarea>
					</fieldset>
				</div>

				<input type="submit" value="Abschicken" />
			</form>
		</div>

		<h2>Informationen</h2>
		<div class="notice">
			<p>
				Dieser Generator validiert die eingegeben E-Mail-Adressen nicht. Ihr m&uuml;sst also selber sicher stellen, dass ihr die richtige Adresse eingebt.
			</p>
			<p>
				Passw&ouml;rter und E-Mail-Addressen werden nicht gespeichert. Wenn ihr das nicht glauben k&ouml;nnt, dann downloadet euch das Skript und setzt es auf einem beliebigen Server auf (Apache auf eurem Rechner eingeschlossen).<br />
			</p>
			<p>
				Das Skript kommt, wie es ist. Ich &uuml;bernehme keinerlei Haftung f&uuml;r irgendwelche Sch&auml;den, die ich nicht vorher gesehen habe oder durch die Nutzung des Skriptes entstehen.<br />
				Das nur, weil es sein muss.
			</p>
		</div>

		<h2>Download</h2>
		<div class="download">
			<p>
                <a href="https://github.com/func0der/web.de_upgrade">Hier</> klicken, um das Skript zu downloaden.
			</p>
		</div>
		<div class="language_chooser" style="position: absolute; top:0px; right: 15px;">
			<a href="./">English</a>
		</div>
	</body>
</html>
