<?php
include('globals.php');

if ($MODE === 9) {
    header('Location: home.php');
    die();
}

session_start();

include('config.php');

if (isset($_POST['usr'])) {
    $name = $_POST['usr'];
    $logo = $_POST['logo_url'];
    $team_tag = $_POST['tag'];
    $email = $_SESSION['email'];
    $datastore = $app['datastore'];
    $key = $datastore->key('team_list', $email);

    $entity = $datastore->entity($key, [
        'team_name' => $name,
        'team_tag' => $team_tag,
        'team_logo' => $logo
    ]);
    $datastore->upsert($entity);

    $transaction = $datastore->transaction();
    $key = $datastore->key('users', $email);
    $task = $transaction->lookup($key);
    $task['team'] = $email;

    if (isset($task['join_team']))
        unset($task['join_team']);

    $transaction->upsert($task);
    $transaction->commit();

    $init_c = 1;
    $key = $datastore->key('count', $email);
    $entity = $datastore->entity($key, [
        'count' => $init_c,
    ]);
    $datastore->upsert($entity);
    /*
    $transaction = $datastore->transaction();
    $key = $datastore->key('count', 'teams');
    $task = $transaction->lookup($key);
    $task['count'] = $task['count'] + 1;
    $transaction->upsert($task);
    $transaction->commit();
    */
    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | New Team</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teams.php">Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="'<?php echo $FIXTURES_LINK ?>'">Fixtures</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" id="logoutBtn" href="func_logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav><!-- #nav-menu-container -->
</header><!-- #header -->

<div class="box-gradient wide">
    <form action="#" method="POST" onsubmit="return photoValidate()">
        <div class="form-head" style="display: table; margin: 3vw auto;">
            <a id='my-headings'>Team Details</a>
        </div>
        <div class="form-tab">
            <label for="usr" class="form-tab-label">Team Name: &nbsp;&nbsp;</label>
            <input type="text" class="button_form" placeholder="Enter Full Team Name Here" id="usr" name="usr" required>
        </div>
        <div class="form-tab">
            <label for="tag" class="form-tab-label">Team Tag: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" class="button_form" placeholder="Enter Tag of Your Team Here" id="tag" name="tag" required>
        </div>
        <div class="form-tab">
            <label for="logo" class="form-tab-label">Logo URL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" class="button_form" placeholder="Paste URL of High Quality Image of your Team's Logo" name="logo_url" id="logo_url" required>
        </div>
        <div style="text-align: center;">
            <div class="form-tab">
                <img id="logo_show" name="logo_show" style="width:0; height: 0; visibility:hidden;" alt="" src="">
            </div>
            <input type="submit" value="Create Team" class="btn btn-success" style="width: 20%; margin-right: 2%;">
            <a href="home.php" class="btn btn-secondary" style="width: 20%;">Back</a>
        </div>
        <br>
    </form>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

<script>
    let isPhoto = false;

    function testImage(url, timeoutT) {
        return new Promise(function(resolve, reject) {
            const timeout = timeoutT || 5000;
            let timer, img = new Image();
            img.onerror = img.onabort = function() {
                clearTimeout(timer);
                $("#logo_show").attr("style", "width:0vh; height: 0vh;visibility: hidden;");
                isPhoto = false;
            };
            img.onload = function() {
                clearTimeout(timer);
                resolve("success");
                isPhoto = true;
                $("#logo_show").attr("style", "width:30vh; height: 30vh;visibility: inherit;").attr("src", url);
            };
            timer = setTimeout(function() {
                $("#logo_show").attr("style", "width:0vh; height: 0vh; visibility: hidden;");
            }, timeout);
            img.src = url;
        });
    }
    $(document).ready(function(){
        $('#logo_url').keyup(function(){
            const search = $(this).val();
            if(search !== '') {
                testImage(search, 300);
            }
            else {
                $("#logo_show").attr("style", "width:0vh; height: 0vh;visibility: hidden;");
            }
        });
    });
    function photoValidate() {
        if (isPhoto)
            return true;
        else {
            window.alert('Enter Valid Image URL to continue.');
            return false;
        }
    }
</script>