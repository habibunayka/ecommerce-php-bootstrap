<?php

include 'partials/header.php';
include 'config/db.php';
include 'auth.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if ($order_id) {
    $stmt_order = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt_order->execute([$order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    if ($order && $order['user_id'] != $_SESSION['user_id']) {
        header('Location: unauthorized.php');
        exit();
    }
} else {
    header('Location: unauthorized.php');
    exit();
}
?>

<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Thank You!</h4>
        <p>Your order has been successfully placed.</p>
        <hr>
        <p class="mb-0">Order ID: <?php echo $order['id']; ?></p>
        <p class="mb-0">Total Amount: <?php echo $order['total_amount']; ?></p>
    </div>
    <p><a href="index.php" class="btn btn-primary">Continue Shopping</a></p>
</div>

<?php include 'partials/footer.php'; ?>
