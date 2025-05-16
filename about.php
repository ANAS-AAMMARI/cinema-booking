<?php include('header.php');
try {
    // Get movie details
    $stmt = $con->prepare("SELECT * FROM tbl_movie WHERE movie_id = :id");
    $stmt->execute(['id' => $_GET['id']]);
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
                        <?php 
                        // Get distinct theatres showing the movie
                        $stmt = $con->prepare("SELECT DISTINCT theatre_id FROM tbl_shows WHERE movie_id = :movie_id");
                        $stmt->execute(['movie_id' => $movie['movie_id']]);
                        
                        if($stmt->rowCount() > 0) {
                        ?>
                        <table class="table table-hover table-bordered text-center">
                        <?php
                            while($shw = $stmt->fetch()) {
                                // Get theatre details
                                $stmt2 = $con->prepare("SELECT * FROM tbl_theatre WHERE id = :theatre_id");
                                $stmt2->execute(['theatre_id' => $shw['theatre_id']]);
                                $theatre = $stmt2->fetch();
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $theatre['name'].", ".$theatre['place'];?>
                                    </td>
                                    <td>
                                        <?php 
                                        // Get show details
                                        $stmt3 = $con->prepare("SELECT * FROM tbl_shows WHERE movie_id = :movie_id AND theatre_id = :theatre_id");
                                        $stmt3->execute([
                                            'movie_id' => $movie['movie_id'],
                                            'theatre_id' => $shw['theatre_id']
                                        ]);
                                        
                                        while($shh = $stmt3->fetch()) {
                                            // Get show time details
                                            $stmt4 = $con->prepare("SELECT * FROM tbl_show_time WHERE st_id = :st_id");
                                            $stmt4->execute(['st_id' => $shh['st_id']]);
                                            $ttme = $stmt4->fetch();
                                            ?>
                                            <a href="check_login.php?show=<?php echo $shh['s_id'];?>&movie=<?php echo $shh['movie_id'];?>&theatre=<?php echo $shw['theatre_id'];?>">
                                                <button class="btn btn-default"><?php echo date('h:i A',strtotime($ttme['start_time']));?></button>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                        } else {
                            ?>
                            <h3>No Show Available</h3>
                            <?php
                        }
                        ?>
                    </div>            
                    <?php include('movie_sidebar.php');?>
                </div>
                <div class="clear"></div>        
            </div>
        </div>
    </div>
    <?php
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
include('footer.php');
?>