console.log('hi there');
//fires the script after the dom ready
jQuery(document).ready(function ($) {
    var $registration_form    = $("#registration_form");
    var $login_form     = $("#login_form");
    var $load_posts      = $("#load_posts");

    //login form handel begin
    $login_form.on('submit', function (event) {
        event.preventDefault();
        console.log('Login form submitted, sending ajax request');

        var $login_form_data_serialized = $login_form.serialize();
        // console.log($login_form_data_serialized);
        $.ajax({
            type: "POST",
            url: "login_ajax.php",
            data: $login_form_data_serialized,
            dataType: 'json',
            beforeSend: function () {

            },
            cache: false,
            success: function (data) {
                console.log(data);

                if (data.validation == 0) {
                    //highlight the error fields and show error messages
                    var $validation_messages = data.validation_messages;
                    $('.error').remove();
                    $.each($validation_messages, function (index, value) {
                        var $error_field = '<label id="' + index + '-error" class="error"  style="color: red" for="' + index + '">' + value + '</label>';
                        if ($('#' + index + '-error').length > 0) {
                            $('#' + index+ '-error').html($error_field).show();
                        }
                        else {
                            $('#login_' + index).after($error_field);
                        }
                    });
                }
                else {
                    //highlight the success fields and show the messages
                    var $success_messages = data.success_messages;
                    var $form_message = $('#form_messages');

                    $.each($success_messages, function (index, value) {
                        if (index === 'login'){
                            $form_message.html('<div class="alert alert-success" role="alert">'+value+'</div>').show();
                            // window.location.replace("homepage.php");

                        }else{
                            $form_message.html('<div class="alert alert-danger" role="alert">'+value+'</div>').show();
                        }
                    });
                    $('#sign_up_form').remove();
                }
            },
            error: function (err) {
                console.log(err);
            }
        }); // end of ajax method
    });//end of login form

    //registration form handel begin
    $registration_form.on('submit', function (event) {

        event.preventDefault();
        // console.log('Registration form submitted, sending ajax request');
        var $registration_form_data_serialized = $registration_form.serialize();
        console.log($registration_form_data_serialized);
        $.ajax({
            type: "POST",
            url: "registration_ajax.php",
            data: $registration_form_data_serialized,
            dataType: 'json',
            beforeSend: function () {

            },
            cache: false,
            success: function (data) {
                console.log(data);

                if (data.validation == 0) {
                    //highlight the error fields and show error messages
                    var $validation_messages = data.validation_messages;
                    $('.error').remove();
                    $.each($validation_messages, function (index, value) {
                        var $error_field = '<label id="' + index + '-error" class="error"  style="color: red" for="' + index + '">' + value + '</label>';
                        if ($('#' + index + '-error').length > 0) {
                            $('#' + index+ '-error').html($error_field).show();
                        }
                        else {
                            $('#' + index).after($error_field);
                        }
                    });
                }
                else {
                    //highlight the success fields and show the messages
                    var $success_messages = data.success_messages;
                    var $form_message = $('#form_messages');

                    $.each($success_messages, function (index, value) {
                        if (index === 'new_record'){
                            $form_message.html('<div class="alert alert-success" role="alert">'+value+'</div>').show();
                            $('.modal').modal('toggle');
                            // window.location.replace("homepage.php");
                            // $('#login_form').remove();
                            // $form_message.append('<a type="button" class="btn btn-primary btn-lg" href="admin/index.php">Admin Panel</a>').show();
                        }else{
                            $form_message.html('<div class="alert alert-danger" role="alert">'+value+'</div>').show();
                        }
                    });
                    $('#sign_up_form').remove();
                }
            },
            error: function (err) {
                console.log(err);
            }
        }); // end of ajax method
    });//end of registration form


    //ajax pagination
    var $post_box_containers = $('#post_box_containers');

    $post_box_containers.on('click', '.post_box_load', function (e) {
        e.preventDefault();

        var $this = $(this);

        var $page = parseInt($this.data('page'));
        // console.log($this.data);
        var $perpage = parseInt($this.data('perpage'));
        var $order = $this.data('order');
        var $orderby = $this.data('orderby');
        var $total = parseInt($this.data('total'));
        var $maxpage = parseInt($this.data('maxpage'));
        var $busy = parseInt($this.data('busy'));

        $page++;
        // console.log($maxpage);

        if($busy == 0){
            $this.data('busy', 1);
            $this.text('loading');
            var $data ='page='+$page+'&perpage='+$perpage+'&order='+$order+'&orderby='+$orderby;

            $.ajax({
                type: "POST",
                url: "posts_ajax.php",
                data: $data,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    console.log(data);

                    $this.text('Load More');
                    $post_box_containers.find('#post_box_wrapper').append(data);
                    $this.data('busy', 0);
                    $this.data('page', $page);

                    if($page >= $maxpage){
                        $this.remove();
                    }

                    //now think logically if we need to hide the read more anchor. if yes then remove it, if not then  update it's current page data
                }
            });

        }


        //now send ajax request
    });

});//end of document ready function
