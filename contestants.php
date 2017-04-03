<?php
	require_once ('libs/config.php');

	/*Add Event form returns here.
	Checks to see if a new contestant has been submitted and
	inserts contest info for the contestant into the database*/
	
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
                        <h1 class="text-primary">Contestants</h1>
                    </div>
                    <div class="col-md-3">
                      <a href="add_contestant.php" class="btn btn-success btn-block">Add Contestant</a>
                      <br />
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                            <th>Postal Code</th>
                            <th>Country</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "(
                            SELECT contestant.first_name, contestant.last_name, contestant.address, contestant.city, province.province_abbr, contestant.postal_code, country.country_name, contestant.phone_number, contestant.email FROM contestant
                            LEFT JOIN province
                            ON contestant.province_id=province.province_id
                            LEFT JOIN country
                            ON contestant.country_id=country.country_id
                            )";
                            
                            $contestant_result = $db->rawQuery ($query);
                            if ($db->count > 0)
                            foreach ($contestant_result as $contestant)
                            {
                              $first_name = $contestant['first_name'];
                              $last_name = $contestant['last_name'];
                              $address = $contestant['address'];
                              $city = $contestant['city'];
                              $province = $contestant['province_abbr'];
                              $postal_code = $contestant['postal_code'];
                              $country = $contestant['country_name'];
                              $phone_number = $contestant['phone_number'];
                              $email = $contestant['email'];
                              echo '<tr>';
                              echo '<td>'.$first_name.'</td>';
                              echo '<td>'.$last_name.'</td>';
                              echo '<td>'.$address.'</td>';
                              echo '<td>'.$city.'</td>';
                              echo '<td>'.$province.'</td>';
                              echo '<td>'.$postal_code.'</td>';
                              echo '<td>'.$country.'</td>';
                              echo '<td>'.$phone_number.'</td>';
                              echo '<td>'.$email.'</td>';
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
