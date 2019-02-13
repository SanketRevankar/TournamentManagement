<?php
include('globals.php');

if ($MODE === 9) {
    header('Location: home.php');
    die();
}

session_start();

include('config.php');

if (isset($_POST["query"])) {
    $id = $_POST["query"];
    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('fb_id', '=', $id);
    $results = $datastore->runQuery($query);

    foreach ($results as $row)
        if ($row['fb_id'] == $id)
            $key = $row->key();


    $transaction = $datastore->transaction();
    $task = $transaction->lookup($key);
    $team_old = $task['team'];

    if ($team_old === $_SESSION['email'])
        unset($task['team']);

    $transaction->upsert($task);
    $transaction->commit();

    if ($team_old === $_SESSION['email']) {
        $key_email = $key->pathEnd()["name"];
        $c_key = $datastore->key('count', $team_old);
        $transaction = $datastore->transaction();
        $task = $transaction->lookup($c_key);
        $task['count'] = $task['count'] - 1;
        $transaction->upsert($task);
        $transaction->commit();
    }

}
