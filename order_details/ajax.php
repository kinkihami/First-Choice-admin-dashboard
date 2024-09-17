<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}


if ($action == "getdetailsfields") {
    
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    if (!empty($id)) {
        $details = $obj->getRow('id', $id);
        echo json_encode($details);
        exit();
    }
}

if ($action == "updatestatus") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    if (!empty($id)) {
        $obj->update($id, $status);
        $response = [
            'success' => true,
            'message' => "Status updated successfully!",
        ];
        echo json_encode($response);
        exit();
    } else {
        $response = [
            'success' => false,
            'message' => "ID is empty.",
        ];
        echo json_encode($response);
        exit();
    }
}


if ($action == "getdetails") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $order_id = $_GET['order_id'];
    $limit = 15;
    $start = 0;

    $details = $obj->getRows($start, $limit, $order_id);
    if (!empty($details)) {
        $detailslist = $details;
    } else {
        $detailslist = [];
    }
    $playerArr = ['details' => $detailslist];
    echo json_encode($playerArr);
    exit();
}

// if ($action == "getproductdetails") {
//     // Append data to the log file
//     // file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
//     $order_id = $_GET['order_id'];
//     $limit = 15;
//     $start = 0;

//     $details = $obj->getRows($start, $limit, $order_id);
//     if (!empty($details)) {
//         $detailslist = $details;
//     } else {
//         $detailslist = [];
//     }
//     $total = $obj->getCount($order_id);
//     $playerArr = ['count' => $total,'details' => $detailslist];
//     echo json_encode($playerArr);
//     exit();
// }

?>