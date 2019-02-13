<?php
session_start();

include('config.php');

$output = '';
$email = $_SESSION['email'];
$datastore = $app['datastore'];
$key = $datastore->key('users', $email);
$row = $datastore->lookup($key);

if (!isset($row['team'])) {
    $team = 1;
} else {
    $team = 0;
}

if (!isset($row['join_team'])) {
    $join_team = 0;
} else {
    $join_team = $row['join_team'];
}

if(isset($_POST["query"])) {
    $upperlimit = $_POST["query"] . json_decode('"\ufffd"');
    $query = $datastore->query()
        ->kind('team_list')
        ->filter('team_name', '>=', $_POST["query"])
        ->filter('team_name', '<', $upperlimit);
    $results = $datastore->runQuery($query);
} else {
    $query = $datastore->query()
        ->kind('team_list');
    $results = $datastore->runQuery($query);
}

$output .= '
		<table class="table">
			<thead class="thead-dark">
				<tr><th>Team Name</th></tr>
			</thead>
			<tbody>';
$c = 1;

foreach ($results as $row) {
    $key = $row->key();
    $key_email = $key->pathEnd()["name"];
    $key = $datastore->key('users', $key_email);
    $user = $datastore->lookup($key);
    $output .= "
			<tr>
				<td>".
        '<a style="margin-right: 1vw;">' . $c . '. </a>'.
        '<img src="' . $row['team_logo'] . '" height="30vh" width="30vh" >	'.
        '<a id="' . $user['fb_id'] . '" href="#" style="padding-left: 1vw"> ' . $row['team_name'] . ' ('. $row['team_tag']  . ')  </a>';

    if ($MODE === 0 || $MODE === 1) {
        if ($team == 1) {
            if ($join_team === $key_email) {
                $output .= '<button  class="btn btn-success pull-right" style="float: right;" id="already-req" ata-btn-ok-label="Request" data-btn-ok-class="btn-success"
			                data-btn-ok-icon-class="material-icons" data-btn-ok-icon-content="check"
			                data-btn-cancel-label="Cancel!" data-btn-cancel-class="btn-danger"
			                data-btn-cancel-icon-class="material-icons" data-btn-cancel-icon-content="close" data-singleton="true"
			                data-title="Request to join this team?" data-content="This will remove all previous requests.">Already Requested!</button>';
            } else {
                $output .= '<button class="btn btn-primary pull-right" style="float: right;" data-toggle="confirmation" id="join-' . $user['fb_id'] . '"
			                data-btn-ok-label="Request" data-btn-ok-class="btn-success"
			                data-btn-ok-icon-class="material-icons" data-btn-ok-icon-content="check"
			                data-btn-cancel-label="Cancel!" data-btn-cancel-class="btn-danger"
			                data-btn-cancel-icon-class="material-icons" data-btn-cancel-icon-content="close" data-singleton="true"
			                data-title="Request to join this team?" data-content="This will remove all previous requests.">
			          		Request to Join</button>';
            }
        }
    }
    $output .= "</td>
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
    echo '<tr><td>No Teams are Registered</td></tr>';

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
                success:function(data)
                {
                    $('#show-team-name-capt').html(data);
                }
            });
        }
    });

    $(document).ajaxStart(function () {
        $.blockUI({
            message: 'Fetching Data',
            css: {
                border: 'none',
                padding: '15px',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                'background-color': 'rgba(10,10,10,0.6)',
                color: '#fff',
                fontSize: '18px',
                fontFamily: '"Montserrat", sans-serif',
                fontWeight: 900
            } });
    });
    $(document).ajaxStop($.unblockUI);
</script>

<script>
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        container: 'body',

        onConfirm: function(value) {
            var id = $(this).attr('id');
            var query = id.replace("join-", "");
            $.ajax({
                url: "func_join_team.php",
                method:"post",
                data:{query:query},

                success:function(data) {
                    $('#'+id).text('Request Sent!');
                    $('#'+id).attr('class', 'btn btn-success pull-right');
                    $('#already-req').text('Request Cancelled!');
                    $('#already-req').attr('class', 'btn btn-danger pull-right');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        },

        onCancel: function () {
        }
    });
</script>	
