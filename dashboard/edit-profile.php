<?php require_once('header.php'); ?>
<?php
    $user_id = $_SESSION['st_loggedin'][0]['id'];

    $stm=$pdo->prepare("SELECT * FROM students WHERE id=?");
    $stm->execute(array($user_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $name = $result[0]['name']; //zero array er index indicate kore...ja name print korbe
    $email = $result[0]['email'];
    $email_status = $result[0]['is_email_varified'];
    $mobile = $result[0]['mobile'];
    $mobile_status = $result[0]['is_mobile_varified'];
    $father_name = $result[0]['father_name'];
    $father_mobile = $result[0]['father_mobile'];
    $mother_name = $result[0]['mother_name'];
    $gender = $result[0]['gender'];
    $birthday = $result[0]['birthday'];
    $address = $result[0]['address']; 
    $roll = $result[0]['roll']; 
    $current_class = $result[0]['current_class']; 
    $registration_date = $result[0]['registration_date']; 
    $photo = $result[0]['photo'];

	// Update Student Profile
	if(isset($_POST['profile_update_btn'])){
		$name = $_POST['name'];
		$father_name = $_POST['father_name'];
		$father_mobile = $_POST['father_mobile'];
		$mother_name = $_POST['mother_name'];
		$gender = $_POST['gender'];
		$birthday = $_POST['birthday'];
		$address = $_POST['address'];
		$photo_name = $_FILES['photo']['name'];


		if(empty($father_name)){
			$error = "Father's name is required.";
		}
		else if(empty($father_mobile)){
			$error = "Father's mobile number
			is required.";
		}

		// photo valid kina seta check krb...not equal disi tai photo na dileo cholbe
		else{
			if(!empty($photo_name)){
				$target_dir = "assets/images/students/";
				//$target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
				$target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if($extension != 'png' AND $extension != 'jpg' ){
					$error = "Photo must be in 'png' or 'jpg' type.";
				}
				else{
					// *** move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) ei attribute k modify kra holo next dui line a ------ ***
					$temp_name = $_FILES["photo"]["tmp_name"];
					$final_path =$target_dir . "user_id_". $user_id."_.".$extension; 
					move_uploaded_file($temp_name, $final_path);
				}

			}

			// jdi kono photo upload na kre thle aaager photo tai thkbe
			else{
				$final_path = Student('photo',$user_id);
			} 
				$update = $pdo->prepare("UPDATE students SET name=?,father_name=?,father_mobile=?,mother_name=?,gender=?,birthday=?,address=?,photo=? WHERE id=?");
				$update->execute(array(
					$name,
					$father_name,
					$father_mobile,
					$mother_name,
					$gender,
					$birthday,
					$address,
					$final_path,
					$user_id
			));
			
			$success = "Profile uploaded successfully";
		}
	}
	
?> 
<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Update Profile</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Update Profile</li>
			</ul>
		</div>	
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="wc-title">
						<h4>Update Profile</h4>
					</div>
					<div class="widget-inner">
						<form class="edit-profile m-b30" method="POST" action="" enctype="multipart/form-data">
							<div class="">
							
							
							<?php if(isset($error)) :?>
								<div class="alert alert-danger"><?php echo $error; ?></div>
							<?php endif;?>
							<?php if(isset($success)) :?>
								<div class="alert alert-success"><?php echo $success; ?></div>
							<?php endif;?>
							
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Name</label>
								<div class="col-sm-7">
									<input class="form-control" name="name" type="text" value="<?php echo $name;?>">
								</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-7">
										<input class="form-control" type="text" value="<?php echo $email;?>"readonly>
									</div> <!-- "name" nilam nah email r mobile er jnn krn ei duto update krte hbe nah  -->
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Mobile Number</label>
									<div class="col-sm-7">
										<input class="form-control" type="text" value="<?php echo $mobile;?>"readonly> 
										<!-- "name" nilam nah email r mobile er jnn krn ei duto update krte hbe nah  -->
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Father's Name</label>
									<div class="col-sm-7">
										<input class="form-control" name="father_name" type="text" value="<?php echo $father_name;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Father's Mobile</label>
									<div class="col-sm-7">
										<input class="form-control" name="father_mobile" type="text" value="<?php echo $father_mobile;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Mother's Name</label>
									<div class="col-sm-7">
										<input class="form-control" name="mother_name" type="text" value="<?php echo $mother_name;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Gender</label>
									<div class="col-sm-7">
										<label for=""><input 
										<?php if($gender == "Male") {echo "checked";}?>
										type="radio" name="gender" id="" value="Male" checked> &nbsp; Male</label> &nbsp;
										<label for=""><input 
										<?php if($gender == "Female") {echo "checked";}?>
										type="radio" name="gender" id="" value="Female"> &nbsp; Female</label> &nbsp;
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Birthday</label>
									<div class="col-sm-7">
										<input class="form-control" name="birthday" type="date" value="<?php echo $birthday;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Address</label>
									<div class="col-sm-7">
										<input class="form-control" name="address" type="text" value="<?php echo $address;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Profile Photo</label>
									<div class="col-sm-7">

										<?php if($photo != null) :?>
											<div class="profile-photo">
											<img style="height:200px;width:auto;" src="<?php echo $photo;?>">
											</div>
										<?php endif;?>

										<mark><small>If dont want add photo then you can skip this field</small></mark>

										<input class="form-control" name="photo" type="file">
									</div>
								</div>
							</div>
							<div class="">
								<div class="">
									<div class="row">
										<div class="col-sm-2">
										</div>
										<div class="col-sm-7">
											<button type="submit" class="btn" name="profile_update_btn">Save changes</button>
											<button type="reset" class="btn-secondry">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Your Profile Views Chart END-->
		</div>
	</div>
</main> 


<?php require_once('footer.php'); ?> 