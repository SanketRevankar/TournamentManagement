<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Permission</title>
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
                    <a class="nav-link" id="logoutBtn" href="func_logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="box-gradient wide">
    <div class='headline'>
        <div style="text-align: center;">
            <a id='my-headings'>Hello! We have a problem.</a>
        </div>
    </div>
    <div style="margin: 3%;">
        <a>Please make sure you have a verified email in facebook. Follow the below steps if you have a verified
            email.</a>
        <a>Looks like you denied the permission to share email address and we cannot continue without that
            permission</a><br><br>
        <a>To grant the permission follow the steps:</a>
        <a target="_blank" href="https://www.facebook.com/settings?tab=applications">Click here</a><br><br>
        <a>Find <strong><?php echo $SITE_NAME; ?></strong> app and remove it from your app list</a><br><br>
        <a href="index.php">Click Here</a><a> after completing above step</a><br>
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

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</body>