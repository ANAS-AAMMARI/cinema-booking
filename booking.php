<?php 
include('header.php');
if(!isset($_SESSION['user']))
{
    header('location:login.php');
}

try {
    // Get movie details
    $stmt = $con->prepare("SELECT * FROM tbl_movie WHERE movie_id = :movie_id");
    $stmt->execute(['movie_id' => $_SESSION['movie']]);
    $movie = $stmt->fetch();
    ?>
<div class="content">
	<div class="wrap">
		<div class="content-top">
				<div class="section group">
					<div class="about span_1_of_2">	
						<h3><?php echo $movie['movie_name']; ?></h3>	
							<div class="about-top">	
								<div class="grid images_3_of_2">
									<img src="<?php echo $movie['image']; ?>" alt=""/>
								</div>
								<div class="desc span_3_of_2">
									<p class="p-link" style="font-size:15px">Cast : <?php echo $movie['cast']; ?></p>
									<p class="p-link" style="font-size:15px">Relece Date : <?php echo date('d-M-Y',strtotime($movie['release_date'])); ?></p>
									<p style="font-size:15px"><?php echo $movie['desc']; ?></p>
									<a href="<?php echo $movie['video_url']; ?>" target="_blank" class="watch_but">Watch Trailer</a>
								</div>
								<div class="clear"></div>
							</div>
							<table class="table table-hover table-bordered text-center">
							<?php
    // Get show details
    $stmt = $con->prepare("SELECT * FROM tbl_shows WHERE s_id = :show_id");
    $stmt->execute(['show_id' => $_SESSION['show']]);
    $shw = $stmt->fetch();

    // Get theatre details
    $stmt = $con->prepare("SELECT * FROM tbl_theatre WHERE id = :theatre_id");
    $stmt->execute(['theatre_id' => $shw['theatre_id']]);
    $theatre = $stmt->fetch();

    // Get show time details
    $stmt = $con->prepare("SELECT * FROM tbl_show_time WHERE st_id = :st_id");
    $stmt->execute(['st_id' => $shw['st_id']]);
    $ttme = $stmt->fetch();

    // Get screen details
    $stmt = $con->prepare("SELECT * FROM tbl_screens WHERE screen_id = :screen_id");
    $stmt->execute(['screen_id' => $ttme['screen_id']]);
    $screen = $stmt->fetch();
									?>
									<tr>
										<td class="col-md-6">
											Theatre
										</td>
										<td>
											<?php echo $theatre['name'].", ".$theatre['place'];?>
										</td>
										</tr>
										<tr>
											<td>
												Screen
											</td>
										<td>
											<?php 
												echo $screen['screen_name'];
							
												?>
										</td>
									</tr>
									<tr>
										<td>
											Date
										</td>
										<td>
											<?php 
											if(isset($_GET['date']))
							{
								$date=$_GET['date'];
							}
							else
							{
								if($shw['start_date']>date('Y-m-d'))
								{
									$date=date('Y-m-d',strtotime($shw['start_date'] . "-1 days"));
								}
								else
								{
									$date=date('Y-m-d');
								}
								$_SESSION['dd']=$date;
							}
							?>
							<div class="col-md-12 text-center" style="padding-bottom:20px">
								<?php if($date>$_SESSION['dd']){?><a href="booking.php?date=<?php echo date('Y-m-d',strtotime($date . "-1 days"));?>"><button class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i></button></a> <?php } ?><span style="cursor:default" class="btn btn-default"><?php echo date('d-M-Y',strtotime($date));?></span>
								<?php if($date!=date('Y-m-d',strtotime($_SESSION['dd'] . "+4 days"))){?>
								<a href="booking.php?date=<?php echo date('Y-m-d',strtotime($date . "+1 days"));?>"><button class="btn btn-default"><i class="glyphicon glyphicon-chevron-right"></i></button></a>
								<?php }
    // Get available seats
    $stmt = $con->prepare("SELECT SUM(no_seats) FROM tbl_bookings WHERE show_id = :show_id AND ticket_date = :date");
    $stmt->execute([
        'show_id' => $_SESSION['show'],
        'date' => $date
    ]);
    $avl = $stmt->fetch(PDO::FETCH_NUM);
								?>
							</div>
										</td>
									</tr>
									<tr>
										<td>
											Show Time
										</td>
										<td>
											<?php echo date('h:i A',strtotime($ttme['start_time']))." ".$ttme['name'];?> Show
										</td>
									</tr>
									<tr>
										<td>
											Number of Seats
										</td>
										<td> 
											<form  action="process_booking.php" method="post">
												<input type="hidden" name="screen" value="<?php echo $screen['screen_id'];?>"/>
											<input type="number" required tile="Number of Seats" max="<?php echo $screen['seats']-$avl[0];?>" min="0" name="seats" class="form-control" value="1" style="text-align:center" id="seats"/>
											<input type="hidden" name="amount" id="hm" value="<?php echo $screen['charge'];?>"/>
											<input type="hidden" name="date" value="<?php echo $date;?>"/>
										</td>
									</tr>
									<tr>
										<td>
											Amount
										</td>
										<td id="amount" style="font-weight:bold;font-size:18px">
											Rs <?php echo $screen['charge'];?>
										</td>
									</tr>
									<tr>
										<td colspan="2"><?php if($avl[0]==$screen['seats']){?><button type="button" class="btn btn-danger" style="width:100%">House Full</button><?php } else { ?>
										<button class="btn btn-info" style="width:100%">Book Now</button>
										<?php } ?>
										</form></td>
									</tr>
						<table>
							<tr>
								<td></td>
							</tr>
						</table>
					</div>			
				<?php include('movie_sidebar.php'); ?>
			</div>
				<div class="clear"></div>		
			</div>
	</div>
</div>
<?php include('footer.php'); ?>
<script type="text/javascript">
	$('#seats').change(function(){
		var charge=<?php echo $screen['charge'];?>;
		amount=charge*$(this).val();
		$('#amount').html("Rs "+amount);
		$('#hm').val(amount);
	});
</script>
<?php
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>