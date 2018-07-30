<?php
session_start();
//if the user is unable to login then redirect to the login page
if(!$_SESSION['logged_in']) {
    header("location:../login.php");
    die();
}
include_once 'config.php';

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
//exit();

//necessary array for the messages
$output = array();
$output['validation'] = 1;
$output['success_messages'] = array();
$output['validation_messages'] = array();

$validation_messages  = array();
$success_messages  = array();

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

$location = isset($_POST['location']) ? $_POST['location'] : '';
$birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : '';
$website = isset($_POST['website']) ? $_POST['website'] : '';

$info = array();

$info['location'] = $location;
$info['birth_date'] = $birth_date;
$info['website'] = $website;

$info = json_encode($info);


if (empty($email)){
    $output['validation'] = 0;
    $validation_messages['empty_post'] =  'Email cannot be empty...';
}

$output['validation_messages'] = $validation_messages;

if(intval($output['validation']) == 1){
    if (isset($_POST['email']) && (!empty($email))){
        $success_messages = update_user_info($first_name, $last_name, $email, $info, $user_id);
        $output['success_messages'] = $success_messages;
        $row = get_all_user_info($user_id);
        echo json_encode($row);
        die();
    }
}else{
    echo json_encode($output);
    die();
}
