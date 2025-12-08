<?php 

include "db.php";
session_start();
if(!isset ($_SESSION['kullanici'])){
    header("location: login.php");
    exit;
}
$user = $_SESSION['kullanici'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="css/style2.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">📚 Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"> 
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="kitaplar.php" target="_blank">Books</a></li>
                    <?php if ($user['rol'] == 'yonetici'){ ?>
                        <li class="nav-item"><a class="nav-link" href="yonetim.php" target="_blank">Admin panel</a></li> 
                    <?php } ?>
                </ul>
                <span class="navbar-text me-3"><?= $user['isim'] ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5" >
        <div class="alert alert-light text-dark py-3 shadow">
            Welcome <b> <?= $user['isim'] ?></b>!
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim, numquam. Corporis odio ut provident corrupti delectus ratione! Minima voluptatem numquam rem ipsum nam corporis incidunt praesentium, doloremque sapiente molestiae esse.</p>
        </div>
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card p-3 feature-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Search Books</h5>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis sint, expedita dolore fuga ad quis voluptates! Architecto consequuntur, nihil voluptatem perferendis id mollitia optio voluptate, tempora commodi ducimus, cumque quasi.</p>
                        <a href="kitaplar.php" target="_blank" class="btn btn-primary-custom feature-card shadow">Search</a>
                    </div>
                </div>
            </div>
        
        

            <div class="col-md-4">
                <div class="card p-3 feature-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Book List</h5>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis sint, expedita dolore fuga ad quis voluptates! Architecto consequuntur, nihil voluptatem perferendis id mollitia optio voluptate, tempora commodi ducimus, cumque quasi.</p>
                        <a href="kitaplar.php" target="_blank" class="btn btn-primary-custom feature-card shadow">List</a>
                    </div>
                </div>
            </div>
            <?php if ($user['rol'] == 'yonetici'){ ?>
            <div class="col-md-4">
                <div class="card p-3 feature-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Admin Panel</h5>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis sint, expedita dolore fuga ad quis voluptates! Architecto consequuntur, nihil voluptatem perferendis id mollitia optio voluptate, tempora commodi ducimus, cumque quasi.</p>
                        <a href="yonetim.php" target="_blank" class="btn btn-primary-custom feature-card shadow">Administrate</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="mt-5">
            <h4 class="mb-5 text-dark" >New added books</h4>
            <div class="row g-4 mt-4">

                <?php
                    $stmt = $pdo -> query("SELECT * FROM kutuphane.kitaplar order by kitap_id desc limit 6");
                    $kitaplar = $stmt -> fetchAll();
                    foreach($kitaplar as $i){
                ?>

                <div class="col-md-4">
                    <div class="card p-2 feature-card">
                        <div class="card-body">
                            <h5 class="card-title">Title: <?= htmlspecialchars($i['isim']) ?></h5>
                            <h5 class="card-title">ID: <?= $i['kitap_id'] ?></h5>
                            <h5 class="card-title">Yazar: <?= htmlspecialchars($i['yazar']) ?></h5>
                            <h5 class="card-title">Yayin Evi: <?= htmlspecialchars($i['yayin_evi']) ?></h5>
                            <h5 class="card-title">Basim Yil: <?= htmlspecialchars($i['basim_yili']) ?></h5>
                            <h6>Desc:</h6>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis sint, expedita dolore fuga ad quis voluptates! Architecto consequuntur, nihil voluptatem perferendis id mollitia optio voluptate, tempora commodi ducimus, cumque quasi.</p>
                            <a href="kitaplar.php" target="_blank" class="btn btn-primary-custom feature-card shadow">Administrate</a>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>