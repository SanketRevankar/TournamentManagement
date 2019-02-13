<?php
session_start();

include('config.php');

$output = '';

if (isset($_POST["query"])) {
    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('team', '=', $_POST['query']);
    $results = $datastore->runQuery($query);

    $c = 0;
    foreach ($results as $row)
        if (sizeof($row) != 0)
            $c = $c + 1;
    echo $c;
}
