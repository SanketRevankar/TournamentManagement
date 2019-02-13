<?php
include "globals.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="resources/images/logo.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">

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

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-4">
                    <a class="nav-link" href="index.php">Login</a>
                </li>
            </ul>
        </div>

    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="box-gradient wide" style="margin: 10vh auto 1vh auto">
    <div class="headline" style="padding: 2vh 0 2vh 0; background-color: rgba(0, 0, 0, 1);">
        <div style="text-align: center;">
            <a id='my-headings'>Welcome!</a>
        </div>
    </div>

    <!--iframe id="youtube-autoplay" src="https://www.youtube.com/embed/1EkDbVAxkaQ?rel=0&showinfo=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="1"
        style="width: 70vw;height: 45vh; margin: 3vh auto; display: block;"></iframe-->

    <div style="text-align: center;">
        <br>
        <?php
        if ($MODE === 1 || $MODE === 2) {
            echo '<a style="color: brown; font-size: 1.5rem;">Registration Closed!</a><br>';
            echo '<a style="font-size: 1rem; color: brown;">Only Players who are registered will be able to login</a><br><br>';
        } else if ($MODE === 9) {
            echo '<a style="color: brown; font-size: 1.2rem;">Registration Closed and Teams are finalized!</a><br>';
            echo '<a style="font-size: 1rem; color: brown;">Only Players who are registered and in a team will be able to login</a><br><br>';
        } else {
            echo '<a style="font-size=16px">Login/Register to Participate in <?php echo $SITE_NAME; ?> Tourney!</a><br><br>';
        }
        ?>
        <a href="index.php" class="btn btn-primary">Login</a>
    </div>
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

</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</html>
