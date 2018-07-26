//fires the script after the dom ready
jQuery(document).ready(function ($) {
    //focus cursor  on the text-area
    $("textarea#post_area").focus();

    //login form handel begin
    var $login_form = $("#login_form");
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
    var $registration_form  = $("#registration_form");
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

            //now send ajax request
            $.ajax({
                type: "POST",
                url: "pagination_ajax.php",
                data: $data,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    // console.log(data);

                    $this.text('Load More');
                    $post_box_containers.find('#post_box_wrapper').append(data);
                    $this.data('busy', 0);
                    $this.data('page', $page);

                    //now think logically if we need to hide the read more anchor. if yes then remove it, if not then  update it's current page data
                    if($page >= $maxpage){
                        $this.remove();
                    }

                }
            });
        }

    });//end of pagination

    //add a new post
    $post_box_containers.on('submit', '#new_post_form', function (event) {

       event.preventDefault();
       var $this = $(this);

       var $busy = parseInt($this.data('busy'));

       var $form = $('#new_post_form');
       var post_content = $('#post_area').val();

        //now use the jq validation , if valid send ajax request
        // $form.validate({
        //     rules: {
        //         post_area: {
        //             required: true,
        //             minlength: 7
        //         }
        //     },
        //     messages: {
        //         post_area: {
        //             required: "You have to write something in order to POST",
        //             minlength: jQuery.validator.format("At least {0} characters required!")// "Min-length is Seven"
        //         }
        //     }
        // });

        //checking whether the form is valid or not
        // if ($form.valid()){
            // console.log(post_content);
            if($busy == 0){
                $this.data('busy', 1);
                $('#add_post').attr('value', 'Posting...');
                $.ajax({
                    type: "POST",
                    url: "posts_ajax.php",
                    data: 'new_post=' + post_content,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        // console.log(data.validation);
                        if (data.validation == 0) {
                            var $validation_messages = data.validation_messages;
                            $.each($validation_messages, function (index, value) {
                                $('#form_message').html('<div style="color: red; font-size: 20px;">'+ value +'</div>').show();
                            });

                        }else {
                            //adding post on the top using prepend method
                            $post_box_containers.find('#post_box_wrapper').prepend(data);

                            //removing the php error message after successfully posting
                            $('#form_message').hide();

                            //removing the text-area after successfully posting
                            $('textarea#post_area').val("");
                        }
                        $this.data('busy', 0);
                        $('#add_post').attr('value', 'Add Post');
                    }

                });//end of ajax function
            }// end of if(busy == 0)
        // }//end of $form.valid()
    });//end of new post

    //edit the post
    var $post_box_wrapper = $('#post_box_wrapper');
    $post_box_wrapper.on('click', '.edit_post', function (e) {

        e.preventDefault();

        console.log('edit button clicked');

        var $this = $(this);

        var $parent = $this.parent('.post_box');
        var $content = $parent.find('.post_box_copy');
        var $post_id = $parent.data('postid');
        //content of the .post_box_copy
        var $text_content = $content.text();
        // console.log($post_id);

        var $form = $('<form action="#" method="post"><input type="hidden" name="post_id" value="'+$post_id+'" /><textarea rows="3" class="form-control content" name="content">'+$text_content+'</textarea><input type="submit" name="submit" value="Submit" class="btn btn-primary" /></form>');

        $form.insertAfter($content);
        $content.hide();
        $this.hide();
        $text_content_update = '';

        $form.on('submit', function (e) {
            e.preventDefault();
            // var $text_content_update = $form.find('.content').val();

            $.ajax({
                type: "POST",
                url: "update_post_ajax.php",
                //data: 'post_id='+$post_id+'&updated_post='+$text_content_update,
                data: $form.serialize(),
                dataType: 'json',
                cache: false,
                success: function (data) {
                     // console.log(data);
                    if (data.validation == 0) {
                        var $validation_messages = data.validation_messages;
                        $.each($validation_messages, function (index, value) {
                            $('#form_message').html('<div style="color: red; font-size: 20px;">'+ value +'</div>').show();
                        });

                    }else {
                        $form.remove();
                        $content[0].innerText = data;
                        // console.log($content[0].innerText);
                        $content.show();
                        $this.show();
                    }
                }//end of success message
            });//end of ajax function
        });//end of form

    });//end of edit post method

    //delete the post method
    $post_box_wrapper.on('click', '.delete_post', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $parent = $this.parent('.post_box');
        // console.log($parent);
        var $post_id = $parent.data('postid');

        //ajax method beginning for deleting the post
        $.ajax({
            type: "POST",
            url: "delete_post_ajax.php",
            data: 'delete_post_id=' + $post_id,
            dataType: 'json',
            cache: false,
            success: function (data) {
                console.log(data);
                if (data.validation == 0) {
                    var $validation_messages = data.validation_messages;
                    $.each($validation_messages, function (index, value) {
                        $('#form_message').html('<div style="color: red; font-size: 20px;">'+ value +'</div>').show();
                    });
                }else{
                    $parent.remove();//removing the
                }
            }//end of success
        });//end of ajax method
    });//end of delete post method



});//end of document ready function
