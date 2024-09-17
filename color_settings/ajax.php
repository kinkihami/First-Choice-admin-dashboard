<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}


if ($action == "addcolor" && !empty($_POST)) {

   
    
    // Append data to the log file

    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];

    
    $colorData = [
            'name' => $name,
            'colorcode' => $code,
        ];

    if ($id==null) {
        
        $id = $obj->addcolor($colorData);
        if ($id) {
            $response = [
                'success' => true,
                'message' => "Color added successfully!",
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Error adding color!"
            ];
        }
        

    }
    
    else {
        $obj->update($colorData, $id);
        $response = [
            'success' => true,
            'message' => "Color updated successfully!",
        ];
    }

    echo json_encode($response);
    exit();

}

if ($action == "deletecolor") {
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


if ($action == "getcolorfields") {
    
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($id)) {
        $color = $obj->getRow('id', $id);
        echo json_encode($color);
        exit();
    }
}


if ($action == "getcolor") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 15;
    $start = ($page - 1) * $limit;

    $color = $obj->getRows($start, $limit);
    if (!empty($color)) {
        $colorlist = $color;
    } else {
        $colorlist = [];
    }
    $total = $obj->getCount();
    $playerArr = ['count' => $total,'color' => $colorlist];
    echo json_encode($playerArr);
    exit();
}

?>