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

		$exhibit_id = $db->insert ('exhibit', $exhibit_data);
  
		if ($exhibit_id)
		{
			$feedback = 'Exhibit Added';
			
			if (isset($_POST['best_of']))
			{
				$best_of_awards = $_POST['best_of'];
				
				foreach ($best_of_awards as $award)
				{
					$contender_data = Array(
					'exhibit_id' => $exhibit_id,
					'award_id' => $award
					);
					
					$contender_id = $db->insert ('contender', $contender_data);
				}
			}
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
									<div class="form-group required row">
										<label class="col-md-1 control-label">Number</label>
										<div class="col-md-2">
											<input type="text" name="exhibit_number" placeholder="Exhibit Number" class="form-control">
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
													echo '<option value=""> -- Select Scale -- </option>';
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
													echo '<option value=""> -- Select Manufacturer -- </option>';
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
													echo '<option value=""> -- Select Detail Level -- </option>';
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
													echo '<option value=""> -- Select Class -- </option>';
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
													echo '<option value=""> -- Select Contestant -- </option>';
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
										
									<div class="form-group row">
										<label class="col-md-2 control-label">Aircraft</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="1">
												AC 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="2">
												AC 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="3">
												AC 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="4">
												AC 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="5">
												AC 05
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="6">
												AC 06
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="7">
												AC 07
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="8">
												AC 08
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="9">
												AC 09
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="10">
												AC 10
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Automotive</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="11">
												AT 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="12">
												AT 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="13">
												AT 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="14">
												AT 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="15">
												AT 05
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="16">
												AT 06
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="17">
												AT 07
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="18">
												AT 08
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="19">
												AT 09
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="20">
												AT 10
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="21">
												AT 11
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="22">
												AT 12
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Armour</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="23">
												AR 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="24">
												AR 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="25">
												AR 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="26">
												AR 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="27">
												AR 05
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="28">
												AR 06
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="29">
												AR 07
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Skills</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="30">
												SK 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="31">
												SK 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="32">
												SK 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="33">
												SK 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="34">
												SK 05
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Watercraft / Ship</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="35">
												WC 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="36">
												WC 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="37">
												WC 03
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Space / Science Fiction / Fantasy</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="38">
												SF 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="39">
												SF 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="40">
												SF 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="41">
												SF 04
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Other</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="42">
												OT 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="43">
												OT 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="44">
												OT 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="45">
												OT 04
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Figure</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="46">
												FI 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="47">
												FI 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="48">
												FI 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="49">
												FI 04
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Most Outstanding</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="50">
												MO 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="51">
												MO 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="52">
												MO 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="53">
												MO 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="54">
												MO 05
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="55">
												MO 06
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="56">
												MO 07
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Junior</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="57">
												JR 01
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="58">
												JR 02
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="59">
												JR 03
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="60">
												JR 04
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="61">
												JR 05
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="62">
												JR 06
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="63">
												JR 07
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="64">
												JR 08
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="65">
												JR 09
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="66">
												JR 10
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="67">
												JR 11
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="68">
												JR 12
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="69">
												JR 13
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="70">
												JR 14
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-2 control-label">Miscellaneous</label>
										<div class="col-md-10">
											<label class="checkbox-inline">
												<input type="checkbox" name="best_of[]" value="71">
												MI 01
											</label>
										</div>
									</div>
									
									<div class="form-group row has-error bg-danger">
										<label class="col-md-2 control-label">Exhibit is disqualified</label>
										<div class="col-md-10">
											<label class="checkbox-inline checkbox-danger">
												<input type="checkbox" name="exhibit_disqualified">
												Yes
											</label>
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
