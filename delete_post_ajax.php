<?php
include_once 'config.php';

//necessary array for the messages
$output = array();
$output['validation'] = 1;
$output['success_messages'] = array();
$output['validation_messages'] = array();

$validation_messages  = array();
$success_messages  = array();

$delete_post_id = isset($_POST['delete_post_id']) ? $_POST['delete_post_id'] : '';

if (empty($delete_post_id)){
    $output['validation'] = 0;
    $validation_messages['post_id_not_found'] =  'ID not found for the requested post';
}

$output['validation_messages'] = $validation_messages;

if(intval($output['validation']) == 1){
    if (isset($_POST['delete_post_id']) && (!empty($delete_post_id))){
        $success_messages = delete_post(intval($delete_post_id));
        $output['success_messages'] = $success_messages;
        echo json_encode($output);
        die();
    }
}else{
    echo json_encode($output);
    die();
}