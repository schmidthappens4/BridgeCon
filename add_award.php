<?php
	require_once ('libs/MysqliDb.php');
  
  $hostname = "localhost";
	$username = "bridgecon1";
	$password = "Sp1d3rm@n";
	$database = "test";
	
	$db = new MysqliDb ($hostname, $username, $password, $database);
	$db->connect();
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
					<a href="index.html">BridgeCon</a>
				</li>
				<li>
					<a href="contestant.php">Contestants</a>
				</li>
				<li>
					<a href="#">Exhibits</a>
				</li>
				<li>
					<a href="#">Awards</a>
				</li>
				<li>
					<a href="#">Results</a>
				</li>
			</ul>
		</div>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-primary">Add Award</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<b>Award Info</b>
							</div>
							<div class="panel-body">
								<form role="form" id="award_info" action="add_award_complete.php" method="post" class="form-horizontal">
									<div class="form-group">
										<div class="col-md-6">
											<input type="text" name="award_title" placeholder="Award Title" class="form-control">
										</div>
										<div class="col-md-6">
											<select name="award_genre" class="form-control">
												<?php
													$award_genre_result = $db->get ("award_genre");
													if ($db->count > 0)
													foreach ($award_genre_result as $award_genre)
													{
														$id = $award_genre['award_genre_id'];
														$genre = $award_genre['award_genre'];
														echo '<option value="'.$id.'">'.$genre.'</option>';
													}
												?>
											</select>
										</div>
									</div>
                  <div class="form-group">
                    <div class="col-md-1 col-md-offset-4">
                      <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </div>
                    <div class="col-md-1 col-md-offset-2">
                      <button type="button" class="btn btn-info btn-block">Clear</button>
                    </div>
                  </div>
								</form>
							</div>
						</div>
					</div>
				</div>
        <div class="col-md-12">
						<table id="award" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Award Title</th>
									<th>Award Genre</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$award_result = $db->get ("award");
								if ($db->count > 0)
								foreach ($award_result as $award)
								{
									$id = $award['award_id'];
									$title = $award['award_title'];
									$genre = $award['award_genre_id'];
									echo '<tr>';
									echo '<td>'.$title.'</td>';
									echo '<td>'.$genre.'</td>';
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
		$('#award').DataTable();
	} );
	
	</script>

</body>

</html>