<?php 
include 'partials/header.php'; 
include 'config/db.php'; 
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $quantity = intval($quantity);
        if ($quantity <= 0) {
            $quantity = 1;
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        header('Location: cart.php');
        exit();
    }
}
?>

<div class="container mt-5">
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);

                    $total_price = $product['price'] * $quantity;
                    ?>

                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td>
                            <form action="update_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $quantity; ?>" class="form-control mb-2" min="1" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>Rp. <?php echo $product['price']; ?></td>
                        <td>Rp. <?php echo $total_price; ?></td>
                        <td>
                            <form action="remove_from_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button class="btn btn-danger" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                
                echo '<tr><td colspan="5">';
                echo '<a href="checkout.php" class="btn btn-primary">Checkout</a>';
                echo '</td></tr>';
            } else {
                echo '<tr><td colspan="5">Your cart is empty</td></tr>';
            }
            ?>
        </tbody>
    </table>
    <div>
        <?php
        $total_price = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_price += $product['price'] * $quantity;
            }
        }
        echo "Total Price: Rp. " . $total_price;
        ?>
    </div>

</div>

<?php include 'partials/footer.php'; ?>
