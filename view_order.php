<?php include 'partials/header.php'; ?>
<?php include 'config/db.php'; ?>
<?php include 'admin_auth.php'; ?>

<div class="container mt-5">
    <h1>Order Details</h1>
    <?php
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT orders.*, products.name AS product_name FROM orders INNER JOIN order_items ON orders.id = order_items.order_id INNER JOIN products ON order_items.product_id = products.id WHERE orders.id = ?");
    $stmt->execute([$id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        echo '
        <p><strong>Order ID:</strong> '.$order['id'].'</p>
        <p><strong>User ID:</strong> '.$order['user_id'].'</p>
        <p><strong>Total Amount:</strong> '.$order['total_amount'].'</p>
        <p><strong>Status:</strong> '.$order['status'].'</p>
        <p><strong>Product Name:</strong> '.$order['product_name'].'</p>
        <h2>Order Items</h2>
        <ul>
        ';

        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$id]);
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <li>
                <p><strong>Product ID:</strong> '.$item['product_id'].'</p>
                <p><strong>Quantity:</strong> '.$item['quantity'].'</p>
                <p><strong>Price:</strong> '.$item['price'].'</p>
            </li>
            ';
        }

        echo '
        </ul>
        <form action="update_order_status.php" method="POST">
            <input type="hidden" name="order_id" value="'.$order['id'].'">
            <label for="status">Change Status:</label>
            <select class="custom-select custom-select-md" name="status" id="status">
                <option value="pending" '.($order['status'] == "pending" ? "selected" : "").'>Pending</option>
                <option value="processing" '.($order['status'] == "processing" ? "selected" : "").'>Processing</option>
                <option value="completed" '.($order['status'] == "completed" ? "selected" : "").'>Completed</option>
                <option value="cancelled" '.($order['status'] == "cancelled" ? "selected" : "").'>Canceled</option>
            </select>
            <button class="btn btn-info" type="submit">Update Status</button>
        </form>
        ';
    } else {
        echo '<p>Order not found.</p>';
    }
    ?>
    <a href="manage_orders.php" class="btn btn-primary">Back to Orders</a>
</div>

<?php include 'partials/footer.php'; ?>
