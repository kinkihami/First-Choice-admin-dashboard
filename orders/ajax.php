<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}


if ($action == "getorderfields") {
    
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($id)) {
        $order = $obj->getRow('id', $id);
        echo json_encode($order);
        exit();
    }
}


if ($action == "getorder") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $order = $obj->getRows($start, $limit);
    if (!empty($order)) {
        $orderlist = $order;
    } else {
        $orderlist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'order' => $orderlist];
    echo json_encode($playerArr);
    exit();
}

?>