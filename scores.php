<?php
	require_once ('libs/config.php');
  	
	/*Checks to see if a new score set has been submitted and
	inserts scores info into the database*/
	
	if (isset($_POST['add_score']))
	{
		$score_data = Array(
		'exhibit_id' => $_POST['exhibit_number'],
		'construction_score' => $_POST['construction_score'],
		'finish_score' => $_POST['finish_score'],
		'accuracy_score' => $_POST['accuracy_score'],
		'intangible_score' => $_POST['intangible_score'],
		'total_score' => $_POST['total_score'],
		'judge_id' => $_POST['judge_number']
		);
		
		$id = $db->insert ('score', $score_data);
  
		if ($id)
		{
			$feedback = 'Score Recorded';
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
						<h1 class="text-primary">Add Score Info</h1>
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
								<b>Exhibit Score</b>
							</div>
							<div class="panel-body">
								<form role="form" id="score_card" action="scores.php" method="post" class="form-horizontal">
									<div class="form-group row">
										<label class="col-md-2 control-label">Exhibit Number</label>
										<div class="col-md-2">
											<select id="exhibit_number" name="exhibit_number" class="form-control">
												<?php
													$db->orderBy("exhibit_number","ASC");
													$exhibit_result = $db->get ("exhibit");
													if ($db->count > 0)
													foreach ($exhibit_result as $exhibit)
													{
														$id = $exhibit['exhibit_id'];
														$exhibit_number = $exhibit['exhibit_number'];
														echo '<option value="'.$id.'">'.$exhibit_number.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-3 control-label">Construction Score</label>
										<div class="col-md-2">
											<input type="text" name="construction_score" id="construction_score" placeholder="Construction" class="form-control" onChange="calculate_total(this.value, 'finish_score', 'accuracy_score', 'intangible_score', 'total_score')" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-md-offset-4 control-label">Finish Score</label>
										<div class="col-md-2">
											<input type="text" name="finish_score" id="finish_score" placeholder="Finish" class="form-control" onChange="calculate_total(this.value, 'construction_score', 'accuracy_score', 'intangible_score', 'total_score')" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-md-offset-4 control-label">Accuracy Score</label>
										<div class="col-md-2">
											<input type="text" name="accuracy_score" id="accuracy_score" placeholder="Accuracy" class="form-control" onChange="calculate_total(this.value, 'construction_score', 'finish_score', 'intangible_score', 'total_score')" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-md-offset-4 control-label">Intangible Score</label>
										<div class="col-md-2">
											<input type="text" name="intangible_score" id="intangible_score" placeholder="Intangible" class="form-control" onChange="calculate_total(this.value, 'construction_score', 'finish_score', 'accuracy_score', 'total_score')" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-md-offset-4 control-label">Total Score</label>
										<div class="col-md-2">
											<input type="text" name="total_score" id="total_score" readonly placeholder="Total" class="form-control" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Judge Number</label>
										<div class="col-md-2">
											<select name="judge_number" class="form-control">
												<?php
													$db->orderBy("judge_number","ASC");
													$judge_result = $db->get ("judge");
													if ($db->count > 0)
													foreach ($judge_result as $judge)
													{
														$id = $judge['judge_id'];
														$judge_number = $judge['judge_number'];
														echo '<option value="'.$id.'">'.$judge_number.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-md-offset-4">
										  <button type="submit" name="add_score" class="btn btn-success btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="show_scores">
					<!-- Scores table will show here -->
				</div>
				<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
			</div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<!-- AJAX script to populate exhibit scores based on
		exhibit number drop-down menu -->
	<?php
		if (isset($_POST['exhibit_number']))
		{
			$exhibit_id = $_POST['exhibit_number'];
		}
		else
		{
			$db->orderBy("exhibit_number","ASC");
			$exhibit = $db->getOne ("exhibit");
			
			$exhibit_id = $exhibit['exhibit_id'];
		}
	?>
	
	<script>
	$(document).ready(function()
	{
		function initialLoad(){
			var id = '<?php echo $exhibit_id; ?>';
			$.ajax
			({
				type: 'POST',
				url: 'get_scores.php',
				data: {exhibit_select:id},
				cache: false,
				success: function(r)
				{
					$("#show_scores").html(r);
				}
			});
		}
		
		initialLoad();
		
		$("#exhibit_number").change(function()
		{
			var id = $(this).val();
			
			$.ajax
			({
				type: 'POST',
				url: 'get_scores.php',
				data: {exhibit_select:id},
				cache: false,
				success: function(r)
				{
					$("#show_scores").html(r);
				}
			});
		})
	});
	</script>

	<script>
	function calculate_total(A, B, C, D, SUM) {
		var one = Number(A);
		if (isNaN(one)) { alert('Invalid entry: '+A); one=0; }
		var two = Number(document.getElementById(B).value);
		if (isNaN(two)) { alert('Invalid entry: '+B); two=0; }
		var three = Number(document.getElementById(C).value);
		if (isNaN(three)) { alert('Invalid entry: '+C); three=0; }
		var four = Number(document.getElementById(D).value);
		if (isNaN(four)) { alert('Invalid entry: '+D); four=0; }
		document.getElementById(SUM).value = one + two + three + four;
	}
	</script>
	
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
