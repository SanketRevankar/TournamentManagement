<?php
include('globals.php');

if ($MODE === 9) {
    header('Location: home.php');
    die();
}

session_start();

include('config.php');

if (isset($_POST["query"])) {
    unset($_SESSION['capt']);
    $id = $_POST["query"];
    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('fb_id', '=', $id);
    $results = $datastore->runQuery($query);

    foreach ($results as $row)
        if ($row['fb_id'] == $id)
            $key = $row->key();

    $key_email = $key->pathEnd()["name"];

    if ($key_email === $_SESSION['email']) {
        $transaction = $datastore->transaction();
        $task = $transaction->lookup($key);
        unset($task['team']);
        $transaction->upsert($task);
        $transaction->commit();

        $key = $datastore->key('team_list', $key_email);
        $datastore->delete($key);

        $key = $datastore->key('count', $key_email);
        $datastore->delete($key);
        /*
        $transaction = $datastore->transaction();
        $key = $datastore->key('count', 'teams');
        $task = $transaction->lookup($key);
        $task['count'] = $task['count'] - 1;
        $transaction->upsert($task);
        $transaction->commit();
        */
    }
}
