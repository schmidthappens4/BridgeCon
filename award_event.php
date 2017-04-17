<?php
	require_once ('libs/config.php');
  	
	/*Checks to see if a new score set has been submitted and
	inserts scores info into the database*/
	
	if (isset($_POST['add_award']))
	{
		if ($_POST['award_sponsor'] == "")
		{
			$sponsor_id = NULL;
		}
		else
		{
			$sponsor_id = $_POST['award_sponsor'];
		}
		
		if ($_POST['exhibit'] == "")
		{
			$exhibit_id = NULL;
		}
		else
		{
			$exhibit_id = $_POST['exhibit'];
		}
		
		$award_data = Array(
		'award_id' => $_POST['award'],
		'event_id' => $_POST['event'],
		'award_sponsor_id' => $sponsor_id,
		'exhibit_id' => $exhibit_id
		);
		
		$id = $db->insert ('award_event', $award_data);
  
		if ($id)
		{
			$feedback = 'Award Info Recorded';
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
						<h1 class="text-primary">Add Award Info</h1>
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
								<b>Award Info</b>
							</div>
							<div class="panel-body">
								<form role="form" id="award_event" action="award_event.php" method="post" class="form-horizontal">
									<div class="form-group row">
										<label class="col-md-2 control-label">Event</label>
										<div class="col-md-2">
											<select name="event" class="form-control">
												<?php
													$event_result = $db->get ("event");
													if ($db->count > 0)
													foreach ($event_result as $event)
													{
														$id = $event['event_id'];
														$event_name = $event['event_name'];
														echo '<option value="'.$id.'">'.$event_name.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Award</label>
										<div class="col-md-3">
											<select id="award" name="award" class="form-control">
												<?php
													$award_result = $db->get ("award");
													if ($db->count > 0)
													foreach ($award_result as $award)
													{
														$id = $award['award_id'];
														$award_title = $award['award_title'];
														echo '<option value="'.$id.'">'.$award_title.'</option>';
													}
												?>
											</select>
										</div>
										<label class="col-md-2 control-label">Award Sponsor</label>
										<div class="col-md-3">
											<select id="award_sponsor" name="award_sponsor" class="form-control">
												<?php
													echo '<option value=""> -- Select Sponsor -- </option>';
													$sponsor_result = $db->get ("award_sponsor");
													if ($db->count > 0)
													foreach ($sponsor_result as $sponsor)
													{
														$id = $sponsor['award_sponsor_id'];
														$award_sponsor = $sponsor['award_sponsor'];
														echo '<option value="'.$id.'">'.$award_sponsor.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Exhibit</label>
										<div class="col-md-4">
											<select name="exhibit" class="form-control">
												<?php
													echo '<option value=""> -- Select Exhibit -- </option>';
													$exhibit_result = $db->get ("exhibit");
													if ($db->count > 0)
													foreach ($exhibit_result as $exhibit)
													{
														$id = $exhibit['event_id'];
														$exhibit_title = $exhibit['exhibit_title'];
														echo '<option value="'.$id.'">'.$exhibit_title.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-md-offset-4">
										  <button type="submit" name="add_award" class="btn btn-success btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
                    <table id="awards" class="table-striped" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Event</th>
							<th>Award</th>
                            <th>Sponsor</th>
							<th>Exhibit</th>
                          </tr>
                        </thead>
                        <tbody>
						<?php
                            $query = "(
							SELECT event.event_name, award.award_code, award.award_title, award_sponsor.award_sponsor, exhibit.exhibit_title FROM award_event
							LEFT JOIN event
							ON award_event.event_id=event.event_id
							LEFT JOIN award
							ON award_event.award_id=award.award_id
							LEFT JOIN award_sponsor
							ON award_event.award_sponsor_id=award_sponsor.award_sponsor_id
							LEFT JOIN exhibit
							ON award_event.exhibit_id=exhibit.exhibit_id
							)";
                            
                            $award_event_result = $db->rawQuery ($query);
                            if ($db->count > 0)
                            foreach ($award_event_result as $award_event)
                            {
                              $event = $award_event['event_name'];
                              $award = $award_event['award_code']." ".$award_event['award_title'];
                              $sponsor = $award_event['award_sponsor'];
                              $exhibit = $award_event['exhibit_title'];
                              echo '<tr>';
                              echo '<td>'.$event.'</td>';
                              echo '<td>'.$award.'</td>';
                              echo '<td>'.$sponsor.'</td>';
                              echo '<td>'.$exhibit.'</td>';
                              echo '</tr>';
                            }
                          ?>
                        </tbody>
                    </table>
					<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
				</div>
			</div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<!-- Initialize DataTables -->
	<script>
		
	$(document).ready( function () {
		$('#awards').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'print', 'pdf'
			]
		} );
	} );
	
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
