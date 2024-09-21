<?php
header('Content-Type: application/json');
require_once "connect.php";

$title = isset($_POST['title']) ? $_POST['title'] : false;
$descr = isset($_POST['descr']) ? $_POST['descr'] : false;
$id_user = isset($_POST['id_user']) ?intval($_POST['id_user']) : false;


if ($title and $descr) {
    $sql = mysqli_query($con, "INSERT INTO `tasks`(`id_user`, `title`, `description`, `is_complited`) VALUES ($id_user,'$title','$descr',0)");
    
    if ($sql) {
        $id_task = mysqli_insert_id($con); // Get the last inserted ID
        $query = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_tasks = $id_task")); // Fetch a single row
    
        $response = [
            'id_task'=> $query['id_tasks'],
            'title'=> $query['title'],
            'description'=> $query['description'],
            'is_complited'=> $query['is_complited'],
            'created_at'=> $query['created_at'],
            'updated_at'=> $query['updated_at'],
            'status' => 'ok'
        ];
    } else {
        $response = [
            'status' => 'false',
            'error' => mysqli_error($con) // Include error message
        ];
    }
    $json = json_encode($response);
    echo $json;

}else {
    $response = [
        'status' => 'false'
    ];
    $json = json_encode($response);
    echo $json;
}
?>