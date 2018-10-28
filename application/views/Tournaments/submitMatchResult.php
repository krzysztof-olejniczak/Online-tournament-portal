<br/>
<br/>
<form class="form" action="http://<?php echo base_url();?>TournamentsForms/submitMatchResult/<?php echo $tournamentId; ?>/" method="post">
	Match against 
	<select name="enemy" class="inputField">
		<?php foreach($otherParticipants as $participant):?>
			<option value="<?php echo $participant['id']; ?>"><?php echo $participant['username']; ?></option>
		<?php endforeach; ?>
	</select>
	<br/>
	Who won? 
	<input type="radio" name="winner" value="me" checked="checked"> Me
	<input type="radio" name="winner" value="enemy"> Enemy
	<br/>
	<br/>
	<input class="inputButton" type="submit" value="Submit">
</form>