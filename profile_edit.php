<?php
//starting the session for a user
session_start();
//if the user is unable to login then redirect to the login page
//var_dump($_SESSION);
if(!$_SESSION['logged_in']) {
//    header("location:index.php");
    die();
}
include 'config.php';

$info_obj='';
$row = get_all_user_data($_SESSION['user_id']);

if (!($row['info'] === "")) :
    $info_obj = json_decode($row['info']);
//echo '<pre>';
//    var_dump($info_obj) ;
//echo '</pre>';
endif;

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style>
    </style>

    <title>Edit Profile</title>
</head>
<body>
<header>
    <!-- Fixed navbar -->
    <!--    fixed-top call add can make the navbar fixed on the top-->
    <nav class="navbar navbar-expand-md navbar-dark  bg-dark">
        <a class="navbar-brand" href="homepage.php">Social Media</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Homepage</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>

<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <div id="profile_pic">

                <?php
                if (!file_exists('lib/blueimp/server/php/users/thumbnail/'.$_SESSION['user_id'].'.jpeg')){
                    echo '<img id="avatar" src="http://via.placeholder.com/200x200" alt="avatar">';
                }else{
                    $pic_name = 'lib/blueimp/server/php/users/thumbnail/'.$_SESSION['user_id'].'.jpeg?v=' . time();
                    echo "<img id='avatar' src='$pic_name' class='avatar img-circle' alt='avatar'>";
                }
                ?>

                </div>
                <h6>Upload a photo...</h6>
                <form action="post">
                    <input id="fileupload" type="file" name="files[]" class="form-control" data-url="lib/blueimp/server/php/" style="display: none;">
                </form>

            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <h3>Personal info</h3>

            <form action="profile_edit.php" method="post" id="profile_edit" role="form">
                <div class="form-group">
                    <label for="first_name" class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="first_name" name="first_name" type="text" value="<?=$row['first_name']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="last_name" name="last_name" type="text" value="<?=$row['last_name']?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="email" name="email" type="text" value="<?=$row['email'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="col-lg-3 control-label">Location:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="location" name="location" type="text" value="<?= $info_obj->Location ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="birthday" class="col-lg-3 control-label">Birthday:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="birthday" name="birthday" type="date" value="<?= $info_obj->Birthday ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="website" class="col-lg-3 control-label">Website:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="website" name="website" type="text" value="<?=$info_obj->Website ?>" >
                    </div>
                </div>


                <div class="form-group">
                    <label for="change_paw" class="col-md-3 control-label">Change Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" id="change_paw" name="change_paw" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="con_psw" class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" id="con_psw" name="con_psw" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
<!--                    <label class="col-md-3 control-label"></label>-->
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary" value="">Update</button>
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>


<script src="lib/blueimp/js/vendor/jquery.ui.widget.js"></script>
<script src="lib/blueimp/js/jquery.iframe-transport.js"></script>
<script src="lib/blueimp/js/jquery.fileupload.js"></script>

<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/main.js?v=<?= $timestamp = time()?>"></script>
</body>
</html>
