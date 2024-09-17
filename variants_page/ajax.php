<?php
$action = $_REQUEST['action'];

if (!empty($action)) {
    require_once 'functions.php';
    $obj = new Functions();
}

if ($action == "addvariant" && !empty($_POST)) {
    try {
        $logFile = 'path_to_your_log_file.log'; // define your log file path
        file_put_contents($logFile, "Haiiii", FILE_APPEND | LOCK_EX);
        $valid_extensions = array('jpg', 'jpeg', 'png'); // valid extensions
        $path = '../itemvariantimages/'; // upload directory

        $playerId = (!empty($_POST['id'])) ? $_POST['id'] : '';
        $item = $_POST['item'];
        $size = $_POST['size'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $isfresharrival = isset($_POST['fresh']) ? $_POST['fresh'] : 0;

        if ($playerId) {
            if (!empty($_FILES["image"]['name'])) {
                $variant = (!empty($_POST['image'])) ? $_POST['image'] : '';

                if (!empty($variant) && file_exists('../itemvariantimages/' . $variant)) {
                    unlink('../itemvariantimages/' . $variant);
                }

                $variantimage = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $ext = strtolower(pathinfo($variantimage, PATHINFO_EXTENSION));
                $final_image = rand(1000, 1000000) . $variantimage;

                if (in_array($ext, $valid_extensions)) {
                    $path = $path . strtolower($final_image);

                    if (move_uploaded_file($tmp, $path)) {
                        $variantData = [
                            'size' => $size,
                            'color' => $color,
                            'price' => $price,
                            'image' => $final_image,
                            'item' => $item,
                            'isfresharrival' => $isfresharrival,
                            'isactive' => 1
                        ];

                        $obj->update($variantData, $playerId);
                        $response = [
                            'success' => true,
                            'message' => "variant updated successfully!",
                        ];
                    }
                }
            } else {
                $variantData = [
                    'size' => $size,
                    'color' => $color,
                    'price' => $price,
                    'item' => $item,
                    'isfresharrival' => $isfresharrival,
                    'isactive' => 1
                ];

                $obj->update($variantData, $playerId);
                $response = [
                    'success' => true,
                    'message' => "variant updated successfully!"
                ];
            }
        } else {
            if (!empty($_FILES["image"]['name'])) {
                $note = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $ext = strtolower(pathinfo($note, PATHINFO_EXTENSION));
                $final_image = rand(1000, 1000000) . $note;

                file_put_contents($logFile, $final_image, FILE_APPEND | LOCK_EX);

                if (in_array($ext, $valid_extensions)) {
                    $path = $path . strtolower($final_image);
                    if (move_uploaded_file($tmp, $path)) {
                        $variantData = [
                            'size' => $size,
                            'color' => $color,
                            'price' => $price,
                            'image' => $final_image,
                            'item' => $item,
                            'isfresharrival' => $isfresharrival,
                            'isactive' => 1
                        ];

                        $playerId = $obj->addvariant($variantData);
                        $data = array('msg' => 'success');
                        echo json_encode($data);
                        exit(); // Make sure to exit after sending the response
                    }
                }
            } else {
                $data = array('msg' => 'Please select file');
                echo json_encode($data);
                exit(); // Make sure to exit after sending the response
            }
        }

        if (!empty($playerId)) {
            $player = $obj->getRow('id', $playerId);
            if ($player) {
                echo json_encode($player);
            } else {
                echo json_encode(['error' => 'Player not found']);
            }
        } else {
            echo json_encode(['error' => 'Player ID is empty']);
        }
        exit();
    } catch (Exception $e) {
        file_put_contents($logFile, $e->getMessage(), FILE_APPEND | LOCK_EX);
        echo json_encode(['error' => 'An error occurred']);
        exit();
    }
}


if ($action == "disablevariant") {
    $id = $_POST['id'];
    if (!empty($id)) {
        $obj->disable($id);
        $response = [
            'success' => true,
            'message' => "Data updated successfully!",
        ];
        echo json_encode($response);
        exit();
    }
}

if ($action == "getvariantfields") {
    
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($id)) {
        $variant = $obj->getRow('id', $id);
        echo json_encode($variant);
        exit();
    }
}


if ($action == "getvariant") {
    // Append data to the log file
    //file_put_contents($logFile, $logData, FILE_APPEND | LOCK_EX);
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $id = (!empty($_GET['id'])) ? $_GET['id'] : '';
    $limit = 15;
    $start = ($page - 1) * $limit;

    $variant = $obj->getRows($start, $limit, $id);
    if (!empty($variant)) {
        $variantlist = $variant;
    } else {
        $variantlist = [];
    }
    $total = $obj->getCount($id);
    $playerArr = ['count' => $total,'variant' => $variantlist];
    echo json_encode($playerArr);
    exit();
}

if ($action == "getselectcolor") {

    $players = $obj->getselectcolors();
    if (!empty($players)) {
        $playerslist = $players;
    } else {
        $playerslist = [];
    }

 
    $total = $obj->getselectcolorsCount();
    $playerArr = ['count' => $total, 'color' => $playerslist];
    echo json_encode($playerArr);
    exit();
}

if ($action == "getselectsize") {

    $players = $obj->getselectsize();
    if (!empty($players)) {
        $playerslist = $players;
    } else {
        $playerslist = [];
    }

 
    $total = $obj->getselectsizeCount();
    $playerArr = ['count' => $total, 'size' => $playerslist];
    echo json_encode($playerArr);
    exit();
}

?>