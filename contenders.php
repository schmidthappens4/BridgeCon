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
                        <h1 class="text-primary">Award Contenders</h1>
                    </div>
                    <div class="col-md-12">
                      <table id="contenders" class="table-striped" cellspacing="0" width="100%">
                        <thead>
							<tr>
								<th>Award</th>
								<th>Exhibit Number</th>
								<th>Exhibit Title</th>
								<th>Final Score</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
							$contender_query = "(
                            SELECT award.award_code, award.award_title, exhibit.exhibit_id, exhibit.exhibit_number, exhibit.exhibit_title FROM contender
                            LEFT JOIN award
							ON contender.award_id=award.award_id
							LEFT JOIN exhibit
							ON contender.exhibit_id=exhibit.exhibit_id
							ORDER BY award_title
                            )";
							
                            $contender_result = $db->rawQuery ($contender_query);
							
                            if ($db->count > 0)
                            foreach ($contender_result as $contender)
                            {
								
								$cols = Array ("exhibit.exhibit_number", "exhibit.exhibit_title", "score.total_score");
								$db->join("exhibit", "score.exhibit_id=exhibit.exhibit_id", "LEFT");
								$db->where('exhibit_number', $contender['exhibit_number']);
								$db->orderBy("exhibit_number", "ASC");
								$db->orderBy("total_score", "ASC");
								$exhibit_scores = $db->get('score', null, $cols);

								if ($db->count == 5)
								{
									$final_score = $exhibit_scores[1]['total_score'] + $exhibit_scores[2]['total_score'] + $exhibit_scores[3]['total_score'];
								}
								else
								{
									$final_score = 'Pending';
								}
								
								$award_title = $contender['award_code']." ".$contender['award_title'];
								$exhibit_number = $contender['exhibit_number'];
								$exhibit_title = $contender['exhibit_title'];
								echo '<tr>';
								echo '<td>'.$award_title.'</td>';
								echo '<td>'.$exhibit_number.'</td>';
								echo '<td>'.$exhibit_title.'</td>';
								echo '<td>'.$final_score.'</td>';
								echo '</tr>';
                            }
                          ?>
                        </tbody>
                      </table>
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    </div>
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
		$('#contenders').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'print', 'pdf'
			]
		} );
	} );
	
	</script>

</body>

</html>
