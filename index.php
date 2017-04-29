<?php
	require_once ('libs/config.php');

	include_once('header.php');
?>

    <div id="wrapper">
	
		<?php
			include_once('navbar.php');
		?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-primary">BridgeCon Dashboard</h1>
                    </div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>BridgeCon Totals</b>
						</div>
						<div class="panel-body">
							<div class="col-md-4">
								<?php
									$contestant_count = $db->getValue ("contestant", "COUNT(contestant_id)");
									echo '<h4 class="text-primary">Contestant Total: ' . $contestant_count;
								?>
							</div>
							<div class="col-md-4">
								<?php
									$entry_fee_total = $db->getValue ("exhibit", "SUM(entry_fee)");
									echo '<h4 class="text-primary">Entry Fee Total: ' . number_format($entry_fee_total,2);
								?>
							</div>
							<div class="col-md-4">
								<?php
									$exhibit_count = $db->getValue ("exhibit", "COUNT(exhibit_id)");
									echo '<h4 class="text-primary">Exhibit Total: ' . $exhibit_count;
								?>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Class Totals</b>
						</div>
						<div class="panel-body">
							<?php
								$class_query = "(
								SELECT exhibit.class_id, class.class, COUNT(*) AS class_total FROM exhibit
								LEFT JOIN class
								ON exhibit.class_id=class.class_id
								GROUP BY exhibit.class_id
								)";
								
								$class_result = $db->rawQuery ($class_query);
								
								if ($db->count > 0)
								foreach ($class_result as $class)
								{
									$id = $class['class_id'];
									$class_name = $class['class'];
								}
							?>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">'. $class_result[0]['class'] . ': ' . $class_result[0]['class_total'];
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">'. $class_result[1]['class'] . ': ' . $class_result[1]['class_total'];
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">'. $class_result[2]['class'] . ': ' . $class_result[2]['class_total'];
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">'. $class_result[3]['class'] . ': ' . $class_result[3]['class_total'];
								?>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<b>Medal Totals</b>
						</div>
						<div class="panel-body">
							<?php
							$number_of_exhibits_query = "(
							SELECT DISTINCT exhibit.exhibit_number FROM score
							LEFT JOIN exhibit
                            ON score.exhibit_id=exhibit.exhibit_id
							ORDER BY exhibit_number ASC
                            )";
							/*
							$exhibit_scores_query = "(
							SELECT exhibit.exhibit_number, exhibit.exhibit_title, score.total_score FROM score
                            LEFT JOIN exhibit
                            ON score.exhibit_id=exhibit.exhibit_id
							WHERE exhibit_number = ?
							ORDER BY exhibit_number, total_score ASC
                            )";
							*/
                            $exhibits_result = $db->rawQuery ($number_of_exhibits_query);
							
							$gold_total = 0;
							$silver_total = 0;
							$bronze_total = 0;
							$no_medal_total = 0;
							
                            if ($db->count > 0)
							
                            foreach ($exhibits_result as $exhibit)
                            {
								$cols = Array ("exhibit.exhibit_number", "exhibit.exhibit_title", "score.total_score");
								$db->join("exhibit", "score.exhibit_id=exhibit.exhibit_id", "LEFT");
								$db->where('exhibit_number', $exhibit['exhibit_number']);
								$db->orderBy("exhibit_number", "ASC");
								$db->orderBy("total_score", "ASC");
								$exhibit_scores = $db->get('score', null, $cols);

								if ($db->count == 5)
								{
									$final_score = $exhibit_scores[1]['total_score'] + $exhibit_scores[2]['total_score'] + $exhibit_scores[3]['total_score'];
									switch ($final_score)
									{
										case ($final_score >= 30):
											$medal_level = "Gold";
											$gold_total++;
											break;
										case ($final_score >=24):
											$medal_level = "Silver";
											$silver_total++;
											break;
										case ($final_score >=18):
											$medal_level = "Bronze";
											$bronze_total++;
											break;
										case ($final_score < 18):
											$medal_level = "No Medal";
											$no_medal_total++;
											break;
									}
								}
                            }
							?>

							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">Gold: ' . $gold_total;
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">Silver: ' . $silver_total;
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">Bronze: ' . $bronze_total;
								?>
							</div>
							<div class="col-md-3">
								<?php
									echo '<h4 class="text-primary">No Medal: ' . $no_medal_total;
								?>
							</div>
						</div>
					</div>
							<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
				</div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

	<!-- Initialize DataTables -->
	<script>
		
	$(document).ready( function () {
		$('#contestant').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'print', 'pdf'
			]
		} );
	} );
	
	</script>

</body>

</html>
