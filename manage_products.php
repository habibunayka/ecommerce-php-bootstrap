<?php include 'partials/header.php'; ?>
<?php include 'config/db.php'; ?>
<?php include 'admin_auth.php'; ?>

<div class="container mt-5">
    <h1>Manage Products</h1>
    <a href="add_product.php" class="btn btn-success mb-3">Add New Product</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM products");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['price'].'</td>
                    <td><img src="assets/images/'.$row['image'].'" width="50"></td>
                    <td>
                        <a href="edit_product.php?id='.$row['id'].'" class="btn btn-warning">Edit</a>
                        <a href="delete_product.php?id='.$row['id'].'" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                ';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer.php'; ?>
