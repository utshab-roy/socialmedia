<?php
include_once 'config.php';


$new_post = isset($_POST['new_post']) ? $_POST['new_post'] : '';

if (empty($new_post)){
    echo json_encode($new_post);
    die();
}

elseif (intval(strlen($new_post)) < 7){
    echo json_encode($new_post);
    die();
}

elseif (isset($_POST['new_post']) && (!empty($new_post))){
    //    echo json_encode($new_post);
    $post_array = add_new_post('Default Title',$new_post);
    $posts_html = get_post_data_html($post_array);
    echo json_encode($posts_html);
    die();
}


