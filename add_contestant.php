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

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="css/simple-sidebar.css" rel="stylesheet">

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
						<h1 class="text-primary">Add Contestant Info</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<b>Personal Info</b>
							</div>
							<div class="panel-body">
								<form role="form" id="contestant_info" action="add_event.php" method="post" class="form-horizontal">
									<div class="form-group row">
										<label class="col-md-2 control-label">First Name</label>
										<div class="col-md-4">
											<input type="text" name="first_name" placeholder="First Name" class="form-control">
										</div>
										<label class="col-md-2 control-label">Last Name</label>
										<div class="col-md-4">
											<input type="text" name="last_name" placeholder="Last Name" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-1 control-label">Address</label>
										<div class="col-md-11">
											<input type="text" name="address" placeholder="Address" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-1 control-label">City</label>
										<div class="col-md-3">
											<input type="text" name="city" placeholder="City" class="form-control">
										</div>
										<label class="col-md-2 control-label">Province</label>
										<div class="col-md-2">
											<select name="province" class="form-control">
												<?php
													$prov_result = $db->get ("province");
													if ($db->count > 0)
													foreach ($prov_result as $prov)
													{
														$id = $prov['province_id'];
														$abbr = $prov['province_abbr'];
														echo '<option value="'.$id.'">'.$abbr.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-2 control-label">Postal Code</label>
										<div class="col-md-2">
											<input type="text" name="postal_code" placeholder="Postal Code" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Country</label>
										<div class="col-md-3">
											<select name="country" class="form-control">
												<?php
													$country_result = $db->get ("country");
													if ($db->count > 0)
													foreach ($country_result as $country)
													{
														$id = $country['country_id'];
														$name = $country['country_name'];
														echo '<option value="'.$id.'">'.$name.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-2 col-md-offset-1 control-label">Phone Number</label>
										<div class="col-md-3">
											<input type="text" name="phone_number" placeholder="Phone Number" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-1 control-label">Email</label>
										<div class="col-md-11">
											<input type="text" name="email" placeholder="Email" class="form-control">
										</div>
									</div>
								    <div class="form-group has-error bg-danger row">
										<div class="col-md-10 col-md-offset-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="contestant_disqualified">
													Contestant is disqualified
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-md-offset-4">
										  <button type="submit" class="btn btn-success btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
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

</body>

</html>
