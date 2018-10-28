var dateIncorrectStatement = 'date incorrect, correct format: YYYY-MM-DD';
var datePastStatement = 'date cannot be from the past';
var dateStartLaterThanDeadlineStatement = 'date of start must be later than date of deadline';
var timeIncorrectStatement = 'number of hours or minutes incorrect';
var emptyFieldStatement = 'the field cannot be empty';
var fieldLowerOrEqualThanZeroStatement = 'the field must be greater than zero';

function validateParticipate() {
	if(!checkIfEmpty('licenceNumberErrorText', 'licenceNumber')) {
		return false;
	}
	if(!checkIfGreaterThanZero('rankErrorText', 'rank')) {
		return false;
	}
	if(!confirm('Are you sure want to participate?')) {
		return false;
	}
	return true;
}

function validateNewTournament(action) {
	if(!checkIfEmpty('nameErrorText', 'name')) {
		return false;
	}
	if(!checkIfEmpty('placeErrorText', 'place')) {
		return false;
	}
	if(!checkIfGreaterThanZero('limitOfParticipantsErrorText', 'limitOfParticipants')) {
		return false;
	}
	if(!checkTimeDateOfApplicationDeadline('deadlineOfApplicationTimeDateErrorText', 'timeDateOfStartErrorText',
			'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate',
			'timeOfStartHours', 'timeOfStartMinutes', 'timeOfStartDate')) {
		return false;
	}
	if(!checkTimeDateOfStart('timeDateOfStartErrorText', 'timeOfStartHours', 'timeOfStartMinutes',
			'timeOfStartDate', 'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate')) {
		return false;
	}
	if(!checkDuration('durationTimeErrorText', 'durationHours', 'durationMinutes')) {
		return false;
	}
	if(action == 'new' && !confirm('Are you sure want to create new tournament?')) {
		return false;
	}
	return true;
}

function checkIfEmpty(errorDivId, elementId) {
	if(document.getElementById(elementId).value.length == 0 || containsOnlyWhiteCharacters(document.getElementById(elementId).value)) {
		document.getElementById(errorDivId).innerHTML = emptyFieldStatement;
		return false;
	} else {
		document.getElementById(errorDivId).innerHTML = '';
		return true;
	}
}

function containsOnlyWhiteCharacters(str){
	var ws = "\t\n\r ";
	for(var i = 0; i < str.length; i++){
		var c = str.charAt(i);
		if (ws.indexOf(c) == -1){
			return false;
		}
	}
	return true;
}

function checkIfGreaterThanZero(errorDivId, elementId) {
	if(document.getElementById(elementId).value <= 0 || document.getElementById(elementId).value.length == 0) {
		document.getElementById(errorDivId).innerHTML = fieldLowerOrEqualThanZeroStatement;
		return false;
	} else {
		document.getElementById(errorDivId).innerHTML = '';
		return true;
	}
}

function checkTimeDateOfApplicationDeadline(errorDivId, errorTimeDateOfStartDivId, deadlineOfApplicationHoursId,
		deadlineOfApplicationMinutesId, deadlineOfApplicationDateId, numberOfHoursStartId, numberOfMinutesStartId, dateOfStartId) {
	var numberOfHoursDeadline = document.getElementById(deadlineOfApplicationHoursId).value;
	var numberOfMinutesDeadline = document.getElementById(deadlineOfApplicationMinutesId).value;
	var dateOfDeadline = document.getElementById(deadlineOfApplicationDateId).value;
	var numberOfHoursStart = document.getElementById(numberOfHoursStartId).value;
	var numberOfMinutesStart = document.getElementById(numberOfMinutesStartId).value;
	var dateOfStart = document.getElementById(dateOfStartId).value;
	checkTimeDateOfStart(errorTimeDateOfStartDivId, numberOfHoursStartId, numberOfMinutesStartId, dateOfStartId,
		deadlineOfApplicationHoursId, deadlineOfApplicationMinutesId, deadlineOfApplicationDateId);
	if(!checkDate(deadlineOfApplicationDateId)) {
		document.getElementById(errorDivId).innerHTML = dateIncorrectStatement;
		return false;
	} else if(!checkTime(deadlineOfApplicationHoursId, deadlineOfApplicationMinutesId)) {
		document.getElementById(errorDivId).innerHTML = timeIncorrectStatement;
		return false;
	} else if(new Date().getTime() >= new Date(dateOfDeadline.substr(0, 4), dateOfDeadline.substr(5, 2),
			dateOfDeadline.substr(8, 2), numberOfHoursDeadline, numberOfMinutesDeadline, 0, 0).getTime()) {
		document.getElementById(errorDivId).innerHTML = datePastStatement;
		return false;
	} else {
		document.getElementById(errorDivId).innerHTML = '';
		return true;
	}
}

