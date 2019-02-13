<!--
    NOT COMPLETED YET
-->
<?php
header('Location: home.php');   // Remove for normal working
die();                          // Remove for normal working
session_start();
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Matches</title>
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <style>
        .popover {
            max-width: none;
        }
    </style>

</head>

<body>
<!--==========================
Header
============================-->
<header id="header">
    <div class="container-fluid">
        <div id="logo" class="pull-left">
            <h1><a 	class="scrollto"><?php echo $SITE_NAME; ?></a></h1>
        </div>
    </div>
    <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="teams.php">Teams</a></li>
            <li class="menu-active"><a href="#">Matches</a></li>
            <!--li><a target="_blank" href="https://challonge.com/ncl_5">Fixtures</a></li-->
            <li><a id="logoutBtn" href="func_logout.php">Logout</a></li>
        </ul>
    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="form-group-one">
    <div style="text-align: center;">
        <a id='my-headings'>Matches</a>
    </div>
</div>
<div id="result"></div>
<div id="team-border" style="display: none; color:#FFF;">
    <div id="team-name-capt" style=" background-color: rgba(10, 10, 10, 0.7); width:70vw; margin: 0 auto; display: block; padding:1vw;color:#FFF;" >
        <a href="#" class="btn btn-danger" role="button" id="close-team-details"
           style="float: right; font-weight: 700; font-family: 'Montserrat', sans-serif; width: 10vw;">Close</a>
        <div id="show-team-name-capt" style="    height: 4vh;    padding: .5vh;"></div>
    </div>
    <div id="team-details"></div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.7/bootstrap-confirmation.min.js"></script>
</body>
</html>
<script>
    $(document).ready(function(){
        load_data();

        function load_data(query) {
            $.ajax({
                url: "func_fetch_matches.php",
                method:"post",
                data:{query:query},
                success:function(data) {
                    $('#result').html(data);
                }
            });
        }
    });
</script>