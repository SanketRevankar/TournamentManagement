<?php
session_start();

include('config.php');

$output = '';
$email = $_SESSION['email'];
$datastore = $app['datastore'];
$query = $datastore->query()->kind('match');
$results = $datastore->runQuery($query);
$output .= '<div class="table-responsive" id="tablebox-one">
		<table class="table"  id="tablelist-one">
			<thead>
				<tr>
					<th>
						<a>ID</a>
						<a style="margin-left: 5%;">Matches Details</a>
					</th>
				</tr>
			</thead>
			<tbody>';

foreach ($results as $row) {
    $key = $row->key();
    $key_email = $key->pathEnd()["name"];

    $key_1 = $datastore->key('team_list', $row['team1_id']);
    $task_1 = $datastore->lookup($key_1);
    $pic1 = $task_1['team_logo'];
    $team1 = substr($row['team1'], 0, 20);
    $team1 = str_pad($team1, 20, " ", STR_PAD_BOTH);

    $key_2 = $datastore->key('team_list', $row['team2_id']);
    $task_2 = $datastore->lookup($key_2);
    $pic2 = $task_2['team_logo'];
    $team2 = substr($row['team2'], 0, 20);
    $team2 = str_pad($team2, 20, " ", STR_PAD_BOTH);

    $key_3 = $datastore->key('users', $email);
    $task_3 = $datastore->lookup($key_3);
    $user_team = $task_3['team'];

    $key_11 = $datastore->key('users', $row['team1_id']);
    $user_1 = $datastore->lookup($key_11);
    $id_1 = $user_1['fb_id'];

    $key_12 = $datastore->key('users', $row['team2_id']);
    $user_2 = $datastore->lookup($key_12);
    $id_2 = $user_2['fb_id'];

    $output .= "<tr>
				<td><div style='text-align: center;'>
				    <a style='float: left;'>" . $key_email . ".</a>
				    <img src='" . $pic1 . "' height='60vh' width='60vh' style='margin-left: 3%;'>
				    <a id='". $id_1 ."' href='#' style='margin-left: 6%;'>" . $team1 . " </a>
				    <img src='https://i.imgur.com/kM8PxGJ.jpg' height='30vh' width='30vh' style='margin: 2px 2%;'>
				    <a id='". $id_2 ."' href='#' style='margin-right: 6%;'> " . $team2 . "</a>
				    <img src='" . $pic2 . "' height='60vh' width='60vh'><br>";
    if ($user_team == $row['team2_id'] || $user_team == $row['team1_id']) {
        if (isset($row['ip_ext'])) {
            $output .= "<a>IP: </a><a href='steam://connect/". $row["ip_ext"] ."' style='margin: 0 auto;'>". $row["ip_ext"] ."</a>";
        } else {
            $output .= "<a>IP not available yet, check before 20 - 30 minutes of match time.</a>";
        }
    }
    $output .= "</div></td></tr>";
}

echo $output;
$c = 0;

foreach ($results as $row)
    if (sizeof($row) != 0)
        $c = $c + 1;

if ($c == 0)
    echo '<tr><td>No Matches found</td></tr>';

?>
<script>
    $(document).ready(function(){
        $('td a').click(function() {
            var id = $(this).attr('id');
            var query = id.replace('#', '');

            $.ajax({
                url: "func_fetch_team_details.php",
                method:"post",
                data:{query:query},

                success:function(data)
                {
                    $('#my-headings').attr("style", "display: none");
                    $('#team-border').attr("style", "display: block");
                    $('#team-details').html(data);
                    load_team_details(query);
                    $('#search-box').attr("style", "display: none");
                    $('#result').attr("style", "display: none");
                }
            });
        });

        $('#close-team-details').click(function() {
            $('#my-headings').attr("style", "display: block");
            $('#team-border').attr("style", "display: none");
            $('#search-box').attr("style", "display: block");
            $('#result').attr("style", "display: block");
        });

        function load_team_details(query) {
            $.ajax({
                url: "func_fetch_teamname-capt.php",
                method:"post",
                data:{query:query},

                success: function (data)
                {
                    $('#show-team-name-capt').html(data);
                }
            });
        }
    });
</script>