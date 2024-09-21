<?php
header('Content-Type: application/json');
session_start();
require_once "connect.php";
$id_user = $_SESSION['id_user'];

// $tasks = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_user = $id_user"));
$tasks = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM tasks WHERE id_user = $id_user"), MYSQLI_ASSOC);
$response = [
    
    'data' => $tasks
];

$json = json_encode($response);
echo $json;

?>
