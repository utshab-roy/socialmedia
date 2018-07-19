<?php
session_start();
include_once 'config.php';
$first_name = $last_name = $email = $password = $password_confirm = '';

//necessary array for the messages
$output = array();
$output['validation'] = 1;
$output['success_messages'] = array();
$output['validation_messages'] = array();

$validation_messages  = array();
$success_messages  = array();

if(isset($_POST['login']) && intval($_POST['login']) == 1){
    //retrieving data from the form
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (empty($email)) {
            $validation_messages['email'] =  'Email is empty, give your email';
            $output['validation'] = 0;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validation_messages['email'] =  'Invalid email';
            $output['validation'] = 0;
        }
    }

    if (isset($_POST['psw'])) {
        $password = $_POST['psw'];
        if (empty($password)) {
            $validation_messages['psw'] =  'Password can not be empty';
            $output['validation'] = 0;
        }
    }

    $output['validation_messages'] = $validation_messages;

    if(intval($output['validation']) == 1){
        //this function will check for the validation of the user login
        $success_messages = login_validation($email, $password);
//        var_dump($success_messages);
        $output['success_messages'] = $success_messages;
        echo json_encode($output);
    }
    else{
        //form is not valid
        echo json_encode($output);
    }
}

function login_validation($email, $password){
    global  $conn_oop;

    $success_messages  = array();
    $error_messages  = array();

    $sql = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password')";
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $success_messages['login'] = 'Successfully logged in !';
//        header('location: admin/index.php');
        return $success_messages;
    }
    else {
        $error_messages['invalid'] = "Wrong email or password";
//        $sql = "SELECT * FROM users WHERE email='$email'";
//        $result = $conn_oop->query($sql);
//        $row = $result->fetch_assoc();
//        $publish = $row['publish'];
//
//        if ($publish == -2){
//            $error_messages['unverified'] = "Unverified account";
//
//            $_SESSION['message'] = $error_messages;
//        }else{
//            $error_messages['wrong'] = "Wrong email or password";
//
//            $_SESSION['message'] = $error_messages;
//        }
        return $error_messages;
    }
}

//if (isset($_POST['user_registration']) && intval($_POST['user_registration']) == 1) {
//    //retrieving data from the form
//    if (isset($_POST['first_name'])) {
//        $first_name = $_POST['first_name'];
//        if (empty($first_name)) {
//            $form_valid = false;
//            $first_name_error = 'First name is empty';
//        }
//    }
//    if (isset($_POST['last_name'])) {
//        $last_name = $_POST['last_name'];
//        if (empty($last_name)) {
//            $form_valid = false;
//            $last_name_error = 'Last name is empty';
//        }
//    }
//
//    if (isset($_POST['email'])) {
//        $email = $_POST['email'];
//        if (empty($email)) {
//            $form_valid = false;
//            $email_error = 'Email is empty';
//        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            $form_valid = false;
//            $email_error = 'Email is not valid';
//        }
//    }
//
//    if (isset($_POST['psw'])) {
//        $password = $_POST['psw'];
//        if (empty($password)) {
//            $form_valid = false;
//            $password_error = 'Password is empty';
//        }
//    }
//
//    if (isset($_POST['psw_confirm'])) {
//        $password_confirm = $_POST['psw_confirm'];
//        if (empty($password_confirm)) {
//            $form_valid = false;
//            $password_error = 'Confirm your password';
//        }
//    }
//
//    //checking whether the password matches
//    if ($form_valid) {
//        if (isset($_POST['psw']) && isset($_POST['psw_confirm'])) {
//            $form_valid = ($password === $password_confirm) ? true : false;
//            $password_confirm_error = 'password did not match';
//        }
//    }
//
//    if($form_valid){
//        global $conn_oop;
//        //inserting data into database from register page
//        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', MD5('$password'))";
//        if ($conn_oop->query($sql) === TRUE) {
////            echo 'Registration completed.';
//        } else {
//            $general_error = $conn_oop->error;
//            echo $general_error;
//        }
//    }
//}

