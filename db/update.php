<?php 
header('Content-Type: application/json');
session_start();
require_once "connect.php";

$title = isset($_POST['title'])?$_POST['title']:false;
$descr = isset($_POST['descr'])?$_POST['descr']:false;
$update_time = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user'];

$id_task = isset($_POST['id_task'])?$_POST['id_task']:false;

if($title and $descr){
    $sql = mysqli_query($con, "UPDATE `tasks` SET `title`='$title',`description`='$descr',`updated_at`='$update_time' WHERE id_tasks = $id_task and id_user = $id_user");
    $query = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_tasks = $id_task")); // Fetch a single row

    
        $response=[
            'id_task'=> $query['id_tasks'],
            'title'=> $query['title'],
            'description'=> $query['description'],
            'is_complited'=> $query['is_complited'],
            'created_at'=> $query['created_at'],
            'updated_at'=> $query['updated_at'],
            'status' => 'ok'
        ];

}
else {
    $response = [
        'status' => 'false',
        'title'=> $title,
        'descr'=> $descr,
        'id_task'=> $id_task
    ];
}
$json = json_encode($response);
echo $json;

// if($title){
//     $sql = mysqli_query($con, "UPDATE `tasks` SET `title`='$title',`updated_at`='$update_time' WHERE id_tasks = $id_task");
//     $query = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_tasks = $id_task")); // Fetch a single row
    
    
//     if($sql){
//         $response=[
//             'id_task'=> $query['id_tasks'],
//             'title'=> $query['title'],
//             'description'=> $query['description'],
//             'is_complited'=> $query['is_complited'],
//             'created_at'=> $query['created_at'],
//             'updated_at'=> $query['updated_at'],
//             'status' => 'ok'
//         ];
//     }else {
//         $response = [
//             'status' => 'false',
//             'error' => mysqli_error($con) // Include error message
//         ];
//     }
//     $json = json_encode($response);
//     echo $json;
// }

// if($descr){
//     $sql=mysqli_query($con, "UPDATE `tasks` SET `description`='$descr',`updated_at`='$update_time' WHERE id_tasks = $id_task");
//     $query = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_tasks = $id_task")); // Fetch a single row
   
   
//     if($sql){
//         $response=[
//             'id_task'=> $query['id_tasks'],
//             'title'=> $query['title'],
//             'description'=> $query['description'],
//             'is_complited'=> $query['is_complited'],
//             'created_at'=> $query['created_at'],
//             'updated_at'=> $query['updated_at'],
//             'status' => 'ok'
//         ];
//     }else {
//         $response = [
//             'status' => 'false',
//             'error' => mysqli_error($con) // Include error message
//         ];
//     }
//     $json = json_encode($response);
//     echo $json;
// }

?>