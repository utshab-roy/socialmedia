<?php
//starting the session for a user
session_start();
//if the user is unable to login then redirect to the login page
//var_dump($_SESSION);
if(!$_SESSION['logged_in']) {
    header("location:index.php");
    die();
}

//when the user wants to logout it will destroy the session
if (isset($_GET['logout']) && intval($_GET['logout']) == 1){
    session_destroy();
    header("location:index.php");
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/style.css" />
    <title>Homepage</title>
</head>
<body>

<header>
    <!-- Fixed navbar -->
<!--    fixed-top call add can make the navbar fixed on the top-->
    <nav class="navbar navbar-expand-md navbar-dark  bg-dark">
        <a class="navbar-brand" href="homepage.php">Social Media</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="homepage.php">Homepage <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>

<div class="container" style="padding-left: 100px; padding-right: 100px">
    <div class="row">
        <div class="col-md-12">
            <p style="text-align: right;">Sunshine, <?= $_SESSION["name"]?></p>
            <div>
                <a type="submit" href="homepage.php?logout=1" class="btn btn-danger float-right">Logout</a>

                <h2>All Posts</h2>
            </div>
            <?php
            //returns the total post
            $total = get_total_posts_count();
            $per_page = 3;
            $page = 1;
            $order = 'desc';
            $order_by = 'id';

            $posts = get_post_data($page, $per_page, $order, $order_by);
            $posts_html = get_post_data_html($posts);
            $max_page = intval(ceil($total/$per_page));
            ?>
            <div id="post_box_containers" class="mt-3">
                <div id="new_post_wrapper">
                    <form id="new_post_form" method="post" data-busy="0" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="post_area"><h4>What's on your mind ?</h4></label>
                            <textarea class="form-control" id="post_area" name="post_area" rows="3"></textarea>

                            <input type="file" name="file" id="file" class="form-control" style="width:40%" />

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
                   data-pagename="homepage"
                   href="#" class="post_box_load btn btn-primary btn-md btn-block mb-5">Load More</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery.magnific-popup.js"></script>
<script src="js/main.js?v=<?= $timestamp = time()?>"></script>
</body>
</html>
