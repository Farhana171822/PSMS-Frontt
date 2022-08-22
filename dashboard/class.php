<?php 
	require_once('header.php');
	if(isset($_POST['create_btn'])){
		$class_id = $_POST['class_id'];
		$student_id = $_SESSION['st_loggedin'][0]['id']; // bringing $student_id from new_class_registration table

		$insert = $pdo->prepare("INSERT INTO new_class_registration(student_id,register_class) vALUES(?,?)");
		$insert->execute(array($student_id,$class_id));
		$update = $pdo->prepare("UPDATE students SET current_class=? WHERE id=?");
		$update->execute(array($class_id,$student_id)); // $class_id theke $current_class pabo..oi $student_id te update hobe j se kon class a registration kortse
		$success = "Class Registration Done!";
	}



	$current_class_status = Student('current_class',$_SESSION['st_loggedin'][0]['id']); //student id thke current class pabo
	
	if($current_class_status != null){ // $current_class_status jodi null na hoi thle oi student id er registration validity check krbe
		$current_date = date('Y-m-d');
		$stm=$pdo->prepare("SELECT * FROM class WHERE start_date <= ? AND end_date >= ? AND id=?"); //sob logic complete korle result show krbe
		$stm->execute(array($current_date,$current_date,$current_class_status));
		$classCount = $stm->rowCount();
		$classDetails = $stm->fetchAll(PDO::FETCH_ASSOC);
		echo $classCount;
	}

	else{
		$classCount = 0; // current_class_status null na hole classcount zero print hbe krn ta rkono course assign kora nai
	}
	 
?>

<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Class</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Class</li>
			</ul>
		</div>	
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-6 m-b30">
				<div class="widget-box">


				 <?php if($classCount != 1) :?> <!--classCount not equal null hole student er id registration kora nei ba registration er validity sesh hoye gese -->

					<!-- New Class Registration -->
					<div class="wc-title">
						<h4>New Registration Class</h4>
					</div>

					<?php if(isset($success)) : ?>
						<div class="alert alert-success"><?php echo $success;?></div>
					<?php endif;?>

					<div class="widget-inner">
						<form class="edit-profile m-b30" method="POST" action="">
							<div class="row">
								<div class="col-12">
									<!--no need <div class="ml-auto">
										<h3>1. Basic info</h3>
									</div> -->
								</div>
								<div class="form-group col-6">
									<label class="col-form-label" for="class_id">Select Class</label>
									<div>

										<?php 
											$current_date = date('Y-m-d'); 
											$stm=$pdo->prepare("SELECT * FROM class WHERE start_date <= ? AND end_date >= ?");
											$stm->execute(array($current_date,$current_date));
											$result = $stm->fetchAll(PDO::FETCH_ASSOC); 

										?>
										<select name="class_id" id="class_id" class="form-control">
											<?php   
												foreach($result as $row) :
											?>
												<option value="<?php echo $row['id'];?>"><?php echo $row['class_name'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<!-- <div class="form-group col-6">
									<label class="col-form-label">Course title</label>
									<div>
										<input class="form-control" type="text" value="">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Course start</label>
									<div>
										<input class="form-control" type="text" value="">
									</div>
								</div> 
								<div class="form-group col-6">
									<label class="col-form-label">Course expire</label>
									<div>
										<input class="form-control" type="text" value="">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Teacher name</label>
									<div>
										<input class="form-control" type="text" value="">
									</div>
								</div>-->
								<div class="seperator"></div>
								
								
								<!-- <div class="col-12">
									<table id="item-add" style="width:100%;">
										<tr class="list-item">
											<td>
												<div class="row">
													<div class="col-md-4">
														<label class="col-form-label">Course Name</label>
														<div>
															<input class="form-control" type="text" value="">
														</div>
													</div>
													<div class="col-md-3">
														<label class="col-form-label">Course Category</label>
														<div>
															<input class="form-control" type="text" value="">
														</div>
													</div>
													<div class="col-md-3">
														<label class="col-form-label">Course Category</label>
														<div>
															<input class="form-control" type="text" value="">
														</div>
													</div>
													<div class="col-md-2">
														<label class="col-form-label">Close</label>
														<div class="form-group">
															<a class="delete" href="#"><i class="fa fa-close"></i></a>
														</div>
													</div>
												</div>
											</td>
										</tr>
									</table>
								</div> -->
								<div class="col-12">
									<button type="submit" name="create_btn" class="btn">Save changes</button>
								</div>
							</div>
						</form>
					</div>

					<?php else :?>
						<div class="wc-title">
							<h4>Class Details</h4>
						</div>
						<div class="widget-inner">
							<div class="edit-profile m-b30">
								<div class="table-responsive">
									<table class="table">
										<tr>
											<td><b>Class Name</b></td>
											<td><?php echo $classDetails[0]['class_name'];?></td>
											
										</tr>
										<tr>
											<td><b>Subjects</b></td>
											<td>
												<?php
													$subject_list = json_decode($classDetails[0]['subjects']);
													foreach($subject_list as $new_subject){
													echo getSubjectName($new_subject)."<br>";}
												?>
											</td>
											
										</tr>
										<tr>
											<td><b>Start Date</b></td>
											<td><?php echo $classDetails[0]['start_date'];?></td>
											
										</tr>
										<tr>
											<td><b>End Date</b></td>
											<td><?php echo $classDetails[0]['end_date'];?></td>
											
										</tr>
									</table>

								</div>
							</div>
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