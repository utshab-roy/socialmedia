<?php
session_start();
include_once 'config.php';


$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 10;
$order = isset($_POST['order']) ? $_POST['order'] : 'desc';
$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'id';
$pagename = isset($_POST['pagename']) ? $_POST['pagename'] : 'homepage';
$author_id = isset($_POST['author_id']) ? intval($_POST['author_id']) : 0;




if ($pagename === 'homepage'){
    $posts = get_post_data($page, $perpage, $order, $orderby);
    $posts_html = get_post_data_html($posts);
    echo json_encode($posts_html);
    die();
}

if ($pagename === 'user_profile'){
//    var_dump('sdfsdfsdfsdfsdf');
    $posts = get_post_data_of_user($page, $perpage, $order, $orderby, $author_id);
    $posts_html = get_post_data_html($posts);
    echo json_encode($posts_html);
    die();
}
