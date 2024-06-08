<?php include 'partials/header.php'; ?>
<?php include 'config/db.php';?>
<?php include 'auth.php';?>

<section class="banner mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12 banner-container">
                <img src="assets/images/Banner.webp" class="banner-image" alt="Banner Image">
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM products");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <div class="col-md-4">
                <div class="card mb-4">
                    <img class="card-img-top" src="assets/images/'.$row['image'].'" alt="'.$row['name'].'" >
                    <div class="card-body">
                        <h5 class="card-title">'.$row['name'].'</h5>
                        <p class="card-text">'.$row['description'].'</p>
                        <p class="card-text">Rp. '.$row['price'].'</p>
                        <a href="product.php?id='.$row['id'].'" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

<?php include 'partials/footer.php'; ?>

<style>
    .banner {
    text-align: center;
}

.banner-container {
    display: flex;
    justify-content: center; 
    overflow: hidden; 
}

.banner-image {
    max-width: 100%; 
    max-height: 300px; 
    margin: auto; 
}
</style>