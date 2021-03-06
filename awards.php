<?php
	require_once ('libs/config.php');
  
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
                        <h1 class="text-primary">Awards</h1>
                    </div>
                    <div class="col-md-12">
                      <table id="awards" class="display" cellspacing="0" width="100%">
                        <thead>
							<tr>
								<th>Award</th>
								<th>Exhibit Title</th>
								<th>Sponsor</th>
								<th>Genre</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
							$query = "(
                            SELECT award.award_id, award.award_code, award.award_title, award_genre.award_genre, exhibit.exhibit_title, award_sponsor.award_sponsor FROM award_event
                            LEFT JOIN award
							ON award_event.award_id=award.award_id
							LEFT JOIN exhibit
							ON award_event.exhibit_id=exhibit.exhibit_id
							LEFT JOIN award_sponsor
							ON award_event.award_sponsor_id=award_sponsor.award_sponsor_id
							LEFT JOIN award_genre
                            ON award.award_genre_id=award_genre.award_genre_id
                            )";
                            
                            $award_result = $db->rawQuery ($query);
                            if ($db->count > 0)
                            foreach ($award_result as $award)
                            {
								$award_title = $award['award_code']." ".$award['award_title'];
								$exhibit_title = $award['exhibit_title'];
								$award_sponsor = $award['award_sponsor'];
								$award_genre = $award['award_genre'];
								echo '<tr>';
								echo '<td>'.$award_title.'</td>';
								echo '<td>'.$exhibit_title.'</td>';
								echo '<td>'.$award_sponsor.'</td>';
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
		$('#awards').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'print', 'pdf'
			]
		} );
	} );
	
	</script>

</body>

</html>