function checkTimeDateOfStart(errorDivId, numberOfHoursId, numberOfMinutesId, dateId, deadlineOfApplicationHoursId,
		deadlineOfApplicationMinutesId, deadlineOfApplicationDateId) {
	var numberOfHours = document.getElementById(numberOfHoursId).value;
	var numberOfMinutes = document.getElementById(numberOfMinutesId).value;
	var date = document.getElementById(dateId).value;
	var numberOfHoursDeadline = document.getElementById(deadlineOfApplicationHoursId).value;
	var numberOfMinutesDeadline = document.getElementById(deadlineOfApplicationMinutesId).value;
	var dateOfDeadline = document.getElementById(deadlineOfApplicationDateId).value;
	if(!checkDate(dateId)) {
		document.getElementById(errorDivId).innerHTML = dateIncorrectStatement;
		return false;
	} else if(!checkTime(numberOfHoursId, numberOfMinutesId)) {
		document.getElementById(errorDivId).innerHTML = timeIncorrectStatement;
		return false;
	} else if(new Date().getTime() >= new Date(date.substr(0, 4), date.substr(5, 2), date.substr(8, 2), numberOfHours, numberOfMinutes, 0, 0).getTime()) {
		document.getElementById(errorDivId).innerHTML = datePastStatement;
		return false;
	} else if(new Date(dateOfDeadline.substr(0, 4), dateOfDeadline.substr(5, 2), dateOfDeadline.substr(8, 2),
			numberOfHoursDeadline, numberOfMinutesDeadline, 0, 0).getTime() > new Date(date.substr(0, 4),
			date.substr(5, 2), date.substr(8, 2), numberOfHours, numberOfMinutes, 0, 0).getTime()) {
		document.getElementById(errorDivId).innerHTML = dateStartLaterThanDeadlineStatement;
		return false;
	} else {
		document.getElementById(errorDivId).innerHTML = '';
		return true;
	}
}

function checkDuration(errorDivId, numberOfHoursId, numberOfMinutesId) {
	if(!checkTime(numberOfHoursId, numberOfMinutesId)) {
		document.getElementById(errorDivId).innerHTML = timeIncorrectStatement;
		return false;
	} else {
		document.getElementById(errorDivId).innerHTML = '';
		return true;
	}
}

function checkDate(dateId) {
	var date = document.getElementById(dateId).value;
	if(date.length < 10 || date[4] != '-' || date[7] != '-') {
		return false;
	}
	var days = date.substr(8, 2);
	var month = date.substr(5, 2);
	var year = date.substr(0, 4);
	if(month > 12 || month < 1) {
		return false;
	} else if((month == 4 || month == 6 || month == 9 || month == 11) && (days > 30 || days < 1)) {
		return false;
	} else if(month == 2 && year%4 != 0 && (days > 28 || days < 1)) {
		return false;
	} else if(month == 2 && year%4 == 0 && (days > 29 || days < 1)) {
		return false;
	} else if(days > 31 || days < 1) {
		return false;
	} else {
		return true;
	}
}

function checkTime(hourId, minutesId) {
	var hour = document.getElementById(hourId).value;
	var minutes = document.getElementById(minutesId).value;
	if(hour >= 24 || hour < 0 || hour.length == 0) {
		return false;
	} else if(minutes >= 60 || minutes < 0 || minutes.length == 0) {
		return false;
	} else {
		return true;
	}
}