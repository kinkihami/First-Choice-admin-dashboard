<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}

$logFile = 'logfile.txt';

// Data to log
$logData = date('Y-m-d H:i:s') . " - User accessed the website.\n";

// Check if the log file exists, if not, create it
if (!file_exists($logFile)) {
    // Create the log file
    $fileHandle = fopen($logFile, 'w') or die("Unable to create log file!");
    fclose($fileHandle);
}


file_put_contents($logFile, $action, FILE_APPEND | LOCK_EX);

file_put_contents($logFile, "   ", FILE_APPEND | LOCK_EX);

if ($action == "deletedisableitem") {
    $playerId = (!empty($_POST['id'])) ? $_POST['id'] : '';
    if (!empty($playerId)) {
        $isDeleted = $obj->deleteRow($playerId);
        if ($isDeleted) {
            $message = ['deleted' => 1];
        } else {
            $message = ['deleted' => 0];
        }
        echo json_encode($message);
        exit();
    }
}

if ($action == "enabledisableitem") {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    if (!empty($id)) {
        $obj->update($id);
        $response = [
            'success' => true,
            'message' => "size updated successfully!",
        ];
        echo json_encode($response);
        exit();
    }
}

if ($action == "getdisableitem") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $disableitem = $obj->getRows($start, $limit);
    if (!empty($disableitem)) {
        $disableitemlist = $disableitem;
    } else {
        $disableitemlist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'disableitem' => $disableitemlist];
    echo json_encode($playerArr);
    exit();
}

if ($action == 'search') {


    $queryString = (!empty($_GET['searchQuery'])) ? trim($_GET['searchQuery']) : '';

    file_put_contents($logFile, $queryString, FILE_APPEND | LOCK_EX);
    file_put_contents($logFile, '\n', FILE_APPEND | LOCK_EX);


    $search = $obj->searchPlayer($queryString);
    if (!empty($search)) {
        $searchitemlist = $search;
    } else {
        $searchitemlist = [];
    }

    $playerArr = ['searchlist' => $searchitemlist];
    echo json_encode($playerArr);
    exit();
}

?>