<?php 

include "db.php";

session_start();

if(!isset ($_SESSION['kullanici']) || $_SESSION['kullanici']['rol'] !== 'yonetici' ){
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

</body>
</html>