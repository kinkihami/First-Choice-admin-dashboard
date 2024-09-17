<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}


if ($action == "addsize" && !empty($_POST)) {

   
    
    // Append data to the log file

    $id = $_POST['id'];
    $size = $_POST['size'];

    
    $sizeData = [
            'size' => $size,
        ];

    if ($id==null) {
        
        $id = $obj->addsize($sizeData);
        if ($id) {
            $response = [
                'success' => true,
                'message' => "size added successfully!",
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Error adding size!"
            ];
        }
        

    }
    
    else {
        $obj->update($sizeData, $id);
        $response = [
            'success' => true,
            'message' => "size updated successfully!",
        ];
    }

    echo json_encode($response);
    exit();

}

if ($action == "deletesize") {
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


if ($action == "getsizefields") {
    
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($id)) {
        $size = $obj->getRow('id', $id);
        echo json_encode($size);
        exit();
    }
}


if ($action == "getsize") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $size = $obj->getRows($start, $limit);
    if (!empty($size)) {
        $sizelist = $size;
    } else {
        $sizelist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'size' => $sizelist];
    echo json_encode($playerArr);
    exit();
}

?>