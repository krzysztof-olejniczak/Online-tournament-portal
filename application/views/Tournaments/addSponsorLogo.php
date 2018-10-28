<br/>
<br/>
<?php if($error == true): ?>
	<div class="error">Error occured, check that the file size is less than 1 MB and it's smaller than 1024x768</div>
	<br/>
<?php endif; ?>
<form class="form" action="http://<?php echo base_url();?>TournamentsForms/addSponsorLogo/<?php echo $tournamentId; ?>/" method="post" enctype="multipart/form-data">
	Image file 
	<input id="imageFile" class="inputField" type="file" name="imageFile" accept="gif|jpg|png"/>
	<br/>
	<br/>
	<input class="inputButton" type="submit" name="add" value="Add">
</form>