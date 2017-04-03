<?php
	require_once ('libs/config.php');
  
	/*Checks to see if a new exhibit has been submitted and
	inserts exhibit info into the database*/
	
	if (isset($_POST['add_exhibit']))
	{
		/*Checks to see if the disqualified checkbox has been checked
		and sets the disqualified flag to either YES or NO*/
		
		if (isset($_POST['exhibit_disqualified']))
		{
			$exhibit_disqualified = "Yes";
		}
		else
		{
			$exhibit_disqualified = "No";
		}
		
		$exhibit_data = Array(
		'exhibit_number' => $_POST['exhibit_number'],
		'exhibit_title' => $_POST['exhibit_title'],
		'scale_id' => $_POST['scale'],
		'manufacturer_id' => $_POST['manufacturer'],
		'detail_level_id' => $_POST['detail_level'],
		'class_id' => $_POST['class'],
		'contestant_event_id' => $_POST['contestant_number'],
		'entry_fee' => $_POST['entry_fee'],
		'exhibit_disqualified' => $exhibit_disqualified
		);

		$id = $db->insert ('exhibit', $exhibit_data);
  
		if ($id)
		{
			$feedback = 'Exhibit Added';
		}
		else
		{
			$feedback =  'Oops, something went wrong! ' . $db->getLastError();
		}
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
						<h1 class="text-primary">Add Exhibit Info</h1>
					</div>
				</div>
				<div class="col-md-12">
					<h4 class="text-primary">
						<?php 
							echo $feedback;
						?>
					</h4>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<b>Exhibit Info</b>
							</div>
							<div class="panel-body">
								<form role="form" id="contestant_info" action="exhibits.php" method="post" class="form-horizontal">
									<div class="form-group row">
										<label class="col-md-1 control-label">Number</label>
										<div class="col-md-2">
											<input type="text" name="exhibit_number" placeholder="Ex Number" class="form-control">
										</div>
										<label class="col-md-1 control-label">Title</label>
										<div class="col-md-8">
											<input type="text" name="exhibit_title" placeholder="Exhibit Title" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 col-md-offset-1 control-label">Scale</label>
										<div class="col-md-2">
											<select name="scale" class="form-control">
												<?php
													$scale_result = $db->get ("scale");
													if ($db->count > 0)
													foreach ($scale_result as $scale)
													{
														$id = $scale['scale_id'];
														$model_scale = $scale['scale'];
														echo '<option value="'.$id.'">'.$model_scale.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-2 control-label">Manufacturer</label>
										<div class="col-md-4">
											<select name="manufacturer" class="form-control">
												<?php
													$manufacturer_result = $db->get ("manufacturer");
													if ($db->count > 0)
													foreach ($manufacturer_result as $manufacturer)
													{
														$id = $manufacturer['manufacturer_id'];
														$model_manufacturer = $manufacturer['manufacturer_name'];
														echo '<option value="'.$id.'">'.$model_manufacturer.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 col-md-offset-1 control-label">Detail Level</label>
										<div class="col-md-3">
											<select name="detail_level" class="form-control">
												<?php
													$detail_result = $db->get ("detail_level");
													if ($db->count > 0)
													foreach ($detail_result as $detail_level)
													{
														$id = $detail_level['detail_level_id'];
														$detail = $detail_level['detail_level'];
														echo '<option value="'.$id.'">'.$detail.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-2 control-label">Class</label>
										<div class="col-md-3">
											<select name="class" class="form-control">
												<?php
													$class_result = $db->get ("class");
													if ($db->count > 0)
													foreach ($class_result as $class)
													{
														$id = $class['class_id'];
														$class_level = $class['class'];
														echo '<option value="'.$id.'">'.$class_level.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-md-offset-2 control-label">Contestant Number</label>
										<div class="col-md-2">
											<select name="contestant_number" class="form-control">
												<?php
													$contestant_event_result = $db->get ("contestant_event");
													if ($db->count > 0)
													foreach ($contestant_event_result as $contestant_event)
													{
														$id = $contestant_event['contestant_event_id'];
														$contestant_number = $contestant_event['contestant_number'];
														echo '<option value="'.$id.'">'.$contestant_number.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-1 control-label">Entry Fee</label>
										<div class="col-md-1">
											<input type="text" name="entry_fee" placeholder="Entry Fee" class="form-control">
										</div>
									</div>
									<div class="form-group has-error bg-danger row">
										<div class="col-md-10 col-md-offset-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="exhibit_disqualified">
													Exhibit is disqualified
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-md-offset-4">
										  <button type="submit" name="add_exhibit" class="btn btn-success btn-block">Submit</button>
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
