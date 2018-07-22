<?php
//session_start();
include 'mail_sender.php';
/**this method will check the validation for login
 * @param $email
 * @param $password
 * @return array
 */
function login_validation($email, $password){
    global  $conn_oop;

    $success_messages  = array();
    $error_messages  = array();

    $sql = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password') AND publish=1";
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $success_messages['login'] = 'Successfully logged in !';
//        header('location: admin/index.php');
        return $success_messages;
    }
    else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn_oop->query($sql);
        $row = $result->fetch_assoc();
        $publish = $row['publish'];

        if ($publish == -2){
            $error_messages['unverified'] = "Unverified account";

//            $_SESSION['message'] = $error_messages;
        }else{
            $error_messages['wrong'] = "Wrong email or password";

//            $_SESSION['message'] = $error_messages;
        }
        return $error_messages;
    }
}


function user_registration($firstname, $lastname, $email, $password){
    global $conn_oop;
    $timestamp = time();

    $success_messages  = array();

    //inserting data into database from register page
    $sql = "INSERT INTO users (first_name, last_name, email, password, code) VALUES ('$firstname', '$lastname', '$email', MD5('$password'), MD5('$timestamp'))";
    if ($conn_oop->query($sql) === TRUE) {

        $success_messages['new_record'] = "Registration successful. An email will be sent to provided email address for verification.";

        //this will send the verification code to that respect user through mail
        //creating object for mail sender class
        $mail_sender = new mail_sender();
        //calling the send mail function
        $mail_sender->send_mail($lastname, $email, MD5("$timestamp"));
        return $success_messages;

    } else {
        $general_error = $conn_oop->error;
        //echo $general_error;
        $success_messages['database_error'] = $general_error;
    }
    return $success_messages;
}

/**
 * checks if the email already exist or not
 * @param $email
 * @return bool
 */
function email_exists( $email){
    global  $conn_oop;

    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = $conn_oop->query($sql);
    if ($result->num_rows == 0){
        return false;
    }else{
        return true;
    }
}

/**
 * this function will verify the user with verified email address
 * @param $code
 * @return mixed
 */
function user_account_verification($code){
    global $conn_oop;
    $success_messages  = array();
    $sql = "SELECT * FROM users WHERE code='$code'";
    $messages = array();
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $sql_for_validation = "UPDATE users SET publish='1', code='' WHERE code='$code'";
        if ($conn_oop->query($sql_for_validation) === TRUE){
            $success_messages['account_verified'] = "Account verified successfully !";
            $_SESSION['message'] = $success_messages;
//            header('location: index.php');
            return $success_messages;
        }
    }else{
        $success_messages['already_verified'] = "your account may already verified. Please try to login first.";
        $_SESSION['message'] = $success_messages;
//        header('location: index.php');
        return $success_messages;
    }
    return $success_messages;
}

/**
 * this method will create the pagination for the rest of tha page
 * @param int $per_page
 * @param int $current_page
 * @param string $order
 * @param string $order_by
 */
function pagination($per_page = 3, $current_page = 1, $order = 'desc', $order_by = 'id'){
    $page_data = array();
    global  $conn_oop;
    $sql = "SELECT * FROM posts";
    $result = $conn_oop->query($sql);
    $total_posts = $result->num_rows;
    $page_data['total_posts'] = $total_posts;

    $total_pages = ceil($total_posts / $per_page);
    $page_data['total_page'] = $total_pages;

    if ($total_pages > $current_page){// the next page is available


        //I have to store the content of the post from the database
        $begin_of_post = $current_page * $per_page;
        $end_of_post = $begin_of_post + $per_page;
        $count = 0;
        for ($count; $count < $begin_of_post; $count++ ){
            $row = $result->fetch_assoc();
        }
        for ($count; $count < $end_of_post;$count++){
            $row = $result->fetch_assoc();
            $page_data['content'][] =  $row['content'];
        }

            //storing the next page value
        $current_page = $current_page + 1;
        $page_data['current_page'] = $current_page;
    }
    else{//this is the last page
        $page_data['current_page'] = $current_page;
    }
//    var_dump($result->num_rows);
    return $page_data;
}

