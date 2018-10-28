<br/>
<br/>
<?php if($error == true): ?>
	<div class="error">E-mail or password is incorrect or account not activated</div>
	<br/>
<?php endif; ?>
<form class="form" action="http://<?php echo base_url();?>Users/login/" method="post">
	E-mail 
	<input id="email" class="inputField" type="input" name="email" onblur="checkEmail('emailErrorText', 'email')"/>
	<br/>
	<div id="emailErrorText" class="error"></div>
	<br/>
	Password 
	<input id="password" class="inputField" type="password" name="password" onblur="usersCheckIfEmpty('passwordErrorText', 'password')"/>
	<br/>
	<div id="passwordErrorText" class="error"></div>
	<br/>
	<input class="inputButton" type="submit" name="login" value="Log in" onclick="return validateLogin();"/>
	<br/>
	<a class="link" href="http://<?php echo base_url();?>ForgottenPassword/forgottenPassword/">forgotten password</a>
</form>