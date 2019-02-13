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
    $email = $_SESSION["email"];
    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('fb_id', '=', $id);
    $results = $datastore->runQuery($query);

    foreach ($results as $row)
        if ($row['fb_id'] == $id)
            $key = $row->key();

    $transaction = $datastore->transaction();
    $key_this = $datastore->key('users', $email);
    $task = $transaction->lookup($key_this);
    $task['join_team'] = $key->pathEnd()["name"];
    $transaction->upsert($task);
    $transaction->commit();
}
