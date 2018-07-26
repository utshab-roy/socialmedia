<?php
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

$updated_post = isset($_POST['content']) ? $_POST['content'] : '';
$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';



if (empty($updated_post)){
    $output['validation'] = 0;
    $validation_messages['empty_post'] =  'Post is completely empty, and that connot be done..';
}

$output['validation_messages'] = $validation_messages;

if(intval($output['validation']) == 1){
    if (isset($_POST['content']) && (!empty($updated_post))){
        $success_messages = update_post($post_id, $updated_post);
        $output['success_messages'] = $success_messages;
        echo json_encode($updated_post);
        die();
    }
}else{
    echo json_encode($output);
    die();
}