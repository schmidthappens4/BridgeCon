<?php
	require_once ('libs/config.php');

	/*Checks to see if the disqualified checkbox has been checked
		and sets the disqualified flag to either YES or NO*/
		
	if (isset($_POST['contestant_disqualified']))
	{
		$contestant_disqualified = "Yes";
	}
	else
	{
		$contestant_disqualified = "No";
	}
  
	$contestant_data = Array(
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'address' => $_POST['address'],
    'city' => $_POST['city'],
    'province_id' => $_POST['province'],
    'postal_code' => $_POST['postal_code'],
    'country_id' => $_POST['country'],
    'phone_number' => $_POST['phone_number'],
    'email' => $_POST['email'],
    'contestant_disqualified' => $contestant_disqualified
    );
  
	$id = $db->insert ('contestant', $contestant_data);
 
	if ($id)
	{
		$contestant_id = $id;
	}
	else
	{
		echo 'Oops, something went wrong! ' . $db->getLastError();
	}

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
						<h1 class="text-primary">Add Contest Info</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<b>Contest Info</b>
							</div>
							<div class="panel-body">
								<form role="form" id="event_info" action="contestant.php" method="post" class="form-horizontal">
									<div class="form-group row">
										<label class="col-md-3 control-label">Contestant ID</label>
										<div class="col-md-2">
										  <?php
											echo '<input type="text" name="contestant_id" value="'.$contestant_id.'" class="form-control">';
										  ?>
										</div>
										<label class="col-md-2 control-label">Contest</label>
										<div class="col-md-3">
											<select name="event" class="form-control">
												<?php
													$event_result = $db->get ("event");
													if ($db->count > 0)
													foreach ($event_result as $event)
													{
														$id = $event['event_id'];
														$name = $event['event_name'];
														echo '<option value="'.$id.'">'.$name.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 control-label">Contestant Number</label>
										<div class="col-md-2">
											<input type="text" name="contestant_number" placeholder="Contestant Number" class="form-control">
										</div>
										<label class="col-md-3 control-label">Contestant Age</label>
										<div class="col-md-2">
											<input type="text" name="contestant_age" placeholder="Contestant Age" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-md-offset-4">
										  <button type="submit" name="add_event" class="btn btn-success btn-block">Submit</button>
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