<?php
include 'partials/header.php';
include 'config/db.php';
include 'auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_price = 0;
    $user_id = $_SESSION['user_id'];
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_price += $product['price'] * $quantity;
    }

    $stmt_order = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt_order->execute([$user_id, $total_price]);

    $order_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt_product = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt_product->execute([$product_id]);
        $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        $total = $product['price'] * $quantity;

        $stmt_order_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt_order_item->execute([$order_id, $product_id, $quantity, $total]);
    }

    unset($_SESSION['cart']);
    $message = "Thank you for your order!";
}

?>

<div class="container mt-5">
    <h1>Checkout</h1>
    <?php if (isset($message)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <h3>Order Summary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                            $stmt->execute([$product_id]);
                            $product = $stmt->fetch(PDO::FETCH_ASSOC);
                            $total = $product['price'] * $quantity;
                            $total_price += $total;
                    ?>
                            <tr>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td>Rp. <?php echo $product['price']; ?></td>
                                <td>Rp. <?php echo $total; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <h4>Total Price: Rp. <?php echo $total_price; ?></h4>
        </div>
        <div class="col-md-6">
            <h3>Confirmation your order</h3>
            <form action="checkout.php" method="post">
                <button type="submit" class="btn btn-primary">Complete Purchase</button>
            </form>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
