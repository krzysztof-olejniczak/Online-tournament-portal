<br/>
<br/>
<?php if($userExists == true): ?>
	<div class="error">Username or email already exists in database</div>
	<br/>
<?php endif; ?>
<form class="form" action="http://<?php echo base_url();?>Users/register/" method="post">
	Username 
	<input id="username" class="inputField" type="input" name="username" onblur="usersCheckIfEmpty('usernameErrorText', 'username')"/>
	<br/>
	<div id="usernameErrorText" class="error"></div>
	<br/>
	Firstname 
	<input id="firstname" class="inputField" type="input" name="firstname" onblur="usersCheckIfEmpty('firstnameErrorText', 'firstname')"/>
	<br/>
	<div id="firstnameErrorText" class="error"></div>
	<br/>
	Surname 
	<input id="surname" class="inputField" type="input" name="surname" onblur="usersCheckIfEmpty('surnameErrorText', 'surname')"/>
	<br/>
	<div id="surnameErrorText" class="error"></div>
	<br/>
	E-mail address 
	<input id="email" class="inputField" type="input" name="email" onblur="checkEmail('emailErrorText', 'email')"/>
	<br/>
	<div id="emailErrorText" class="error"></div>
	<br/>
	Password 
	<input id="password" class="inputField" type="password" name="password" onblur="checkPassword('passwordErrorText',
		'confirmPasswordErrorText', 'password', 'confirmPassword')"/>
	<br/>
	<div id="passwordErrorText" class="error"></div>
	<br/>
	Confirm password 
	<input id="confirmPassword" class="inputField" type="password" name="confirmPassword" onblur="checkIfEqualsPassword(
		'confirmPasswordErrorText', 'password', 'confirmPassword')"/>
	<br/>
	<div id="confirmPasswordErrorText" class="error"></div>
	<br/>
	<input class="inputButton" type="submit" name="register" value="Register" onclick="return validateRegister();"/>
</form>