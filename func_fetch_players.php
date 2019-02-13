<?php
session_start();

include('config.php');

$output = '';
$datastore = $app['datastore'];

if(isset($_POST["query"])) {
    $upperlimit = $_POST["query"] . json_decode('"\ufffd"');
    $query = $datastore->query()
        ->kind('users')
        ->filter('name', '>=', $_POST["query"])
        ->filter('name', '<', $upperlimit);
    $results = $datastore->runQuery($query);
} else {
    $query = $datastore->query()
        ->kind('users');
    $results = $datastore->runQuery($query);
}

$output .= '<div class="box-gradient">
            <table class="table">
                <thead>
                    <tr><th>Facebook</th><th>Steam</th></tr>
                </thead>
                <tbody>';

foreach ($results as $row) {
    $output .= "
			<tr>
				<td>".
        '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=large" height="30vh" width="30vh" >	'.
        '<a target="_blank" href = "' . $row['fb_link']. '"> ' . $row['name'] . '</a>'
        ."</td>
				<td>".
        '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" />'.
        '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>'
        ."</td>
			</tr>
		";
}

echo $output;

$c = 0;

foreach ($results as $row)
    if (sizeof($row) != 0)
        $c = $c + 1;

if ($c == 0)
    echo '<tr><td>No Person with that Name/ Nick is Registered</td></tr>';
