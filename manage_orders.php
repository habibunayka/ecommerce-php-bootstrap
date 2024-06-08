<?php
include 'partials/header.php';
include 'config/db.php';
include 'admin_auth.php';

if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $stmt_delete_order = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt_delete_order->execute([$order_id]);

    $stmt_delete_order_items = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt_delete_order_items->execute([$order_id]);

    header('Location: manage_orders.php');
    exit();
}

?>

<div class="container mt-5">
    <h1>Manage Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM orders");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['total_amount']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>
                        <a href='view_order.php?id={$row['id']}' class='btn btn-primary'>View</a>
                        <form method='POST' style='display: inline;'>
                            <input type='hidden' name='order_id' value='{$row['id']}'>
                            <button type='submit' name='delete_order' class='btn btn-danger'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer.php'; ?>
