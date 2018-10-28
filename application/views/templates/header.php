<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Sail Contests - <?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="author" content="Krzysztof Olejniczak">
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="icon" href="http://<?php echo base_url();?>assets/imgs/icon.png">
	<?php
		$stylesPath = 'assets/css/';
		$styles = array('mainStyles.css', 'formsStyles.css', 'tournamentsStyles.css', 'tournamentInfoStyles.css');
		foreach($styles as $style):
	?>
		<link rel="stylesheet" type="text/css" href="http://<?php echo base_url().$stylesPath.$style;?>" title="Arkusz stylów CSS">
	<?php
		endforeach;
		$scriptsPath = 'assets/js/';
		$scripts = array('usersFormsCheck.js', 'tournamentsFormsCheck.js', 'mapScripts.js');
		foreach($scripts as $script):
	?>
		<script src="http://<?php echo base_url().$scriptsPath.$script;?>" lang=javascript type="text/javascript"></script>
	<?php endforeach; ?>
	<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyAx0liueYFamR-gOITF73amFAkgGptK-ws" type="text/javascript"></script>
</head>
<body <?php echo ($title=='Tournament details' ? 'onload="initMap(\''.$tournament['place'].'\')"' : ''); ?>>
	<div class="top">
		<div class="topContent">
			<img src="http://<?php echo base_url();?>assets/imgs/top.png"/>
			<div class="labels">
				<a class="tournamentLink" href="http://<?php echo base_url();?>Tournaments/tournaments/">
					<div class="label <?php echo ($title == 'Tournaments' ? 'activeTournamentsLabel':'tournamentsLabel'); ?>">Tournaments</div>
				</a>
				<?php if(isset($userId) && $userId != NULL): ?>
					<a class="tournamentLink" href="http://<?php echo base_url();?>Tournaments/tournaments/<?php echo $userId ?>/">
						<div class="label <?php echo ($title == 'My tournaments' ? 'activeUserLabel':'userLabel'); ?>">My tournaments</div>
					</a>
					<a class="tournamentLink" href="http://<?php echo base_url();?>Users/logout/">
						<div class="label <?php echo ($title == 'Log out' ? 'activeUserLabel':'userLabel'); ?>">Log out</div>
					</a>
				<?php else: ?>
					<a class="tournamentLink" href="http://<?php echo base_url();?>Users/register/">
						<div class="label <?php echo ($title == 'Register' ? 'activeUserLabel':'userLabel'); ?>">Register</div>
					</a>
					<a class="tournamentLink" href="http://<?php echo base_url();?>Users/login/">
						<div class="label <?php echo ($title == 'Login' ? 'activeUserLabel':'userLabel'); ?>">Login</div>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="title"><?php echo $title ?></div>
