<?php
include 'config.php';

//global $conn_oop;
//$sql = "SELECT * FROM posts";
//$result = $conn_oop->query($sql);
//
//var_dump($result->num_rows);
//pagination();

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <title>Homepage</title>
</head>
<body>
<div class="container-fluid" style="padding-left: 100px; padding-right: 100px">
    <div class="row">
        <div class="col-md-12">
            <h2>All Posts</h2>
            <?php
            //returns the total post
            $total = get_total_posts_count();
            $per_page = 3;
            $page = 1;
            $order = 'desc';
            $order_by = 'id';

            $posts = get_post_data($page, $per_page, $order, $order_by);
            $posts_html = get_post_data_html($posts);
            $max_page = ceil($total/$per_page);
            ?>
            <div id="post_box_containers" class="">
                <div id="post_box_wrapper">
                    <?php
                    echo $posts_html;
                    ?>
                </div>
                <?php if($total >  $per_page): ?>
                <a data-busy="0" data-maxpage="<?php echo $max_page; ?>" data-order="<?php echo $order; ?>"
                   data-orderby="<?php echo $order_by; ?>" data-page="<?php echo intval($page); ?>"
                   data-perpage="<?php echo intval($per_page); ?>" data-total="<?php echo intval($total); ?>"
                   href="#" class="post_box_load">Load More</a>
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
<script src="js/main.js?v=<?= $timestamp = time()?>"></script>
</body>
</html>