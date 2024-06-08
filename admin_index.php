<?php 
include 'partials/header.php'; 
include 'admin_auth.php'; 
include 'config/db.php'; 
?>

<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <a href="manage_products.php" class="btn btn-primary">Manage Products</a>
    <a href="manage_orders.php" class="btn btn-primary">Manage Orders</a>
</div>

<?php 
include 'partials/footer.php'; 
?>
