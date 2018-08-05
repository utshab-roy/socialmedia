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

$user_id = $_SESSION['user_id'];


$first_name = $last_name = $email = $password = $password_confirm = $location = $birthday = $website = '';

//retrieving data from the form
if (isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    if (empty($first_name)) {
        $validation_messages['first_name'] = 'First name is empty';
        $output['validation'] = 0;
    }
}
if (isset($_POST['last_name'])) {
    $last_name = $_POST['last_name'];
    if (empty($last_name)) {
        $validation_messages['last_name'] = 'Last name is empty';
        $output['validation'] = 0;
    }
}

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

if (isset($_POST['change_paw'])) {
    $password = $_POST['change_paw'];
    if (empty($password)) {
        $validation_messages['change_paw'] =  'Password can not be empty';
        $output['validation'] = 0;
    }
}

if (isset($_POST['con_psw'])) {
    $password_confirm = $_POST['con_psw'];
    if (empty($password_confirm)) {
        $validation_messages['con_psw'] = 'Confirm your password';
        $output['validation'] = 0;
    }
}

//checking whether the password matches
if(intval($output['validation']) == 1){
    if (isset($_POST['psw']) && isset($_POST['psw_confirm'])) {
        $output['validation'] = ($password === $password_confirm) ? 1 : 0;
        $validation_messages['psw_match'] = 'password did not match';
    }
}


$info = array();

$location = isset($_POST['location']) ? $_POST['location'] : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$website = isset($_POST['website']) ? $_POST['website'] : '';


$info['Location'] = $location;
$info['Birthday'] = $birthday;
$info['Website'] = $website;
$info = json_encode($info);



if(intval($output['validation']) == 1){
    //if form validation passed
    $success_messages =  update_user_info($first_name, $last_name, $email, $info, $password, $user_id);
    $output['success_messages'] = $success_messages;
    echo json_encode($output);
}else{
    //form is not valid
    $output['validation_messages'] = $validation_messages;
    echo json_encode($output);
}

