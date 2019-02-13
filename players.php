<!--
    NOT COMPLETED YET
-->
<?php
header('Location: home.php');  // Remove for normal working
die();                          // Remove for normal working
session_start();
include('config.php');
include('globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Player Details</title>
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
    <div class="container-fluid">
        <div id="logo" class="pull-left">
            <h1><a class="scrollto"><?php echo $SITE_NAME; ?></a></h1>
        </div>
    </div>
    <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li><a href="home.php">Home</a></li>
            <li class="menu-active"><a href="#">Players</a></li>
            <li><a href="teams.php">Teams</a></li>
            <li><a id="logoutBtn" href="func_logout.php">Logout</a></li>
        </ul>
    </nav><!-- #nav-menu-container -->
</header><!-- #header -->
<div class="form-group">
    <div style="text-align: center;"><a id='my-headings'>Player Details</a></div>
    <div class="input-group">
        <input type="text" class="button" name="search_text" id="search_text" placeholder="Search by Facebook Name or Steam Nick" class="form-control" />
    </div>
</div>
<div id="result"></div>
</div>
<div style="clear:both"></div>

<!-- JavaScript Libraries -->
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
</body>
</html>

<script>
    $(document).ready(function(){
        load_data();

        function load_data(query) {
            $.ajax({
                url: "func_fetch_players.php",
                method:"post",
                data:{query:query},
                success:function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#search_text').keyup(function(){
            var search = $(this).val();
            if (search !== '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
</script>