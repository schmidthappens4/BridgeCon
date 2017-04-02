<?php
  require_once ('libs/MysqliDb.php');
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

<?php

	$hostname = "localhost";
	$username = "bridgecon1";
	$password = "Sp1d3rm@n";
	$database = "test";
	
	$db = new MysqliDb ($hostname, $username, $password, $database);
	$db->connect();

?>

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
                        <h1 class="text-primary">Awards</h1>
                    </div>
                    <div class="col-md-12">
                      <table id="awards" class="display" cellspacing="0" width="100%">
                        <thead>
							<tr>
								<th>Award</th>
								<th>Genre</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "(
                            SELECT award.award_title, award_genre.award_genre FROM award
                            LEFT JOIN award_genre
                            ON award.award_genre_id=award_genre.award_genre_id
                            )";
                            
                            $award_result = $db->rawQuery ($query);
                            if ($db->count > 0)
                            foreach ($award_result as $award)
                            {
								$award_title = $award['award_title'];
								$award_genre = $award['award_genre'];
								echo '<tr>';
								echo '<td>'.$award_title.'</td>';
								echo '<td>'.$award_genre.'</td>';
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
		$('#awards').DataTable();
	} );
	
	</script>

</body>

</html>
