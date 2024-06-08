<?php
include 'config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);

    header("Location: view_order.php?id=$order_id");
    exit();
} else {
    header("Location: error.php");
    exit();
}
?>
