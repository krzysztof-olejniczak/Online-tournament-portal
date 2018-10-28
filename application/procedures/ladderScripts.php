<?php
	function ladderBuilder($allMatches) {
			$matchesShow = array();
			$x = 0;
			$y = 0;
			$matchesQueue = new SplQueue();
			for($i = 0; $i < sizeof($allMatches); $i++) {
				if($allMatches[$i]['leaf']) {
					$matchesQueue ->  enqueue($allMatches[$i]);
					if($allMatches[$i]['userId1'] != $allMatches[$i]['userId2']) {
						$matchesShow[$y][$x] = $allMatches[$i]['userUsername1'];
						$matchesShow[$y][$x + 1] = $allMatches[$i]['userUsername2'];
						$matchesShow[$y + 1][$x] = '|';
						$matchesShow[$y + 1][$x + 1] = '/';
					} else {
						$matchesShow[$y][$x] = $allMatches[$i]['userUsername1'];
						$matchesShow[$y][$x + 1] = '';
						$matchesShow[$y + 1][$x] = '|';
						$matchesShow[$y + 1][$x + 1] = '';
					}
					$x = $x + 2;
				}
			}
			$y += 2;
			$x = 0;
			$last = null;
			$queueSizeNotNulls = sizeof($matchesQueue);
			$count = 0;
			while($queueSizeNotNulls > 0) {
				$queueSizeTemp = $queueSizeNotNulls;
				for($i = 0; $i < $queueSizeTemp; $i++) {
					$count++;
					$actualMatch = $matchesQueue -> dequeue();
					$queueSizeNotNulls--;
					if($actualMatch['userId1'] == $actualMatch['userId2']) {
						$matchesShow[$y][$x] = '|';
						$matchesShow[$y][$x + 1] = '';
						$matchesShow[$y + 1][$x] = '|';
						$matchesShow[$y + 1][$x + 1] = '';
					} else if($actualMatch['winner1'] == $actualMatch['winner2'] && $actualMatch['winner2'] > 0) {
						$matchesShow[$y][$x] = $actualMatch['winnerUsername1'];
						$matchesShow[$y][$x + 1] = '';
						if($actualMatch['nextMatchId'] > 0) {
							if(($x / $y + 1) % 2 == 0) {
								$matchesShow[$y + 1][$x] = '/';
							} else {
								$matchesShow[$y + 1][$x] = '|';
							}
							$matchesShow[$y + 1][$x + 1] = '';
						}
					} else {
						if($actualMatch['winner1'] + $actualMatch['winner2'] == 0) {
							$matchesShow[$y][$x] = 'X';
						} else if($actualMatch['winner1'] == 0) {
							$matchesShow[$y][$x] = $actualMatch['winnerUsername2'].'?';
						} else {
							$matchesShow[$y][$x] = $actualMatch['winnerUsername1'].'?';
						}
						$matchesShow[$y][$x + 1] = '';
					}
					$x += 2;
					if($actualMatch['nextMatchId'] > 0) {
						for($j = 0; $j < sizeof($allMatches); $j++) {
							if($allMatches[$j]['id'] == $actualMatch['nextMatchId']) {
								if($last != $allMatches[$j]) {
									$matchesQueue ->  enqueue($allMatches[$j]);
									$queueSizeNotNulls++;
									$last = $allMatches[$j];
								}
								break;
							}
						}
					}
				}
				$y += 2;
				$x = 0;
			}
			return $matchesShow;
	}
?>