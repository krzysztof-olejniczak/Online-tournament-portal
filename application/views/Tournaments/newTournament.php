<br/>
<br/>
<?php if($tournamentAlreadyExists == true): ?>
	<div class="error">Tournament already exists in database, try other name</div>
	<br/>
<?php endif; ?>
<form class="form" action="http://<?php echo base_url();?>TournamentsForms/newTournament/<?php echo ($tournamentId >= 0 ? $tournamentId.'/' : '') ?>"
		method="post">
	Name 
	<input id="name" value="<?php echo $name; ?>" class="inputField" type="input" name="name" onblur="checkIfEmpty('nameErrorText', 'name')"/>
	<br/>
	<div id="nameErrorText" class="error"></div>
	<br/>
	Place 
	<input id="place" value="<?php echo $place; ?>" class="inputField" type="input" name="place" onblur="checkIfEmpty('placeErrorText', 'place')"/>
	<br/>
	<div id="placeErrorText" class="error"></div>
	<br/>
	Discipline 
	<input id="discipline" value="<?php echo $discipline; ?>" class="inputField" type="input" name="discipline"
		onblur="checkIfEmpty('disciplineErrorText', 'discipline')"/>
	<br/>
	<div id="disciplineErrorText" class="error"></div>
	<br/>
	Description<br/>
	<textarea id="description" class="inputTextarea" name="description"
		onblur="checkIfEmpty('descriptionErrorText', 'description')"><?php echo $description; ?></textarea> 
	<br/>
	<div id="descriptionErrorText" class="error"></div>
	<br/>
	Limit of participants 
	<input id="limitOfParticipants" value="<?php echo $limitOfParticipants; ?>" class="inputField" type="number" name="limitOfParticipants"
		onchange="checkIfGreaterThanZero('limitOfParticipantsErrorText', 'limitOfParticipants')"/>
	<br/>
	<div id="limitOfParticipantsErrorText" class="error"></div>
	<br/>
	Time of application deadline
	<input id="deadlineOfApplicationHours"
		value="<?php echo (sizeof($deadlineOfApplication) > 0 ? substr($deadlineOfApplication, strpos($deadlineOfApplication, ' ') + 1, 2) : ''); ?>"
		class="inputNumber" type="number" name="deadlineOfApplicationHours"
		onchange="checkTimeDateOfApplicationDeadline('deadlineOfApplicationTimeDateErrorText', 'timeDateOfStartErrorText',
		'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate', 'timeOfStartHours',
		'timeOfStartMinutes', 'timeOfStartDate')"/>
	: <input id="deadlineOfApplicationMinutes"
		value="<?php echo (sizeof($deadlineOfApplication) > 0 ? substr($deadlineOfApplication, strpos($deadlineOfApplication, ' ') + 4, 2) : ''); ?>"
		class="inputNumber" type="number" name="deadlineOfApplicationMinutes"
		onchange="checkTimeDateOfApplicationDeadline('deadlineOfApplicationTimeDateErrorText', 'timeDateOfStartErrorText',
		'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate', 'timeOfStartHours',
		'timeOfStartMinutes', 'timeOfStartDate')"/>
	<br/>
	Date of application deadline
	<input id="deadlineOfApplicationDate"
		value="<?php echo (sizeof($deadlineOfApplication) > 0 ? substr($deadlineOfApplication, 0, strpos($deadlineOfApplication, ' ')) : ''); ?>"
		class="inputField" type="input" name="deadlineOfApplicationDate"
		onblur="checkTimeDateOfApplicationDeadline('deadlineOfApplicationTimeDateErrorText', 'timeDateOfStartErrorText',
		'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate', 'timeOfStartHours',
		'timeOfStartMinutes', 'timeOfStartDate')"/>
	<br/>
	<div id="deadlineOfApplicationTimeDateErrorText" class="error"></div>
	<br/>
	Time of start 
	<input id="timeOfStartHours"
		value="<?php echo (sizeof($timeOfStart) > 0 ? substr($timeOfStart, strpos($timeOfStart, ' ') + 1, 2) : ''); ?>" class="inputNumber"
		type="number" name="timeOfStartHours" onchange="checkTimeDateOfStart('timeDateOfStartErrorText', 'timeOfStartHours', 'timeOfStartMinutes',
		'timeOfStartDate', 'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate')"/>
	: <input id="timeOfStartMinutes"
		value="<?php echo (sizeof($timeOfStart) > 0 ? substr($timeOfStart, strpos($timeOfStart, ' ') + 4, 2) : ''); ?>"
		class="inputNumber" type="number" name="timeOfStartMinutes" onchange="checkTimeDateOfStart('timeDateOfStartErrorText', 'timeOfStartHours',
		'timeOfStartMinutes', 'timeOfStartDate', 'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate')"/>
	<br/>
	Date of start 
	<input id="timeOfStartDate" value="<?php echo (sizeof($timeOfStart) > 0 ? substr($timeOfStart, 0, strpos($timeOfStart, ' ')) : ''); ?>"
		class="inputField" type="input" name="timeOfStartDate" onblur="checkTimeDateOfStart('timeDateOfStartErrorText', 'timeOfStartHours',
		'timeOfStartMinutes', 'timeOfStartDate', 'deadlineOfApplicationHours', 'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate')"/>
	<br/>
	<div id="timeDateOfStartErrorText" class="error"></div>
	<br/>
	Duration 
	<input id="durationHours" value="<?php echo (sizeof($duration) > 0 ? substr($duration, 0, 2) : ''); ?>" class="inputNumber"
		type="number" name="durationHours" onchange="checkDuration('durationTimeErrorText', 'durationHours', 'durationMinutes')"/>
	: <input id="durationMinutes" value="<?php echo (sizeof($duration) > 0 ? substr($duration, 3, 2) : ''); ?>" class="inputNumber"
		type="number" name="durationMinutes" onchange="checkDuration('durationTimeErrorText', 'durationHours', 'durationMinutes')"/>
	<br/>
	<div id="durationTimeErrorText" class="error"></div>
	<br/>
	<input class="inputButton" type="submit" name="create" value="<?php echo ($name == '') ? 'Create' : 'Save' ?>"
		onclick="return validateNewTournament(<?php echo ($title=='Edit tournament' ? 'edit' : 'new' ) ?>);"/>
</form>