<?php 
include 'partials/header.php'; 
include 'config/db.php'; 

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$order_id = $_GET['id'];
?>

<div class="container mt-5">
    <h1>Order Details</h1>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        echo '
        <p><strong>Order ID:</strong> '.$order['id'].'</p>
        <p><strong>Total Price:</strong> $'.$order['total_amount'].'</p>
        <p><strong>Status:</strong> '.$order['status'].'</p>
        <p><strong>Order Date:</strong> '.$order['created_at'].'</p>
        <h2>Order Items</h2>
        <ul>
        ';

        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt_product = $pdo->prepare("SELECT name FROM products WHERE id = ?");
            $stmt_product->execute([$item['product_id']]);
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

            echo '
            <li>
                <p><strong>Product:</strong> '.$product['name'].'</p>
                <p><strong>Quantity:</strong> '.$item['quantity'].'</p>
                <p><strong>Price:</strong> Rp. '.$item['price'].'</p>
            </li>
            ';
        }

        echo '
        </ul>
        ';
    } else {
        echo '<p>Order not found.</p>';
    }
    ?>
    <a href="order_history.php" class="btn btn-primary">Back to Order History</a>
</div>

<?php include 'partials/footer.php'; ?>
