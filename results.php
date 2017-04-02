<?php
	require_once ('libs/MysqliDb.php');
  
	$hostname = "localhost";
	$username = "bridgecon1";
	$password = "Sp1d3rm@n";
	$database = "test";
	
	$feedback = "";
  
	$event_data = array();
  
	$db = new MysqliDb ($hostname, $username, $password, $database);
	$db->connect();
	
	if (isset($_POST['add_event']))
	{
		$event_data = Array(
		'contestant_id' => $_POST['contestant_id'],
		'event_id' => $_POST['event'],
		'contestant_number' => $_POST['contestant_number'],
		'contestant_age' => $_POST['contestant_age']
		);

		$id = $db->insert ('contestant_event', $event_data);
  
		if ($id)
		{
			$feedback = 'Contestant Added';
		}
		else
		{
			$feedback =  'Oops, something went wrong! ' . $db->getLastError();
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BridgeCon Dashboard</title>

    <!-- DataTables CSS -->
	<link href="DataTables/datatables.min.css" rel="stylesheet">

	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

	<!-- DataTables JavaScript -->
	<script type="text/javascript" charset="utf-8" src="DataTables/datatables.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="contestant.php">
                        BridgeCon
                    </a>
                </li>
                <li>
                    <a href="contestant.php">Contestants</a>
                </li>
                <li>
                    <a href="exhibit.php">Exhibits</a>
                </li>
                <li>
                    <a href="awards.php">Awards</a>
                </li>
				<li>
                    <a href="score.php">Scores</a>
                </li>
                <li>
                    <a href="results.php">Results</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-primary">Results</h1>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
						<h4 class="text-primary">
							<?php 
								echo $feedback;
							?>
						</h4>
					</div>
                    <div class="col-md-12">
                      <table id="contestant" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Exhibit Number</th>
                            <th>Exhibit Title</th>
                            <th>Final Score</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
							$number_of_exhibits_query = "(
							SELECT DISTINCT exhibit.exhibit_number FROM score
							LEFT JOIN exhibit
                            ON score.exhibit_id=exhibit.exhibit_id
							ORDER BY exhibit_number ASC
                            )";
							
							$exhibit_scores_query = "(
							SELECT exhibit.exhibit_number, exhibit.exhibit_title, score.total_score FROM score
                            LEFT JOIN exhibit
                            ON score.exhibit_id=exhibit.exhibit_id
							WHERE exhibit_number = ?
							ORDER BY exhibit_number, total_score ASC
                            )";
							
                            $exhibits_result = $db->rawQuery ($number_of_exhibits_query);
							
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
								}
								else
								{
									$final_score = 'Pending';
								}

								$exhibit_number = $exhibit['exhibit_number'];
								$exhibit_title = $exhibit_scores[0]['exhibit_title'];
								$total_score = $final_score;
								
								echo '<tr>';
								echo '<td>'.$exhibit_number.'</td>';
								echo '<td>'.$exhibit_title.'</td>';
								echo '<td>'.$total_score.'</td>';
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
		$('#contestant').DataTable();
	} );
	
	</script>

</body>

</html>
