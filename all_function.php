<?php
//session_start();
include 'mail_sender.php';
/**this method will check the validation for login
 * @param $email
 * @param $password
 * @return array
 */
function login_validation($email, $password)
{
    global $conn_oop;

    $success_messages = array();
    $error_messages = array();

    $sql = "SELECT * FROM users WHERE email='$email' AND password=MD5('$password') AND publish=1";
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $success_messages['login'] = 'Successfully logged in !';
//        header('location: admin/index.php');
        return $success_messages;
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn_oop->query($sql);
        $row = $result->fetch_assoc();
        $publish = $row['publish'];

        if ($publish == -2) {
            $error_messages['unverified'] = "Unverified account";

//            $_SESSION['message'] = $error_messages;
        } else {
            $error_messages['wrong'] = "Wrong email or password";

//            $_SESSION['message'] = $error_messages;
        }
        return $error_messages;
    }
}


function user_registration($firstname, $lastname, $email, $password)
{
    global $conn_oop;
    $timestamp = time();

    $success_messages = array();

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
function email_exists($email)
{
    global $conn_oop;

    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = $conn_oop->query($sql);
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}

/**
 * this function will verify the user with verified email address
 * @param $code
 * @return mixed
 */
function user_account_verification($code)
{
    global $conn_oop;
    $success_messages = array();
    $sql = "SELECT * FROM users WHERE code='$code'";
    $messages = array();
    $result = $conn_oop->query($sql);
    if ($result->num_rows > 0) {
        $sql_for_validation = "UPDATE users SET publish='1', code='' WHERE code='$code'";
        if ($conn_oop->query($sql_for_validation) === TRUE) {
            $success_messages['account_verified'] = "Account verified successfully !";
            $_SESSION['message'] = $success_messages;
//            header('location: index.php');
            return $success_messages;
        }
    } else {
        $success_messages['already_verified'] = "your account may already verified. Please try to login first.";
        $_SESSION['message'] = $success_messages;
//        header('location: index.php');
        return $success_messages;
    }
    return $success_messages;
}

/**
 * Get posts data using multiple criteria
 *
 * @param int $current_page
 * @param int $per_page
 * @param string $order
 * @param string $order_by
 *
 * @return array
 */
function get_post_data($current_page = 1, $per_page = 10, $order = 'desc', $order_by = 'id')
{
    global $conn_oop;

    $page_data = array();

    $start_form = ($current_page - 1) * $per_page;
    $sql = "SELECT * FROM posts ORDER BY $order_by $order LIMIT $start_form, $per_page";
    $result = $conn_oop->query($sql);

    while ($row = $result->fetch_assoc()) {
        $page_data[] = $row;
    }


    return $page_data;
}//end method get_post_data

/**
 * Get total posts count
 *
 * @return int
 */
function get_total_posts_count()
{
    global $conn_oop;
    $sql = "SELECT COUNT(*) AS total_post FROM posts";
    $result = $conn_oop->query($sql);
    $row = $result->fetch_assoc();
    $total_posts = $row['total_post'];
    return intval($total_posts);
}//end method get_total_posts_count

/**
 * Html markup generator from the posts data
 *
 * @param array $posts
 *
 * @return string
 */
function get_post_data_html($posts = array())
{
    $output = '';
    foreach ($posts as $post) {
        $output .= '<div class="post_box" data-postid="'. $post['id'] . '"><p class="post_box_copy">' . $post['content'] . '</p><a type="button" class="btn btn-danger btn-sm float-right delete_post">Delete</a><a type="button" class="btn btn-primary btn-sm float-right edit_post">Edit</a></div>';
    }

    return $output;
}//end method get_post_data_html

function add_new_post($title, $content){
    global $conn_oop;
    $page_data = array();

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $conn_oop->query($sql);

    $new_sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 1";
    $result = $conn_oop->query($new_sql);
    while($row = $result->fetch_assoc()){
        $page_data[] = $row;
    }
    return $page_data;

}//end of add_new_post method


/**
 * this method deletes the post according to the id
 * @param $id
 * @return array
 */

function delete_post($id){
    global $conn_oop;

    $success_messages = array();
    $error_messages = array();

    $sql = "DELETE FROM posts WHERE id=$id";
    if ($conn_oop->query($sql) === TRUE) {
        $success_messages['post_deleted'] = 'Post deleted successfully !';
        return $success_messages;
    }else{
        $error_messages['database_err'] = $conn_oop->error;
        return $error_messages;
    }
}

/**
 * this method update the post from the posts table and returns the success or error message
 * @param $post_id
 * @param $updated_post
 * @return array
 */

function update_post($post_id, $updated_post){
    global $conn_oop;

    $success_messages = array();
    $error_messages = array();

    $sql = "UPDATE posts SET content='$updated_post' WHERE id='$post_id'";
    if ($conn_oop->query($sql) === TRUE) {
        $success_messages['post_updated'] = 'Post updated successfully !';
        return $success_messages;
    }else{
        $error_messages['database_err'] = $conn_oop->error;
        return $error_messages;
    }
}

