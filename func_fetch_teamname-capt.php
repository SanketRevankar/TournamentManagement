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

    $key_old = $key;
    $key_email = $key->pathEnd()["name"];
    $key = $datastore->key('team_list', $key_email);
    $row = $datastore->lookup($key);
    $logo_url = $row['team_logo'];
    $team_name = $row['team_name'];
    $row = $datastore->lookup($key_old);

    $c_key = $datastore->key('count', $key_email);
    $c_row = $datastore->lookup($c_key);

    $output .= '<button class="btn btn-dark disabled" style="min-width: unset; font-weight: 700; opacity: .9;">' . $c_row["count"] . '</button>';
    $output .= '<img src="' . $logo_url . '" title="" alt="" height="30vh" width="30vh" style="margin-left:1vw;" />';
    $output .= '<a> ' . $team_name . '</a>';
    $output .= '<a style="margin-left:1vw;"> Captain : </a>';
    $output .= '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=normal" height="30vh" width="30vh" style="margin-left:1vw;" >';
    $output .= '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>';
    $output .= '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" style="margin-left:1vw;" />';
    $output .= '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>';
    echo $output;
}
