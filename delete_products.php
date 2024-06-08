<?php
include 'config/db.php';
include 'admin_auth.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header('Location: manage_products.php');
exit();
?>
