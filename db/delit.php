<?php 
header('Content-Type: application/json');
require_once "connect.php";

// $id_task = isset($_GET['id_task'])?$_GET['id_task']:false;
// var_dump($id_task);
// $sql = mysqli_query($con, "DELETE FROM `tasks` WHERE id_tasks = $id_task");

// if($sql){
//     $response = [
//         'id_task' => $id_task,
//         'status' => 'успех'
//     ];
    
   
// }else{
//     $response = [
//         'id_task' => $id_task,
//         'status' => 'ошибка'
//     ];
// }

// // $json = json_encode($response);
// $json = json_encode($response);
// echo $json;


$id_task = isset($_GET['id_task']) ?($_GET['id_task']) : false;

if ($id_task) {
    $sql = mysqli_query($con, "DELETE FROM `tasks` WHERE id_tasks = $id_task");
    if (mysqli_affected_rows($con) > 0) {
        $response = [
            'id_task' => $id_task,
            'status' => 'ok'
        ];
    } else {
        $response = [
            'id_task' => $id_task,
            'status' => 'error'
        ];
    }
} else {
    $response = [
        'id_task' => null,
        'status' => 'error'
    ];
}

$json = json_encode($response);
echo $json;
?>