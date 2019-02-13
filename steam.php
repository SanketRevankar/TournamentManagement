<?php
session_start();

if (!isset($_POST['name']) && !isset($_SESSION["name"])) {
    header("Location: index.php");
    die();
} else if (isset($_POST['name'])) {
    if ($_POST["email"] == 'undefined') {
        header("Location: permissions.php");
        die();
    }
    $name = $_POST["name"];
    $_SESSION["name"] = $name;
    $email = $_POST["email"];
    $_SESSION["email"] = $email;
    $fb_id = $_POST["id"];
    $_SESSION["fb_id"] = $fb_id;
}

include('globals.php');
include('config.php');

$name = $_SESSION["name"];
$email = $_SESSION["email"];
$fb_id = $_SESSION["fb_id"];

$datastore = $app['datastore'];
$user_ip = get_user_ip();
$date_time = (new DateTime())->format('Y-m-d_H');

$key = $datastore->key('login_time_ip', $email);
$row = $datastore->lookup($key);

if (sizeof($row) == 0) {
    $entity = $datastore->entity($key, [
        $date_time => $user_ip,
    ]);
    $datastore->insert($entity);
} else {
    $transaction = $datastore->transaction();
    $key = $datastore->key('login_time_ip', $email);
    $task = $transaction->lookup($key);
    if (!isset($task[$date_time]))
        $task[$date_time] = $user_ip;
    $transaction->upsert($task);
    $transaction->commit();
}

$key = $datastore->key('users', $email);
$row = $datastore->lookup($key);

if (sizeof($row) == 0) {
    if ($MODE === 1 || $MODE === 2 || $MODE === 9) {
        header("Location: welcome.php");
        die();
    }

    $date_time_full = (new DateTime())->format('Y-m-d_H-i-s');
    $key = $datastore->key('users', $email);
    $entity = $datastore->entity($key, [
        'fb_id' => $fb_id,
        'name' => $name,
        'reg_time' => $date_time_full,
    ]);
    $datastore->upsert($entity);
} else {
    if ($MODE === 9 && !isset($row['team'])) {
        echo "<script type='text/javascript'>
            window.alert('You are not part of any team, Logging out.');
            window.location.replace('index.php?logout');
        </script>";
    }
    if (isset($row['steam'])) {
        $_SESSION["steam"] = $row['steam'];
        $_SESSION["steam_icon"] = $row['steam_icon'];
        $_SESSION["steam_nick"] = $row['steam_nick'];
        $_SESSION["steam_id"] = $row['steam_id'];
        $_SESSION["fb_link"] = $row['fb_link'];

        header("Location: home.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Steam Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="resources/images/logo.png" rel="icon">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
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

<div class="box-gradient" style="text-align: center;">
    <h3 class="headline">Welcome, <?php echo $_SESSION["name"]?>!</h3>
    <div>
        <?php
        require ('steamauth/steamauth.php');
        loginbutton();
        ?>
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
    </nav>
</footer>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
