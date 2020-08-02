<!DOCTYPE html>
<?php session_start(); ?>
<?php $_SESSION['username'] = null ?>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Main Login</title>

    <?php require_once('includes/helpers.php'); ?>

    <?php
    echo loadResources(array('css/nav.css', 'css/login.css', 'css/toastr.css'),
        array('js/functions.js', 'js/jquery.min.js', 'js/toastr.js'))
    ?>

    <?php //check_session() ?>

</head>

<body>

<!-- stayhi db connection  -->
<?php //include './includes/stayhidb_conn.php'; ?>


<!-- <form action="./controller/proc_signin.php" method="post"> -->

<div class="wrapper">

    <!-- Sign In Form-->
    <div class="form">
        <h1>Register</h1>
        <form action="./register.php" method="post">
            <div class="field-wrap">
                <label>
                    Email Address<span class="req">*</span>
                </label>
                <input name="u_email" id="u_email" type="text" required autocomplete="off"/>
            </div>
            <div class="field-wrap">
                <label>
                    Name<span class="req">*</span>
                </label>
                <input name="u_name" id="u_name" type="text" required autocomplete="off"/>
            </div>

            <div class="field-wrap">
                <label>
                    Password<span class="req">*</span>
                </label>
                <input name="u_password" id="u_password" type="password" required autocomplete="off"/>
            </div>

            <br/>
            <button type="submit" id="submitButton" class="button button-block">
                Register
            </button>
            <br/>

        </form>
        <!-- End of Sign in form -->
    </div>
</div>

<!-- footer  -->
<footer></footer>

</body>
<script>
    $('#submitButton').click(function (e) {
        e.preventDefault();
        $.ajax({

            url: "http://localhost/bus_system/includes/server/index.php",

            data: {
                'action': "addUser",
                'u_email': $('#u_email').val(),
                'u_password': $('#u_password').val(),
                'u_name': $('#u_name').val()
            },

            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },

            success: function (data) {
                console.log(data);
                alert('Successfully Registered!');
                window.location.replace("http://localhost/bus_system/index.php");
            },

            type: 'POST'
        })
    })
</script>
</html>


