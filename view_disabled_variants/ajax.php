<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}

if ($action == "deletedisablevariant") {
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

if ($action == "enabledisablevariant") {
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


if ($action == "getdisablevariants") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $disablevariants = $obj->getRows($start, $limit);
    if (!empty($disablevariants)) {
        $disablevariantslist = $disablevariants;
    } else {
        $disablevariantslist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'disablevariants' => $disablevariantslist];
    echo json_encode($playerArr);
    exit();
}

if ($action == 'search') {


    $queryString = (!empty($_GET['searchQuery'])) ? trim($_GET['searchQuery']) : '';


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