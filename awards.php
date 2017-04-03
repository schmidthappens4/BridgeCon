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
