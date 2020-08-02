<?php	
	session_start();

	if($_POST['username'] == 'admin' && $_POST['password'] == 'admin'){
	    $_SESSION['username'] = "admin";
	    header('Location:' . "http://localhost/bus_system/web/bus.php");
    }else{
        $path = "http://localhost/bus_system/includes/server/index.php?";
        $action = "action=showAllUsersByEmail&u_email=" . $_POST['username'];
        $apiPath = $path . $action;
        $response = file_get_contents($apiPath);
        $response = json_decode($response, true);
        foreach ($response['results'] as $row) {
            if(password_verify($_POST['password'], $row['u_password'])){
                $_SESSION['username'] = $row['u_name'];
                $_SESSION['user_id'] = $row['u_id'];
                header('Location:' . "http://localhost/bus_system/web/booking.php");
            }
        }
        echo $apiPath;
//        header('Location:' . "http://localhost/bus_system");
    }
?>