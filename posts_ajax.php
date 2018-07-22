<?php
include_once 'config.php';

$per_page = $current_page = 0;
$order = $order_by = '';

if(isset($_GET['per_page']) && intval($_GET['per_page']) >= 1){
    $per_page = intval($_GET['per_page']);
}

if(isset($_GET['page']) && intval($_GET['page']) >= 1){
    $current_page = intval($_GET['page']);
}


if(isset($_GET['order']) && strval($_GET['order']) == 'desc'){
    $order = strval($_GET['order']);
}else{
    $order = 'asc';
}

if(isset($_GET['orderby'])){
    $order_by = strval($_GET['orderby']);
}

$data = array();

//$data['per_page'] = $per_page;
//$data['page'] = $current_page;
//$data['order'] = $order;
//$data['orderby'] = $order_by;

$page_data =  pagination($per_page, $current_page, $order, $order_by);
$current_page = $page_data['current_page'];


echo json_encode($page_data);



die();
