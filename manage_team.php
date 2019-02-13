<?php
include('globals.php');

if ($MODE === 9) {
    header('Location: home.php');

    die();
}

session_start();

include('globals.php');
include('config.php');

if (!isset($_SESSION['capt'])) {
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $SITE_NAME; ?> | Manage Team</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="resources/images/logo.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Font Awesome File -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Material Icons File -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
    <div style="background: rgba(10,10,10,0.9); padding: 2%; margin: 0 auto;">
        <?php
        $team = $_SESSION['capt'];
        $datastore = $app['datastore'];
        $key = $datastore->key('team_list', $team);
        $row = $datastore->lookup($key);
        ?>
        <img src="<?php echo $row['team_logo'] ?>" height="30vh" width="30vh" style="height: 4vh; width: 4vh;">
        <a id="my-headings">
            <?php echo $row["team_name"] . '  (' . $row["team_tag"] . ')'; ?>
        </a>
        <a href="edit_team.php" class="btn btn-dark" role="button" style="float: right;">
            <i class="far fa-edit"></i>
        </a>
    </div>
    <br>
    <table class="table">
        <?php
        $email = $_SESSION['email'];
        $key = $datastore->key('users', $email);
        $row = $datastore->lookup($key);
        $cur_id = $row['fb_id'];
        $team = $_SESSION['capt'];
        $query = $datastore->query()
            ->kind('users')
            ->filter('team', '=', $team);
        $results = $datastore->runQuery($query);
        $c = 0;
        foreach ($results as $row) {
            $id = $row['fb_id'];
            $key = $row->key();
            if ($id != $cur_id) {
                if ($c == 0) {
                    echo '<thead class="thead-dark">
                            <tr><th>Facebook</th><th>Steam</th><th></th></tr>
                        </thead>
                        <tbody>';
                }
                $c = $c + 1;
                echo "<tr><td>".
                    '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=large" height="30vh" width="30vh" >	'.
                    '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>'
                    ."</td>
                            <td>".
                    '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" />'.
                    '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>'
                    ."</td>
                            <td class='small'>".
                    '<a href="#" class="btn btn-danger pull-right" role="button" id="kick-'.$id.'"	data-toggle="confirmation" 
                                data-btn-ok-label="Kick!" data-btn-ok-class="btn-danger"
                                data-btn-ok-icon-class="material-icons" data-btn-ok-icon-content="check"
                                data-btn-cancel-label="Cancel" data-btn-cancel-class="btn-primary"
                                data-btn-cancel-icon-class="material-icons" data-btn-cancel-icon-content="close" data-singleton="true"
                                data-title="Are you sure?" data-content="This player will have to request again to join back!"
                                style="font-weight: 700; font-family: Montserrat, sans-serif; margin: 0 2vw; width: 9vw; float: right;">Kick</a>'
                    ."</td></tr>";
            }
        }
        echo '</tbody>';
        ?>
    </table>
    <?php
    if ($c == 0) {
        echo '<div style="text-align: center;"><h3>No Player other than you Found!</h3></div>';
    }
    if ($c == 0) {
        echo '<a href="#" class="btn btn-danger" role="button" id="delete-'.$cur_id.'"
                    style="font-weight: 700; font-family: Montserrat, sans-serif; width: fit-content; margin: 5vh auto; display: block;">Delete Team?</a>';
    }
    ?>

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
</body>
</html>

<script>
    $(document).ready(function(){
        $('[id^=delete-]').click(function() {
            const id = $(this).attr('id');
            const query = id.replace("delete-", "");

            $.ajax({
                url: "func_delete_team.php",
                method:"post",
                data:{query:query},

                success:function(data) {
                    $('a#'+id).text('Deleted!').attr('class', 'btn btn-success');
                    const delay = 200;

                    setTimeout(function(){
                        window.location = 'home.php';
                    }, delay);
                }
            });
        });
    });
</script>

<script>
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        container: 'body',

        onConfirm: function(value) {
            const id = $(this).attr('id');
            const query = id.replace("kick-", "");

            $.ajax({
                url: "func_remove_player.php",
                method:"post",
                data:{query:query},

                success:function(data) {
                    $('a#'+id).text('Kicked!').attr('class', 'btn btn-success');

                    setTimeout(function() {
                        $('a#'+id).closest('tr').remove();
                    }, 1000);

                    setTimeout(function() {
                        if($("tbody tr").length === 0) {
                            setTimeout(function() {
                                window.location = 'home.php';
                            }, 1020);
                        }
                    }, 1000);
                }
            });
        },

        onCancel: function () {
        }
    });
</script>