<?php require_once('header.php'); ?>
<?php

    if(isset($_POST['change_btn'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $user_id = $_SESSION['st_loggedin'][0]['id'];

        // database er password ta return krbe...login password er sthematch ache kina seta check krbe
        $db_password = Student('password',$user_id);  //config.php thke Student namer function ta ei khane call krbe...password hosse columnn name

        if(empty($current_password)){
            $error = "Fill the current password required field";
        }
        else if(empty($new_password)){
            $error = "Fill the new password required field";
        }
        else if(empty($confirm_new_password)){
            $error = "Fill the confirm new password required field";
        }
        else if($db_password != SHA1($current_password)){
            $error = "Current password is wrong!";
        }
        else if($new_password != ($confirm_new_password)){
            $error = "Not Matched";
        }
        // uporer else,if gulo sob thik thkle akn password update krb
        else {
            $update = $pdo->prepare("UPDATE students SET password = ? WHERE id=?");
            $update->execute(array(SHA1($confirm_new_password),$user_id));
        }

    }

?>

<!--Main container start -->
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Profile</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Change Password</li>
            </ul>
        </div>
        <!-- Card -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <?php if(isset($error)) :?>
                            <div class="alert alert-danger">
                                <?php echo $error;?>
                            </div>  
                        <?php endif; ?> 
                        <?php if(isset($success)) :?>
                            <div class="alert alert-success">
                                <?php echo $success;?>
                            </div>
                        <?php endif;?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="change_btn" class="btn bg-success text-white" value="change_password">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once('footer.php'); ?>