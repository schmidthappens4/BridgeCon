<?php
	require_once ('libs/MysqliDb.php');
  
	$hostname = "localhost";
	$username = "bridgecon1";
	$password = "Sp1d3rm@n";
	$database = "test";
	
	$db = new MysqliDb ($hostname, $username, $password, $database);
	$db->connect();
	
	$exhibit_selected = $_POST['exhibit_select'];
	
	$query = "(
	SELECT exhibit.exhibit_number, score.construction_score, score.finish_score, score.accuracy_score, score.intangible_score, score.total_score, judge.judge_number FROM score
	LEFT JOIN exhibit
	ON score.exhibit_id=exhibit.exhibit_id
	LEFT JOIN judge
	ON score.judge_id=judge.judge_id
	WHERE exhibit.exhibit_id='$exhibit_selected'
	ORDER BY total_score DESC
	)";
?>

<div class="col-md-12">
	<table id="show_scores" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Exhibit Number</th>
				<th>Construction</th>
				<th>Finish</th>
				<th>Accuracy</th>
				<th>Intangible</th>
				<th>Total</th>
				<th>Judge</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$score_result = $db->rawQuery ($query);
		if ($db->count > 0)
		foreach ($score_result as $score)
		{
			$exhibit_number = $score['exhibit_number'];
			$construction_score = $score['construction_score'];
			$finish_score = $score['finish_score'];
			$accuracy_score = $score['accuracy_score'];
			$intangible_score = $score['intangible_score'];
			$total_score = $score['total_score'];
			$judge_number = $score['judge_number'];
			echo '<tr>';
			echo '<td>'.$exhibit_number.'</td>';
			echo '<td>'.$construction_score.'</td>';
			echo '<td>'.$finish_score.'</td>';
			echo '<td>'.$accuracy_score.'</td>';
			echo '<td>'.$intangible_score.'</td>';
			echo '<td>'.$total_score.'</td>';
			echo '<td>'.$judge_number.'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>