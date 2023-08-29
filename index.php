<?php
/* XXX:
Webmail-Accounts to use: (asdad.adasd@web.de:passw0rd


*/
/**
 * @author func0der
 *
 * Please report bugs to the above contact places ;)
 */

	include('functions.php');

	if(!empty($_POST)){
		if($maintainceMode = false):
?>
	<h1>Maintaince mode</h1>
<p>Currently there are some problems with the api of Web.de.</p>
<p>I will try to fix these and republish the whole thing.</p>
<?php
	endif;
			if(
				(
					isset($_POST['email']) && 
					!empty($_POST['email'])
				) &&
				(
					isset($_POST['password']) && 
					!empty($_POST['password'])
				)
			){
				try{
					upgradeEmailAddress($_POST['email'], $_POST['password']);
				}
				catch(Exception $e){
					echo $e->getMessage();
				}
			}
			elseif(
				isset($_POST['address_list']) && 
				!empty($_POST['address_list'])
			){
				$temp = explode("\r\n", $_POST['address_list']);
				if(is_array($temp)){
					$addresses = array();
					foreach($temp as $data){
						list($email, $password) = explode(':', $data);
						$addresses[$email] = $password;
					}
					echo '<pre>' . upgradeEmailAddresses($addresses) . '</pre>';
				}
			}
?>
(Maybe) Success.<br />
<a href="" />Do another one</a>
<?php
	} // end if (empty($_POST))
	else{
?>

<html>
	<head>
		<title>Upgrade your Web.de Account to 500MB/1000MB</title>
		<meta http-equiv="language" content="EN">
<style type="text/css">
	.notice{
		background: #f3c5bd; /* Old browsers */
		background: -moz-linear-gradient(top,  #f3c5bd 0%, #e86c57 50%, #ea2803 51%, #ff6600 75%, #c72200 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f3c5bd), color-stop(50%,#e86c57), color-stop(51%,#ea2803), color-stop(75%,#ff6600), color-stop(100%,#c72200)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* IE10+ */
		background: linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3c5bd', endColorstr='#c72200',GradientType=0 ); /* IE6-9 */
		-moz-border-radius: 15px;
		-webkit-border-radius: 15px;
		border-radius: 15px;
		padding: 15px;
		margin-top: 30px;
}
</style>
	</head>
	<body>
	<?php
		if($maintainceMode):
	?>
		<div class="notice">
			This script is currently under maintenance.<br />
			Please come back later.<br />
			<br />
			The disappearing of this notice means the script is fully functioning again.
		</div>
	<?php
		endif;
	?>
		<h1>Web.de 1000MB upgrade without toolbar and MailChecker</h1>
		<h2>Foreword</h2>
		<div id="foreword">
			Please do not hesitate to use this site, because the design is so lousy.<br />
			I am a programmer and not a designer. And I didn't want to play around with CSS after the programming of the script.<br />
			I hope you will use the site anyway and see the real use of it.
		</div>

		<h2>What is this site for?</h2>
		<div id="site">
			<p>
				Like most of the visitors do know Web.de offers an upgrade for mail space from 12 MB up to 1000 MB, which is of course a joke in today's world just like the 12 MB and 500 MB before were. 
			</p>
			<p>
				Because Web.de does not like to support customer if they do not pay, this upgrade comes with the premission of installing their toolbar to your browser and logging in from it.
			</p>
			<p>
				Cause none of us likes to install stupid adware like that, logging all of our traffic and stuff i wrote this tiny little script to simulate the login from that toolbar and getting the whole thing done and receive the 500 MB anyway. 
			</p>
			<p>
				You may read through the whole site before using the upgrade form.
			</p>
		</div>

		<h2>How it works?</h2>
		<div id="tutorial">
			<ol>
				<li>
					Get your full Web.de email adress and password. <br />
					If you have more than one: No problem, just put them in the textarea and leave the 'email' and the 'password' field empty.
				</li>
				<li>
					Fill out the form beneath.
				</li>
				<li>
					Wait for the script to run through.
				</li>
				<li>
					Log in into your Web.de account. <br />
					If you were already before you started to use this script you have to logout over the "logut" link on the left hand side of the page and relogin again. <br />
					I have no real explanation for that, but i think it is because i did not copy the whole script but only the part to make the upgrade work.
				</li>
			</ol>
		</div>
		
		<h2>Upgrade form</h2>
		<div id="upgradeForm">
			<form action="" method="post" accept-charset="utf-8">
				<div id="single">
					<fieldset>
						<legend>Single-Upgrade</legend>
						<label for="email">Email</label>
						<input type="text" name="email" id="email" />
						<label for="password">Password</label>
						<input type="password" name="password" id="password" />
						<span>(Send button below)</span>
					</fieldset>
				</div>
				<p>
					or
				</p>
				<div id="multi" style="margin-top: 10px;">
					<fieldset>
						<legend>Multi-Upgrade</legend>
						<div class="explanation" style="margin-bottom: 10px;">
							Please provide address information in the following format<br />
							<b>emailAddress:password</b><br />
							For example: <b>name@web.de:gugu123</b><br />
							Provide one address per line, please.
						</div>
						<label for="address_list">Address list</label><br />
						<textarea name="address_list" rows="12" cols="50"></textarea>
					</fieldset>
				</div>

				<input type="submit" value="Send" />
			</form>
		</div>

		<h2>Information</h2>
		<div class="notice">
			<p>
				This generator does not validate the email addresses in any kind of way. You either give the right one it won't work.
			</p>
			<p>
				Passwords or email addresses were not saved. If you don't believe me, download the script yourself and use it on your server (Localhost included).<br />
			</p>
			<p>
				This script comes as is. I take no responsibility for any of the things happening after using it.<br />
				This is just to say it.
			</p>
		</div>

		<h2>Download</h2>
		<div class="download">
			<p>
				See the script <a href="https://github.com/func0der/web.de_upgrade">here</a>.
			</p>
		</div>
		<div class="language_chooser" style="position: absolute; top:0px; right: 15px;">
			<a href="index_de.php">Deutsch</a>
		</div>
	</body>
</html>
<?php
	} // end if (empty($_POST)) else
?>
