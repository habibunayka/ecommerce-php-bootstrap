<?php 
include 'partials/header.php'; 
include 'config/db.php'; 
include 'auth.php';
?>

<div class="container mt-5">
    <h1>Order History</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$_SESSION['user_id']]);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($orders) {
                foreach ($orders as $order) {
                    $no = 1;
                    echo '
                    <tr>
                        <td>'.$no.'</td>
                        <td>'.$order['id'].'</td>
                        <td>Rp. '.$order['total_amount'].'</td>
                        <td>'.$order['status'].'</td>
                        <td>'.$order['created_at'].'</td>
                        <td><a href="order_details.php?id='.$order['id'].'" class="btn btn-primary">View Details</a></td>
                    </tr>
                    ';
                    $no++;
                }
            } else {
                echo '<tr><td colspan="5">You have no orders.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer.php'; ?>
