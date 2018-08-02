<?php
//starting the session for a user
session_start();
//if the user is unable to login then redirect to the login page
var_dump($_SESSION);
if(!$_SESSION['logged_in']) {
//    header("location:index.php");
    die();
}

include 'config.php';

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

<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                <h6>Upload a photo...</h6>

                <input type="file" class="form-control">
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <h3>Personal info</h3>

            <form class="edit_profile" role="form">
                <div class="form-group">
                    <label for="first_name" class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="first_name" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="last_name" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="email" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="col-lg-3 control-label">Location:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="location" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="birthday" class="col-lg-3 control-label">Birthday:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="birthday" type="date" value="" >
                    </div>
                </div>


                <div class="form-group">
                    <label for="paw" class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" id="psw" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="con_psw" class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" id="con_psw" type="password" value="">
                    </div>
                </div>
                <div class="form-group">
<!--                    <label class="col-md-3 control-label"></label>-->
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" value="Save Changes">
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
</body>
</html>
