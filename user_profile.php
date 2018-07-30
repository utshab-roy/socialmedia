<?php
//starting the session for a user
session_start();
//if the user is unable to login then redirect to the login page
var_dump($_SESSION);
if(!$_SESSION['logged_in']) {
//    header("location:index.php");
    die();
}


include 'config.php';

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style>
    </style>

    <title>User Profile</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Welcome, <?=$_SESSION["name"]?></h2>
            <a type="submit" href="homepage.php?logout=1" class="btn btn-danger float-right">Logout</a>
        </div>
    </div>
    <div class="row">
<!--        This section is for user data-->
        <div class="col-4">
            User data and information
        </div>
<!--        This section is for user post created by the user-->
        <div class="col-8">
            <div>
                <h2>All Posts</h2>
            </div>
            <?php
            $author_id = $_SESSION['user_id'];
            //returns the total post
            $per_page = 3;
            $page = 1;
            $order = 'desc';
            $order_by = 'id';

            $total = get_total_posts_count_of_user($author_id);
            $posts = get_post_data_of_user($page, $per_page, $order, $order_by, $author_id);
            $posts_html = get_post_data_html($posts);
            $max_page = ceil($total/$per_page);
            var_dump($max_page);

            ?>
            <div id="post_box_containers" class="mt-3">
                <div id="new_post_wrapper">
                    <form id="new_post_form" action="post" data-busy="0">
                        <div class="form-group">
                            <label for="post_area"><h4>What's on your mind ?</h4></label>
                            <textarea class="form-control" id="post_area" name="post_area" rows="3"></textarea>
                            <div id="form_message"></div>
                        </div>
                        <input type="submit" class="btn btn-primary mb-3" id="add_post" name="add_post" value="Add Post" />
                    </form>
                </div>
                <div id="post_box_wrapper">
                    <?php
                    echo $posts_html;
                    ?>
                    <!--                    <div class="post_box" data-toggle="modal" data-target="#post_modal" id="post_box_15"></div>-->
                </div>
                <?php if($total >  $per_page): ?>
                    <a data-busy="0" data-maxpage="<?php echo $max_page; ?>" data-order="<?php echo $order; ?>"
                       data-orderby="<?php echo $order_by; ?>" data-page="<?php echo intval($page); ?>"
                       data-perpage="<?php echo intval($per_page); ?>" data-total="<?php echo intval($total); ?>"
                       data-pagename="user_profile" data-author_id="<?php echo intval($author_id);?>"
                       href="#" class="post_box_load btn btn-primary btn-md btn-block mb-5">Load More</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/main.js?v=<?= $timestamp = time()?>"></script>
</body>
</html>
