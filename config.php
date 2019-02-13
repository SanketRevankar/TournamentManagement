<?php
include('globals.php');

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
}
if ($MODE === 2) {
    if (!isset($_SESSION['fb_link'])) {
        header('Location: welcome.php');
    }
}

	require __DIR__ . '/vendor/autoload.php';

	use Google\Cloud\Datastore\DatastoreClient;
	use Silex\Application;
	$app = new Application();
	$app['debug'] = true;
$app['project_id'] = $PROJECT_ID;

	$app['datastore'] = function () use ($app) {
	    $projectId = $app['project_id'];
	    $datastore = new DatastoreClient([
	        'projectId' => $projectId
	    ]);
	    return $datastore;
	};
	
	function get_user_ip()
	{
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
            $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

