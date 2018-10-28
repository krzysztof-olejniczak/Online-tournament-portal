function validateRegister() {
	var errorTextIds = ['usernameErrorText', 'firstnameErrorText', 'surnameErrorText'];
	var fieldIds = ['username', 'firstname', 'surname'];
	for(var i = 0; i < errorTextIds.length; i++) {
		if(!usersCheckIfEmpty(errorTextIds[i], fieldIds[i])) {
			return false;
		}
	}
	if(!checkEmail('emailErrorText', 'email')) {
		return false;
	}
	if(!checkPassword('passwordErrorText', 'confirmPasswordErrorText', 'password', 'confirmPassword')) {
		return false;
	}
	if(!confirm('Are you sure want to create new account?')) {
		return false;
	}
	return true;
}

function validateLogin() {
	if(!checkEmail('emailErrorText', 'email')) {
		return false;
	}
	if(!usersCheckIfEmpty('passwordErrorText', 'password')) {
		return false;
	}
	return true;
}

function usersCheckIfEmpty(errorTextId, fieldId) {
	if(document.getElementById(fieldId).value.length == 0
			|| containsOnlyWhiteCharacters(document.getElementById(fieldId).value)) {
		document.getElementById(errorTextId).innerHTML = 'the field cannot be empty';
		return false;
	} else {
		document.getElementById(errorTextId).innerHTML = '';
		return true;
	}
}

function containsOnlyWhiteCharacters(str) {
	var ws = "\t\n\r ";
	for (var i = 0; i < str.length; i++) {
		var c = str.charAt(i);
		if(ws.indexOf(c) == -1) {
			return false;
		}
	}
	return true;
}

function checkPassword(passwordErrorTextId, confirmPasswordErrorTextId, passwordFieldId, confirmPasswordFieldId) {
	var result = true;
	var passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;
	if(!passwordPattern.test(document.getElementById(passwordFieldId).value)) {
		result = false;
		document.getElementById(passwordErrorTextId).innerHTML = 'password has to contain at least 6 characters including one digit and one specjal sign';
	} else {
		document.getElementById(passwordErrorTextId).innerHTML = '';
	}
	if(!checkIfEqualsPassword(confirmPasswordErrorTextId, passwordFieldId, confirmPasswordFieldId)) {
		result = false;
	}
	return result;
}

function checkEmail(emailErrorTextId, emailFieldId) {
	var emailPattern = /[a-zA-Z_0-9\.]+@[a-zA-Z_0-9\.]+\.[a-zA-Z][a-zA-Z]+/;
	if(emailPattern.test(document.getElementById(emailFieldId).value)) {
		document.getElementById(emailErrorTextId).innerHTML = '';
		return true;
	} else {
		document.getElementById(emailErrorTextId).innerHTML = 'email address incorrect';
		return false;
	}
}

function checkIfEqualsPassword(confirmPasswordErrorTextId, passwordFieldId, confirmPasswordFieldId) {
	if(document.getElementById(confirmPasswordFieldId).value == document.getElementById(passwordFieldId).value) {
		document.getElementById(confirmPasswordErrorTextId).innerHTML = '';
		return true;
	} else {
		document.getElementById(confirmPasswordErrorTextId).innerHTML = 'passwords are different';
		return false;
	}
}