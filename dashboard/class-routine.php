<?php 
	require_once('header.php');
	 

	$current_class_status = Student('current_class',$_SESSION['st_loggedin'][0]['id']); //student id thke current class pabo
	
	if($current_class_status != null){ // $current_class_status jodi null na hoi thle oi student id er registration validity check krbe
	 	$current_date = date('Y-m-d');
		$stm=$pdo->prepare("SELECT * FROM class WHERE start_date<=? AND end_date>=? AND id=?"); //sob logic complete korle result show krbe
		$stm->execute(array($current_date,$current_date,$current_class_status));
		$classCount = $stm->rowCount();
		echo $classCount;
    }
	
    else{
        $classCount = 0;
    }

?>

<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Class Routine</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Class Routine</li>
			</ul>
		</div>	
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">


					<!-- New Class Registration -->
					<div class="wc-title">
						<h4>Class Routine</h4>
					</div>
                    <?php if($classCount == 1) :?>  <!-- current class active thkle routine dekhabe -->

                        <?php 
                        $stm=$pdo->prepare("SELECT class.class_name,subject.name as subject_name,subject.code as subject_code,teachers.name as teacher_name,class_routine.time_from,class_routine.time_to,class_routine.room_no,class_routine.day
						FROM class_routine
						INNER JOIN class ON class_routine.class_name=class.id
						INNER JOIN subject ON class_routine.subject_id=subject.id
						INNER JOIN teachers ON class_routine.teacher_id=teachers.id
						WHERE class_routine.class_name=?");
						$stm->execute(array($current_class_status));
						$routineList = $stm->fetchAll(PDO::FETCH_ASSOC);
                        echo "<pre>";
                        print_r($routineList);
                    ?>


                    <div class="widget-inner">
                        <div class="edit-profile m-b30">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class Name</th>
                                            <th>Subject Name</th>
                                            <th>Teacher Name</th>
                                            <th>Day</th>
                                            <th>Starting Time</th>
                                            <th>Ending Time</th>
                                            <th>Room Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=1;
                                            foreach($routineList as $list) :?>
                                       
										
										<tr>
											<td><?php echo $i;$i++;?></td>
											<td><?php echo $list['class_name'];?></td>
											<td><?php echo $list['subject_name'];?></td>
											<td><?php echo $list['teacher_name'];?></td>
											<td><?php echo $list['day'];?></td>
											<td><?php echo $list['time_from'];?></td>
											<td><?php echo $list['time_to'];?></td>
											<td><?php echo $list['room_no'];?></td>
										</tr>
                                        <?php endforeach;?>
									</tbody>
                                    
                                
                                </table>

                            </div>
                        </div>
					</div>
                    <?php else:?>
                        <div class="alert alert-danger">
                            Dont Have any info 
                        </div>
                    <?php endif;?>
				</div>
				<!-- New Class Registration -->
            </div>
			<!-- Your Profile Views Chart END-->
		</div>
	</div>
</main>

<?php require_once('footer.php');?>