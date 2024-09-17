<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}


if ($action == "addarea" && !empty($_POST)) {

   
    
    // Append data to the log file

    $id = $_POST['id'];
    $name = $_POST['name'];
    $day = $_POST['day'];
    $message = $_POST['message'];

    
    $areaData = [
            'name' => $name,
            'notificationday' => $day,
            'notificationmessage' => $message,
        ];

    if ($id==null) {
        
        $id = $obj->addarea($areaData);
        if ($id) {
            $response = [
                'success' => true,
                'message' => "area added successfully!",
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Error adding area!"
            ];
        }
        

    }
    
    else {
        $obj->update($areaData, $id);
        $response = [
            'success' => true,
            'message' => "area updated successfully!",
        ];
    }

    echo json_encode($response);
    exit();

}

if ($action == "deletearea") {
    $id = (!empty($_POST['id'])) ? $_POST['id'] : '';
    if (!empty($id)) {
        $isDeleted = $obj->deleteRow($id);
        if ($isDeleted) {
            $message = ['deleted' => 1];
        } else {
            $message = ['deleted' => 0];
        }
        echo json_encode($message);
        exit();
    }
}


if ($action == "getareafields") {
    
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($id)) {
        $area = $obj->getRow('id', $id);
        echo json_encode($area);
        exit();
    }
}


if ($action == "getarea") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $area = $obj->getRows($start, $limit);
    if (!empty($area)) {
        $arealist = $area;
    } else {
        $arealist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'area' => $arealist];
    echo json_encode($playerArr);
    exit();
}

?>