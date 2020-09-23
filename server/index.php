<?php
    header('Content-Type: application/json');
    $dHost = '';
    $dUser = '';
    $dPass = '';
    $dName = '';
    $conn = mysqli_connect($dHost, $dUser, $dPass, $dName);
    if(mysqli_error($conn)) {
        die('{"success": "false", "error": "MySQL error! Try again later!"}');
    }
    if(!isset($_GET['method'])) {
	    die('{"success": "false", "error": "The GET method \'method\' was not set!"}');
    } else {
    	$method = $_GET['method'];
    }
    
    if($method == "post") {
        if(!isset($_GET['identifier'])) {
            die('{"success": "false", "error": "The GET method \'identifier\' was not set!"}');
        }
        if(!isset($_GET['url'])) {
            die('{"success": "false", "error": "The GET method \'url\' was not set!"}');
        }
        $sql = "INSERT INTO url (identifier, url) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_GET['identifier'], $_GET['url']);
        if(mysqli_stmt_execute($stmt)) {
            die('{"success": "true"}');
        } else {
            die('{"success": "false", "e": "exists", "error": "MYSQL error! ' . mysqli_error($conn) . '"}');
        }
    } elseif($method = "get") {
        if(!isset($_GET['identifier'])) {
            die('{"success": "false", "error": "The GET method \'identifier\' was not set!"}');
        }
        $sql = "SELECT url FROM url WHERE identifier = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_GET['identifier']);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $info = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if(isset($info[0])) {
                $info = $info[0];
            }
            if(empty($info)) {
                die('{"success": "false", "error": "Does not exist!"}');
            }
            die('{"success": "true", "url": "' . $info['url'] . '"}');
        } else {
            die('{"success": "false", "e": "exists", "error": "MYSQL error! ' . mysqli_error($conn) . '"}');
        }
    } else {
        die('{"success": "false", "error": "The GET method \'method\' is invalid!"}');
    }