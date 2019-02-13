<?php
session_start();

include('globals.php');

require ('steamauth/steamauth.php');

# You would uncomment the line beneath to make it refresh the data every time the page is loaded
// unset($_SESSION['steam_uptodate']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $SITE_NAME; ?> | Steam Login</title>
</head>
<body>
<?php
if (isset($_SESSION['steamid'])) {
    include('steamauth/userInfo.php');
    include('config.php');

    $steam = $steamprofile['steamid'];
    $steam_icon = $steamprofile['avatarfull'];
    $steam_nick = $steamprofile['personaname'];
    $email = $_SESSION['email'];
    $communityid = $steam;
    $authserver = bcsub($communityid, '76561197960265728') & 1;
    $authid = (bcsub($communityid, '76561197960265728') - $authserver) / 2;
    $steamid = "STEAM_0:$authserver:$authid";

    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('steam', '=', $steam);
    $results = $datastore->runQuery($query);

    $row = [];
    foreach ($results as $row1) {
        $row = $row1;
    }

    if (sizeof($row) == 0) {
        $transaction = $datastore->transaction();
        $key = $datastore->key('users', $email);
        $task = $transaction->lookup($key);
        $task['steam'] = $steam;
        $task['steam_icon'] = $steam_icon;
        $task['steam_nick'] = $steam_nick;
        $task['steam_id'] = $steamid;
        $_SESSION["steam"] = $steam;
        $_SESSION["steam_icon"] = $steam_icon;
        $_SESSION["steam_nick"] = $steam_nick;
        $_SESSION["steam_id"] = $steamid;
        $transaction->upsert($task);
        $transaction->commit();

        header('Location: home.php');
    } else {
        echo "<script type='text/javascript'>window.alert('Steam ID already registered!');
            window.location.replace('index.php?logout');
            </script>";
    }
}
?>
</body>
</html>
<!--Version 3.2-->
