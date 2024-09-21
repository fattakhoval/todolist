<?php
header('Content-Type: application/json');
require_once "connect.php";

$id_task = isset($_POST['id_task']) ? $_POST['id_task'] : false;
$update_time = date("Y-m-d H:i:s");

$sql = mysqli_query($con, "UPDATE `tasks` SET `is_complited` = 1,`updated_at`='$update_time' WHERE id_tasks = $id_task");


if($sql){
    $response = [
        'id_task'=> $id_task,
        'is_complited'=> 1,
        'status' => 'ok'
    ];
}else {
    $response = [
        'status' => 'error'
    ];
}
echo json_encode($response);

?>