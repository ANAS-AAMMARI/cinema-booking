<?php
include('header.php');
?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Movies List
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Movies List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box --> 
      <div class="box">
        <div class="box-body">
            <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">
              <?php include('../../msgbox.php');?>
              <ul class="todo-list">
                 <?php 
                 try {
                    $stmt = $con->prepare("SELECT * FROM tbl_movie");
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0) {
                        while($c = $stmt->fetch()) {
                        ?>
                        <li>
                            <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <span class="text"><?php echo $c['movie_name'];?></span>
                            <div class="tools">
                                <button class="fa fa-trash-o" onclick="del(<?php echo $c['movie_id'];?>)"></button>
                            </div>
                        </li>
                        <?php
                        }
                    }
                 } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                 }
                 ?>
                      
            </div>
          </div>
        </div> 
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <?php
include('footer.php');
?>
<script>
function del(m)
    {
        if (confirm("Are you want to delete this movie") == true) 
        {
            window.location="process_delete_movie.php?mid="+m;
        } 
    }
    </script>