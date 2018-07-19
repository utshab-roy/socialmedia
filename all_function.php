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
        $error_messages['invalid'] = "Wrong email or password";
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn_oop->query($sql);
        $row = $result->fetch_assoc();
        $publish = $row['publish'];

        if ($publish == -2){
            $error_messages['unverified'] = "Unverified account";

            $_SESSION['message'] = $error_messages;
        }else{
            $error_messages['wrong'] = "Wrong email or password";

            $_SESSION['message'] = $error_messages;
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
 * this function will verify the user with verified email address.
 * @param $code
 */
function user_account_verification($code){
    global $conn_oop;
    $sql = "SELECT * FROM users WHERE code='$code'";
    $messages = array();
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $sql_for_validation = "UPDATE users SET publish='1', code='' WHERE code='$code'";
        if ($conn_oop->query($sql_for_validation) === TRUE){
            $success_messages['account_verified'] = "Account verified successfully !";
            $_SESSION['message'] = $messages;
            header('location: index.php');
        }
    }else{
        $success_messages['already_verified'] = "your account may already verified. Please try to login first.";
        $_SESSION['message'] = $messages;
        header('location: index.php');
    }
}