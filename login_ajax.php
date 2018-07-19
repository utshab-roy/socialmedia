<?php
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