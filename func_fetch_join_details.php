<?php
session_start();

include('config.php');

$output = '';

if (isset($_POST["query"])) {
    $datastore = $app['datastore'];
    $query = $datastore->query()
        ->kind('users')
        ->filter('join_team', '=', $_POST['query']);
    $results = $datastore->runQuery($query);

    echo '<a style="display:none" id="query_old">'.$_POST['query'].'</a>';

    $output .= '<div>
			<table class="table">
				<thead>
					<tr><th>Facebook</th><th>Steam</th><th class="small"></th></tr>
				</thead>
				<tbody class="thead-dark">';
    foreach ($results as $row) {
        $id = $row['fb_id'];
        $output .= "
				<tr>
					<td>".
            '<img src="https://graph.facebook.com/' . $row['fb_id'] . '/picture?type=large" height="30vh" width="30vh" >	'.
            '<a target="_blank" href = "https://www.facebook.com/app_scoped_user_id/' . $row['fb_id'].'"> ' . $row['name'] . '</a>'
            ."</td>
					<td>".
            '<img src="'.$row['steam_icon'].'" title="" alt="" height="30vh" width="30vh" />'.
            '<a target="_blank" href = "https://steamcommunity.com/profiles/' . $row['steam'].'"> ' . $row['steam_nick'] . '</a>'.
            "</td>
					<td class='small'>".
            '<a href="#" class="btn btn-success pull-right btn-lg" id="accept-'.$id.'" style="float: right; padding: 0.5vw; min-width: unset;    margin: 0 0.5vw;"
							data-toggle="tooltip" title="Accept!"><span class="fas fa-user-check"></span></a>'.
            '<a href="#" class="btn btn-danger pull-right btn-lg" id="ignore-'.$id.'" style="float: right; padding: 0.5vw; min-width: unset;    margin: 0 0.5vw;"
							data-toggle="tooltip" title="Ignore"><span class="fas fa-user-times"></span></a>'.
            '<a href="#" class="btn btn-success" style="display:none" id="show_message_'.$id.'"></a>'
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
        echo '<tr><td>No Player is Registered</td></tr>';
}
?>

<script>
    $(document).ready(function(){
        $('[id^=accept-]').click(function() {
            var id = $(this).attr('id');
            var query = id.replace("accept-", "");
            var query1 = $('#query_old').text();

            $.ajax({
                url: "func_fetch_team_count.php",
                method:"post",
                data:{query:query1},

                success: function (data) {
                    if (data == <?php echo $MAX_PLAYERS; ?>) {
                        $('#accept-'+query).attr('style', 'display:none');
                        $('#ignore-'+query).attr('style', 'display:none');
                        $("#show_message_"+query).text('Team Full!');
                        $('#show_message_'+query).attr('class', 'btn btn-danger');
                        $('#show_message_'+query).attr('style', 'display:block');
                    } else {
                        $.ajax({
                            url: "func_accept_player.php",
                            method:"post",
                            data:{query:query},

                            success: function (data) {
                                $('#accept-'+query).attr('style', 'display:none');
                                $('#ignore-'+query).attr('style', 'display:none');
                                $("#show_message_"+query).text('Accepted!');
                                $('#show_message_'+query).attr('style', 'display:block');

                                setTimeout(function () {
                                    $('#show_message_'+query).closest('tr').attr('style', 'display:none');
                                }, 1000);

                                $.ajax({
                                    url: "func_fetch_join_count.php",
                                    method:"post",
                                    data:{query:query1},

                                    success:function(data) {
                                        $('#join_count').text(data);
                                        if (data === '0') {
                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        });

        $('[id^=ignore-]').click(function() {
            var id = $(this).attr('id');
            var query = id.replace("ignore-", "");

            $.ajax({
                url: "func_ignore_player.php",
                method:"post",
                data:{query:query},

                success:function(data) {
                    $('#accept-'+query).attr('style', 'display:none');
                    $('#ignore-'+query).attr('style', 'display:none');
                    $("#show_message_"+query).text('Ignored!');
                    $('#show_message_'+query).attr('class', 'btn btn-danger');
                    $('#show_message_'+query).attr('style', 'display:block');

                    setTimeout(function () {
                        $('#show_message_'+query).closest('tr').attr('style', 'display:none');
                    }, 1000);

                    var query1 = $('#query_old').text();

                    $.ajax({
                        url: "func_fetch_join_count.php",
                        method:"post",
                        data:{query:query1},
                        success:function(data) {
                            $('#join_count').text(data);
                            if (data === '0') {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        }
                    });
                }
            });
        });
    });
</script>