<?php
session_start();

include('config.php');

$output = '';

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

    $key_email = $key->pathEnd()["name"];

    $query = $datastore->query()
        ->kind('users')
        ->filter('team', '=', $key_email);
    $results = $datastore->runQuery($query);
}

$output .= '
		<table class="table">
			<thead class="thead-dark">
				<tr><th>Facebook</th><th>Steam</th></tr>
			</thead>
			<tbody>';
$c = 1;

foreach ($results as $row) {
    $output .= "
			<tr>
				<td>".
        '<a style="margin-right: 1vw;"> ' . $c . '. </a>'.
        '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=large" height="30vh" width="30vh" >	'.
        '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>'
        ."</td>
				<td>".
        '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" />'.
        '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>'
        ."</td>
			</tr> 
		";
    $c = $c + 1;
}

echo $output;
$c = 0;

foreach ($results as $row)
    if (sizeof($row) != 0)
        $c = $c + 1;

if ($c == 0)
    echo '<tr><td>No Player is Registered</td></tr>';
