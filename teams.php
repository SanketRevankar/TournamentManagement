<?php
include('globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Teams</title>
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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="<?php echo $FIXTURES_LINK ?>">Fixtures</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" id="logoutBtn" href="func_logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="box-gradient wide">
    <div style="text-align: center;">
        <a id='my-headings'>Teams Registered</a>
    </div>
    <div id="result"></div>
    <div id="team-border" style="display: none; color:#FFF;">
        <div id="team-name-capt" style=" background-color: rgba(10, 10, 10, 0.7); margin: 0 auto; display: block; padding:1vw;color:#FFF;" >
            <a href="#" class="btn btn-danger" role="button" id="close-team-details" style="float: right;"><span class="fas fa-window-close"></span></a>
            <div id="show-team-name-capt" style="padding: .5vh;"></div>
        </div>
        <br>
        <div id="team-details"></div>
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

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.0.2/dist/bootstrap-confirmation.min.js" integrity="sha256-kXOU25SzGb87lJUwyN168lZkoc8s5XwbNuvt8VaBEl4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
</body>

<script>
    $(document).ready(function(){
        load_data();

        function load_data(query) {
            $.ajax({
                url: "func_fetch_team.php",
                method:"post",
                data:{query:query},

                success:function(data)
                {
                    $('#result').html(data);
                }
            });
        }
    });

    $(document).ajaxStart(function () {
        $.blockUI({
            message: 'Fetching Data',
            css: {
                border: 'none',
                padding: '15px',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'background-color': 'rgba(10,10,10,0.6)',
                color: '#fff',
                fontSize: '18px',
                fontFamily: '"Montserrat", sans-serif',
                fontWeight: 900
            } });
    });

    $(document).ajaxStop($.unblockUI);
</script>