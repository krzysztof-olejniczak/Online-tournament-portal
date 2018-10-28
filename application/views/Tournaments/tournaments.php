<br/>
<br/>
<?php if(isset($_GET['logIn']) && $_GET['logIn'] == true): ?>
	<div class="info">Successfully logged in</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['logOut']) && $_GET['logOut'] == true): ?>
	<div class="info">Successfully logged out</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['register']) && $_GET['register'] == true): ?>
	<div class="info">Successfully registered, now you have to activate account</div>
	<br/>
<?php endif; ?>
<?php if(isset($_GET['tournamentCreated']) && $_GET['tournamentCreated'] == true): ?>
	<div class="info">Tournament sucessfully created</div>
	<br/>
<?php endif; ?>
<br/>
<br/>
<form class="form" action="http://<?php echo base_url();?>Tournaments/Tournaments/<?php echo ($userTournaments >= 0 ? $userTournaments.'/' : ''); ?>"
		method="get">
	<input class="inputField" value="<?php echo $searchQuery;?>" type="input" name="searchQuery"/>
	<input class="inputButton" type="submit" name="search" value="Search"/>
</form>
<br/>
<a class="label" href="http://<?php echo base_url();?>TournamentsForms/newTournament/">new tournament</a>
<br/>
<br/>
<?php foreach($tournaments as $tournament): ?>
	<a class="tournamentLink" href="http://<?php echo base_url(); ?>Tournaments/tournamentInfo/<?php echo $tournament['id']; ?>">
		<div class="singleTournament <?php echo $tournament['class']; ?>">
			<div class="tournamentName"><?php echo $tournament['name']; ?></div>
			<div class="tournamentInfoInList">Created by <?php echo $tournament['username']; ?> on <?php echo $tournament['registerTime']; ?> 
				status: <?php echo $tournament['status']; ?></div>
			<div class="tournamentInfoInList">Place: <?php echo $tournament['place']; ?></div>
			<div class="tournamentInfoInList">
				Participants: <?php echo $tournament['numberOfParticipants'].'/'.$tournament['limitOfParticipants']; ?>
			</div>
			<div class="tournamentInfoInList">Deadline of application: <?php echo $tournament['deadlineOfApplication']; ?> 
				Starts on: <?php echo $tournament['timeOfStart']; ?> Duration: <?php echo $tournament['duration']; ?>
			</div>
		</div>
	</a>
<?php endforeach; ?>
<?php if($startRow > 0): ?>
	<a class="tournamentLink" href="http://<?php echo base_url();?>Tournaments/tournaments/
		<?php echo ($userTournaments >= 0 ? $userTournaments.'/' : '').'?startRow='.($startRow - $showRows).'&showRows='.$showRows; ?>">
		previous page</a>&nbsp;&nbsp;&nbsp; 
<?php endif; ?>
<?php if($startRow + 10 < $numberOfResults): ?>
	<a class="tournamentLink" href="http://<?php echo base_url();?>Tournaments/tournaments/
		<?php echo ($userTournaments >= 0 ? $userTournaments.'/' : '').'?startRow='.($startRow + $showRows).'&showRows='.$showRows;; ?>">
		next page</a>
<?php endif; ?>
<br/>
<br/>
<br/>