<?php
include('globals.php');

session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: welcome.php");

    die();
}
?>

<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Facebook Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="resources/images/logo.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!--==========================
  Header
============================-->
<header id="header">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">

        <span class="navbar-brand mr-auto">
            <?php echo $SITE_NAME; ?>
        </span>

    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="box-gradient" style="text-align: center;">
    <h3 class="headline">Login Using Facebook</h3><br>
    <a id="loginBtn" href="#" class="connect facebook fb-login-button" data-max-rows="1" data-size="large" scope="public_profile,email" data-button-type="login_with">
        <div class="connect__icon">
            <i class="fa fa-facebook"></i>
        </div>
        <div class="connect__context">
            <span>Sign in with <strong>Facebook</strong></span>
        </div>
    </a>
</div>

<!--==========================
Footer
============================-->

<footer>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom justify-content-center">

        <ul class="navbar-nav">
            <li class="nav-item mr-4">
                <p>&copy; Copyright <strong><?php echo $SITE_NAME; ?></strong> All Rights Reserved</p>
            </li>
        </ul>

    </nav><!-- #nav-menu-container -->
</footer><!-- #footer -->

<script>
    document.getElementById('loginBtn').addEventListener('click', function() {
        FB.login(function(response) {
            if (response.authResponse) {
                //user just authorized your app
            }
        }, {scope: 'email,public_profile', return_scopes: true});
    }, false);

    function statusChangeCallback(response) {
        if (response && response.status === 'connected') {
            testAPI();
        } else {
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId: <?php echo $FB_APP_ID; ?>,
            cookie     : true,  // enable cookies to allow the server to access
                                // the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.8' // use graph api version 2.8
        });

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });

        // After your onload method has been called and initial login state has
        // already been determined. (See above about not using these during a page's
        // init function.)
        FB.Event.subscribe('auth.authResponseChange', auth_response_change_callback);
        FB.Event.subscribe('auth.statusChange', auth_status_change_callback);

    };

    // In your JavaScript
    var auth_response_change_callback = function(response) {
        statusChangeCallback(response);
    };

    var auth_status_change_callback = function(response) {
        statusChangeCallback(response);
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function testAPI() {
        FB.api('/me?fields=email,name', function(response) {
            if (!response["error"]) {
                var form = document.createElement('form');
                document.body.appendChild(form);
                form.method = 'post';
                form.action = 'steam.php';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'name';
                input.value = response["name"];
                form.appendChild(input);
                var input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'email';
                input1.value = response["email"];
                form.appendChild(input1);
                var input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'id';
                input2.value = response["id"];
                form.appendChild(input2);
                form.submit();
            }
        });
    }

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=' + <?php echo $FB_APP_ID; ?> +'&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function status(){
        FB.api('/me?fields=email,name', function(response) {
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
