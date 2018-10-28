<br/>
<br/>
<?php if(!$restored) { ?>
<form class="form" action="http://<?php echo base_url();?>ForgottenPassword/restorePassword/<?php echo $forgottenPasswordCode ?>/" method="post">
	New password 
	<input id="password" class="inputField" type="password" name="password" onblur="checkPassword('passwordErrorText',
		'confirmPasswordErrorText', 'password', 'confirmPassword')"/>
	<br/>
	<div id="passwordErrorText" class="error"></div>
	<br/>
	Confirm new password 
	<input id="confirmPassword" class="inputField" type="password" name="confirmPassword" onblur="checkIfEqualsPassword(
		'confirmPasswordErrorText', 'password', this.value)"/>
	<br/>
	<div id="confirmPasswordErrorText" class="error"></div>
	<br/>
	<input class="inputButton" type="submit" name="changePassword" value="Change password" onclick="return checkPassword(
		'passwordErrorText', 'confirmPasswordErrorText', 'password', 'confirmPassword');"/>
</form>
<?php } else { ?>
<div class="info">Password has been changed</div>
<?php } ?>