<?php
include_once 'config.php';


$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 10;
$order = isset($_POST['order']) ? $_POST['order'] : 'desc';
$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'id';

$new_post = isset($_POST['new_post']) ? $_POST['new_post'] : '';

if (isset($_POST['new_post']) && (!empty($new_post))){

//    echo json_encode($new_post);

    $post_array = add_new_post('Default Title',$new_post);
    $posts_html = get_post_data_html($post_array);
    echo json_encode($posts_html);

}else{//this logic needs tobe changed
    $posts = get_post_data($page, $perpage, $order, $orderby);
    $posts_html = get_post_data_html($posts);
    echo json_encode($posts_html);
}

die();
