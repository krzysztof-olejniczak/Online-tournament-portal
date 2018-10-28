<br/>
<br/>
<?php if(isset($_GET['alreadyTakingPart']) && $_GET['alreadyTakingPart'] == true): ?>
	<div class="error">You are already taking part in tournament</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['limitOfParticipantsAchieved']) && $_GET['limitOfParticipantsAchieved'] == true): ?>
	<div class="error">Limit Of Participants achieved</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['rankAlreadyExists']) && $_GET['rankAlreadyExists'] == true): ?>
	<div class="error">Rank already used in this tournament</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['licenceAlreadyExists']) && $_GET['licenceAlreadyExists'] == true): ?>
	<div class="error">Licence already used in this tournament</div>
	<br/>
<?php endif; ?>
<form class="form" action="http://<?php echo base_url();?>TournamentsForms/participate/<?php echo $tournamentId; ?>/" method="post">
	Licence number 
	<input id="licenceNumber" class="inputField" type="input" name="licenceNumber" onblur="checkIfEmpty('licenceNumberErrorText', 'licenceNumber')"/>
	<br/>
	<div id="licenceNumberErrorText" class="error"></div>
	<br/>
	Rank 
	<input id="rank" class="inputField" type="number" name="rank" onchange="checkIfGreaterThanZero('rankErrorText', 'rank')"/>
	<br/>
	<div id="rankErrorText" class="error"></div>
	<br/>
	<input class="inputButton" type="submit" name="create" value="Participate" onclick="return validateParticipate();"/>
</form>