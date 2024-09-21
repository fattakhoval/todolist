<?php 

header('Content-Type: application/json');
session_start();
require_once "connect.php";

$id_user = $_SESSION['id_user'];
$query = $_GET['q'];

// Разбиваем запрос на слова
$words = explode(' ', $query);
$likeClauses = [];

foreach ($words as $word) {
    $likeClauses[] = "`description` LIKE '%". mysqli_real_escape_string($con, $word) . "%'";
}

// Объединяем условия LIKE с помощью оператора AND
$likeQuery = implode(' AND ', $likeClauses);

// Выполняем запрос
$tasks = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM `tasks` WHERE id_user = $id_user AND ($likeQuery)"), MYSQLI_ASSOC);

$response = [
    'data' => $tasks
];

$json = json_encode($response);
echo $json;



?>