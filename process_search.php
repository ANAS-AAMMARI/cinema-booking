<?php 
include('header.php');
extract($_POST);
?>
</div>
<div class="content">
    <div class="wrap">
        <div class="content-top">
            <h3>Movies</h3>
            
            <?php
            try {
                $today = date("Y-m-d");
                $stmt = $con->prepare("SELECT DISTINCT movie_name, movie_id, image, cast FROM tbl_movie WHERE movie_name = :search");
                $stmt->execute(['search' => $search]);
                
                while($m = $stmt->fetch()) {
                ?>
                <div class="col_1_of_4 span_1_of_4">
                    <div class="imageRow">
                        <div class="single">
                            <a href="about.php?id=<?php echo $m['movie_id'];?>" rel="lightbox">
                                <img src="<?php echo $m['image'];?>" alt="" />
                            </a>
                        </div>
                        <div class="movie-text">
                            <h4 class="h-text">
                                <a href="about.php?id=<?php echo $m['movie_id'];?>">
                                    <?php echo $m['movie_name'];?>
                                </a>
                            </h4>
                            Cast:<Span class="color2"><?php echo $m['cast'];?></span><br>
                        </div>
                    </div>
                </div>
                <?php
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
            </div>
            <div class="clear"></div>		
        </div>
    </div>
</div>
<?php include('footer.php');?>
