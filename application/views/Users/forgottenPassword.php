<br/>
<br/>
<?php if($emailSent) { ?>
	<div class="info">E-mail has been sent</div>
<?php } elseif($badEmail) { ?>
	<div class="error">Incorrect e-mail address</div>
<?php } else { ?>
	<form class="form" action="http://<?php echo base_url();?>ForgottenPassword/forgottenPassword/" method="post">
		Your e-mail 
		<input id="email" class="inputField" type="input" name="email" onblur="checkEmail('emailErrorText', 'email')"/>
		<br/>
		<div id="emailErrorText" class="error"></div>
		<br/>
		<input class="inputButton" type="submit" name="send" value="Send e-mail"
			onclick="return checkEmail('emailErrorText', 'email');"/>
	</form>
<?php } ?>