<?php
session_start();
include_once 'config.php';
$email = $password = '';

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

//account verification for the first time login
if (isset($_GET['verification']) && (intval($_GET['verification']) == 1)){
    $code = $_GET['code'];
    $success_messages = user_account_verification($code);
    $output['success_messages'] = $success_messages;
    echo json_encode($output);
}


