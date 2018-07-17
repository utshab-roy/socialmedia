<?php
include 'config.php';

$first_name = $last_name = $email = $password = $password_confirm = '';

$first_name_error = $last_name_error = '';
$email_error = '';
$password_error = '';
$general_error = '';
$password_confirm_error = '';

$form_valid = true;

if (isset($_POST['user_registration']) && intval($_POST['user_registration']) == 1) {
    //retrieving data from the form
    if (isset($_POST['first_name'])) {
        $first_name = $_POST['first_name'];
        if (empty($first_name)) {
            $form_valid = false;
            $first_name_error = 'First name is empty';
        }
    }
    if (isset($_POST['last_name'])) {
        $last_name = $_POST['last_name'];
        if (empty($last_name)) {
            $form_valid = false;
            $last_name_error = 'Last name is empty';
        }
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (empty($email)) {
            $form_valid = false;
            $email_error = 'Email is empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_valid = false;
            $email_error = 'Email is not valid';
        }
    }

    if (isset($_POST['psw'])) {
        $password = $_POST['psw'];
        if (empty($password)) {
            $form_valid = false;
            $password_error = 'Password is empty';
        }
    }

    if (isset($_POST['psw_confirm'])) {
        $password_confirm = $_POST['psw_confirm'];
        if (empty($password_confirm)) {
            $form_valid = false;
            $password_error = 'Confirm your password';
        }
    }

    //checking whether the password matches
    if ($form_valid) {
        if (isset($_POST['psw']) && isset($_POST['psw_confirm'])) {
            $form_valid = ($password === $password_confirm) ? true : false;
            $password_confirm_error = 'password did not match';
        }
    }

    if($form_valid){
        global $conn;
        //inserting data into database from register page
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', MD5('$password'))";
        if ($conn->query($sql) === TRUE) {
//            echo 'Registration completed.';
        } else {
            $general_error = $conn->error;
            echo $general_error;
        }
    }
}

if (isset($_POST['user_login']) && intval($_POST['user_login']) == 1) {
    //retrieving data from the form
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (empty($email)) {
            $form_valid = false;
            $email_error = 'Email is empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_valid = false;
            $email_error = 'Email is not valid';
        }
    }

    if (isset($_POST['psw'])) {
        $password = $_POST['psw'];
        if (empty($password)) {
            $form_valid = false;
            $password_error = 'Password is empty';
        }
    }

    if($form_valid){
        global  $conn;

        $sql = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
//            echo "logged in";
        } else {
            echo "<h3 class='text-danger' >Wrong email or password</h3>";
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <title>Social Media</title>
</head>
<body>
<div class="container text-center">
    <div class="row">
        <div class="col-md-6 offset-md-3">
<!--            sign in section-->
            <form class="form-signin" action="index.php" method="post">
                <h1 class="display-3">Social Media</h1>
<!--                <a href="../socialmedia"><img src="https://image.ibb.co/eiByzJ/logo.jpg" alt="logo" width ="500px" border="0"></a>-->
                <h1 class="h3 mb-3 mt-3 font-weight-normal">Please sign in</h1>

                <label for="email" class="sr-only">Email address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="" autofocus="">

                <label for="psw" class="sr-only">Password</label>
                <input type="password" id="psw" name="psw" class="form-control" placeholder="Password" required="">
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button name="user_login" value="1" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                <p class="mt-3">Still not a member ? Please Sign Up</p>

                <!-- Button trigger modal -->
                <button class="btn btn-lg btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#exampleModalCenter">Sign up</button>
                <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
            </form>
<!--            end of sign in section-->
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalCenterTitle">Sign Up</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<!--                Sign up section-->
                <form action="index.php" method="post" class="needs-validation" novalidate>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Username" aria-describedby="inputGroupPrepend" required>
                                <div class="invalid-feedback">
                                    Please enter your email.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="psw">Password</label>
                            <input type="password" class="form-control" id="psw" name="psw" placeholder="Password" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="con_psw">Confirm Password</label>
                            <input type="password" class="form-control" id="con_psw" name="con_psw" placeholder="Repeat your Password" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                            <label class="form-check-label" for="invalidCheck">
                                Agree to terms and conditions
                            </label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary"  name="user_registration" value="1">Submit form</button>
                    </div>
                </form>
<!--                end of sign up section-->
            </div>
        </div>
    </div>
</div>


<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>