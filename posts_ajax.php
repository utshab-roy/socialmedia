<?php
session_start();
//var_dump($_SESSION);

include_once 'config.php';



//necessary array for the messages
$output = array();
$output['validation'] = 1;
//$output['success_messages'] = array();
$output['validation_messages'] = array();

$validation_messages  = array();
//$success_messages  = array();

$user_id = $_SESSION['user_id'];

$new_post = isset($_POST['new_post']) ? $_POST['new_post'] : '';


if (empty($new_post)){
    $output['validation'] = 0;
    $validation_messages['post_empty'] =  'Nothing to post...';
}

elseif (intval(strlen($new_post)) < 7){
    $output['validation'] = 0;
    $validation_messages['post_char'] =  'At least seven charter required...';
}

$output['validation_messages'] = $validation_messages;

if(intval($output['validation']) == 1){
    if (isset($_POST['new_post']) && (!empty($new_post))){
        $post_array = add_new_post($new_post, $user_id);
        $post_id = get_post_id();
        image_upload($post_id);


        $posts_html = get_post_data_html($post_array);
    echo json_encode($posts_html);
    die();
    }
}else{
    echo json_encode($output);
    die();
}




