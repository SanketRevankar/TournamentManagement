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
    unset($task['join_team']);
    $transaction->upsert($task);
    $transaction->commit();
}
