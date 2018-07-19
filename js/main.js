//fires the script after the dom ready
jQuery(document).ready(function ($) {
    var $registration_form    = $("#registration_form");
    var $login_form     = $("#login_form");

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
                    // console.log($validation_messages['email']);

                    $.each($validation_messages, function (index, value) {
                        var $error_field = '<label id="' + index + '-error" class="error" for="' + index + '">' + value + '</label>';
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
    });//end of login form

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

                    $.each($validation_messages, function (index, value) {
                        var $error_field = '<label id="' + index + '-error" class="error" for="' + index + '">' + value + '</label>';
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

});
