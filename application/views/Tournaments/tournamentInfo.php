<br/>
<br/>
<?php if(isset($_GET['takingPart']) && $_GET['takingPart'] == true): ?>
	<div class="info">Now you are participating in tournament</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['logoAdded']) && $_GET['logoAdded'] == true): ?>
	<div class="info">Sponsor's logo sucessfully added</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['matchResultSubmitted']) && $_GET['matchResultSubmitted'] == true): ?>
	<div class="info">Match result submitted</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['matchResultWithdrawn']) && $_GET['matchResultWithdrawn'] == true): ?>
	<div class="error">Match result withdrawn</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['tournamentUpdate']) && $_GET['tournamentUpdate'] == true): ?>
	<div class="info">Tournament updated</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['matchResultsAlreadyExists']) && $_GET['matchResultsAlreadyExists'] == true): ?>
	<div class="info">Match result was already saved</div>
	<br/>
<?php endif; ?>
<div>
	<div class="tournamentName">
		<?php echo $tournament['name']; ?>
		<?php if($canEdit): ?>
			<a class="label" href="http://<?php echo base_url();?>TournamentsForms/newTournament/<?php echo $tournamentId; ?>">edit</a>
		<?php endif; ?>
	</div>
	<br/>
	<div class="tournamentInfoInList">Created by <?php echo $tournament['username']; ?> on <?php echo $tournament['registerTime']; ?></div>
	<div class="tournamentInfoInList">Status: <?php echo $tournament['status']; ?></div>

	<br/>
	<?php if($canParticipate): ?>
		<a class="label" href="http://<?php echo base_url();?>TournamentsForms/participate/<?php echo $tournamentId; ?>">participate</a>
	<?php endif; ?>
	<?php if($canSubmitMatchResult): ?>
		<a class="label" href="http://<?php echo base_url();?>TournamentsForms/submitMatchResult/<?php echo $tournamentId; ?>">submit match result</a>
	<?php endif; ?>
	<br/>
	<div id="map"></div>
	<div class="tournamentInfoInList">Discypline: <?php echo $tournament['discipline']; ?></div>
	<div class="tournamentInfoInList">Description: 
		<div><?php echo $tournament['description']; ?></div>
	</div>
	<br/>
	<div class="tournamentInfoInList">Actual number of participants: <?php echo $tournament['numberOfParticipants']; ?></div>
	<div class="tournamentInfoInList">Limit of participants: <?php echo $tournament['limitOfParticipants']; ?></div>
	<br/>
	<div class="tournamentInfoInList">Deadline of application: <?php echo $tournament['deadlineOfApplication']; ?></div>
	<div class="tournamentInfoInList">Starts on: <?php echo $tournament['timeOfStart']; ?></div>
	<div class="tournamentInfoInList">Duration: <?php echo $tournament['duration']; ?></div>
	<br/>
	<?php foreach($sponsorLogos as $sponsorLogo): ?>
		<img class="sponsorLogo" src="http://<?php echo base_url().$sponsorLogosLocation.$sponsorLogo['logoName']; ?>"/>
	<?php endforeach; ?>
	<?php if($canAddSponsorLogo): ?>
		<br/>
		<br/>
		<a class="label" href="http://<?php echo base_url();?>TournamentsForms/addSponsorLogo/<?php echo $tournamentId; ?>">add sponsor's logo</a>
	<?php endif; ?>
	<br/>
	<br/>
	<?php if($tournament['status'] == 'planned'): ?>
		<div>
			<div class="column">
				Rank<br/><br/>
				<?php for($i = 1; $i<=sizeof($participants); $i++): ?>
					<p><?php echo $i; ?></p>
				<?php endfor; ?>
			</div>
			<div class="column">
				Username<br/><br/>
				<?php foreach($participants as $participant): ?>
					<p><?php echo $participant['username']; ?></p>
				<?php endforeach; ?>
			</div>
			<div class="column">
				Licence number<br/><br/>
				<?php foreach($participants as $participant): ?>
					<p><?php echo $participant['numberOfLicence']; ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if($tournament['status'] != 'planned'): ?>
		<br/>
		<br/>
		<div>Matches</div>
		<br/>
		<?php
			echo '<table><tr>';
			for($y = 0; $y < sizeof($matchesShow); $y++):
				for($x = 0; $x < sizeof($matchesShow[$y]); $x++):
					echo '<td>'.$matchesShow[$y][$x].'</td>';
				endfor;
				echo '</tr><tr>';
			endfor;
			echo '</tr></table>';
		?>
		<br/>
		<br/>
		<br/>
		<br/>
	<?php endif; ?>
</div>