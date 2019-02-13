<?php
session_start();

if (!isset($_SESSION["steam"]) || !isset($_SESSION["email"]) || !isset($_SESSION["name"])) {
    header('Location: index.php');
    die();
}

include('config.php');
include('globals.php');

if (isset($_GET['leave'])) {
    $email = $_SESSION['email'];
    $datastore = $app['datastore'];

    $transaction = $datastore->transaction();
    $key = $datastore->key('users', $email);
    $task = $transaction->lookup($key);
    $team_old = $task['team'];
    unset($task['team']);
    $transaction->upsert($task);
    $transaction->commit();

    $transaction = $datastore->transaction();
    $key = $datastore->key('count', $team_old);
    $task = $transaction->lookup($key);
    $task['count'] = $task['count'] - 1;
    $transaction->upsert($task);
    $transaction->commit();

    header("Location: home.php");
}
if (isset($_GET['removelink'])) {
    $email = $_SESSION['email'];
    $datastore = $app['datastore'];

    $transaction = $datastore->transaction();
    $key = $datastore->key('users', $email);
    $task = $transaction->lookup($key);
    unset($task['fb_link']);
    $transaction->upsert($task);
    $transaction->commit();

    header("Location: home.php");
}
if (isset($_POST['link'])) {
    $link = $_POST['link'];
    $email = $_SESSION['email'];
    $datastore = $app['datastore'];

    $transaction = $datastore->transaction();
    $key = $datastore->key('users', $email);
    $task = $transaction->lookup($key);
    $task['fb_link'] = $link;
    $transaction->upsert($task);
    $transaction->commit();

    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="resources/images/logo.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

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
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teams.php">Teams</a>
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

<div class="box-gradient wide" style="margin: 0 auto">
    <div class='headline'>
        <div style="text-align: center;">
            <a id='my-headings'>Welcome, <?php echo $_SESSION["name"]?>!</a>
        </div>
    </div>

    <?php
    $email = $_SESSION['email'];
    $datastore = $app['datastore'];
    $key = $datastore->key('users', $email);
    $row = $datastore->lookup($key);

    if(sizeof($row) != 0) {
        echo '<div style="text-align: center;"><br><a>Your Details : </a>';
        echo '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=normal" height="30vh" width="30vh" style="margin-left:1vw;" >	';
        echo '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>';
        echo '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" style="margin-left:1vw;" />';
        echo '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>';
    }

    if (!isset($row['team'])) {
        echo '<div>';
        echo '<br><a style="font-size: 1.5rem; color: #cc0606;">You are not part of any team </a>';
        if ($MODE === 0 || $MODE === 1) {
            echo '<br><br><a href="create_team.php" class="btn btn-primary" role="button">Create a Team</a>&nbsp;&nbsp;&nbsp;'; // Remove for normal working
            echo '<a href="teams.php" class="btn btn-primary" role="button">Join a Team</a></div></div>'; // Remove for normal working
        }
    } else {
        $team_id = $row["team"];
        $key = $datastore->key('team_list', $team_id);
        $row2 = $datastore->lookup($key);

        $logo_url = $row2['team_logo'];
        $team_name = $row2['team_name'];
        $capt = $row2['team_capt_id'];
        $team_tag = $row2['team_tag'];

        echo '<div style="margin: 2vh 0 2vh 0">';
        echo '<a>Team : </a>';
        echo '<img src="' . $logo_url . '" title="" alt="" height="30vh" width="30vh" style="margin-left:1vw;" />';
        echo '<a>  ' . $team_name . ' (' . $team_tag . ') </a>';

        if ($MODE === 0 || $MODE === 1) {
            if ($row['team'] == $email) {
                echo '<a href="manage_team.php" class="btn btn-info" role="button"
							style="font-weight: 700; font-family: Montserrat, sans-serif; margin: 1vh 2vw;">Manage Your Team</a>';
                echo '<button title="' . $team_name . '" data-toggle="popover" data-trigger="focus" data-content="No Pending Requests!" type="button"
							class="btn btn-secondary" id="join_container">Join Requests <span class="badge" id="join_count">0</span></button>';
                $_SESSION['capt'] = $email;
            } else {
                echo '<a href="home.php?leave" class="btn btn-danger" role="button"
						style="font-weight: 700; font-family: Montserrat, sans-serif; margin: 0 2vw;">Leave this Team</a>';
            }
        }
    }
    if ($MODE === 3) {
        if (!isset($row['fb_link'])) {
            echo "" .
                '<form action="#" method="POST" class="form-group" style="margin: 4vh auto 2vh auto;">' .
                '<a style="color: #FF5722;">You need to provide your FB URL to complete your registration.</a>' .
                '<br><a target="_blank" href="https://www.facebook.com/me" style="font-size: 0.7rem;">Click here, copy the URL of the page that opens and paste it below.</a>' .
                '<div class="form-tab">' .
                '<label for="link" class="form-tab-label">Facebook Profile URL:</label>' .
                '<input type="text" class="button_form" placeholder="Enter Full Facebook URL here." id="link" name="link" required>' .
                '<input type="submit" value="Confirm" class="btn btn-success" style="margin: 2vh 0 2vh 2vw;">' .
                '</div>' .
                '</form>';
        } else {
            echo '<br><br><a">Your FB Link is: <a><a href="' . $row['fb_link'] . '">Link (' . $row['fb_link'] . ')</a><a><br>Please check your link by clicking on it once.</a>';
            echo '<br><a href="home.php?removelink" class="btn btn-danger" role="button" style="font-weight: 700; font-family: Montserrat, sans-serif; margin: 2vh 2vw;">Remove Link</a><br>';
            echo '<a style="color: #4CAF50; font-size: 1.2rem;">Your registration is complete.</a>';
            echo '<div style="margin: 3vh 0;"></div>';
        }
    }
    ?>
</div>
</div>
<?php
if (isset($team_id)) {
    $output = '';

    $query = $datastore->query()
        ->kind('users')
        ->filter('team', '=', $team_id);
    $results = $datastore->runQuery($query);

    $output .= '<table class="table">
					<thead class="thead-dark">
						<tr><th>Facebook</th><th>Steam</th></tr>
					</thead>
					<tbody>';

    foreach ($results as $row) {
        $output .= "<tr>
						<td>".
            '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=large" height="30vh" width="30vh" >	'.
            '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>'
            ."</td>
						<td>".
            '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" />'.
            '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>'
            ."</td>
					</tr>";
    }
    echo $output;
}
?>
</table>
<div id="join_req_handle" name="<?php echo $team_id ?>" style='display:none'></div>

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
        $('[data-toggle="tooltip"]').tooltip();
        $('#join_container').popover();

        var query = $('#join_req_handle').attr('name');

        $.ajax({
            url: "func_fetch_join_count.php",
            method:"post",
            data:{query:query},

            success:function(data) {
                $('#join_count').text(data);

                if (data > 0) {
                    $('#join_container').attr('class', 'btn btn-success');
                }
            }
        });

        $('#join_container').click(function(){
            if ($('#join_count').text() > 0) {
                $('#join_container').popover("dispose");
                $('.table').attr('style', 'display:none');

                $.ajax({
                    url: "func_fetch_join_details.php",
                    method:"post",
                    data:{query:query},

                    success:function(data) {
                        $('#join_req_handle').html(data);
                        $('#join_req_handle').attr('style', 'display:block');
                    }
                });
            } else {
                $('#join_container').popover("show");
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
    });
</script>