<?php
include_once "../config/database.php";
include_once "../objects/order.php";
include_once "../objects/types.php";

$database = new Database();
$db = $database->get_connection();
$order = new Order($db);

$res = $order->confirm($_POST['id']);

if ($res > 0) {
    echo 'true';
} else {
    echo 'false';
}
