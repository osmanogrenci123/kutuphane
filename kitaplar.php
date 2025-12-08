<?php 

include "db.php";
include "navbar.php";

if(!isset ($_SESSION['kullanici'])){
    header("location: login.php");
    exit;
}
$user = $_SESSION['kullanici'];

$where = "";
$params = [];

if (!empty($_GET['arama'])){
    $q = "%".$_GET['arama']."%";
    $where = "WHERE k.isim LIKE ? OR k.yazar LIKE ? OR k.tur LIKE ?";
    $params = [$q,$q,$q];
}

$sql = "SELECT k.kitap_id, k.isim,k.yazar, k.tur, k.yayin_evi, k.basim_yili
        FROM kutuphane.kitaplar k
        $where
        ORDER BY k.isim ASC";

$stmt = $pdo->prepare($sql);
$stmt -> execute($params);
$kitaplar = $stmt -> fetchAll();

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

    <div class = "container mt-5">

        <h2 class = "text-dark mb-4" >📚 Kitaplar</h2>
        <form action="get" class="input-group mb-4 search-bar">
            <input type="text" name="arama" class="form-control" placeholder="Kitap, yazar veya tur ara" 
            value="<?= isset($_GET['arama']) ? htmlspecialchars($_GET['arama']) : '' ?>">
            <button class="btn bg-white" type="submit">Ara</button>
        </form>

        <div class="row g-4">
            <?php if ($kitaplar){ ?>
                <?php foreach($kitaplar as $k) { ?>
                    <div class = "col-md-4">
                        <div class = "card p-3 bg-light">
                            <div class = "card-body">
                                <h5 class = "card-title"><?= htmlspecialchars($k['isim']) ?></h5>
                                <p class = "card-text mb-1"><b>Yazar:</b><?= htmlspecialchars($k['yazar']) ?></p>
                                <p class = "card-text mb-1"><b>Tur:</b><?= htmlspecialchars($k['tur']) ?></p>
                                <p class = "card-text mb-1"><b>yazimevi:</b><?= htmlspecialchars($k['yayin_evi']) ?></p>
                                <p class = "card-text mb-1"><b>basimyilli:</b><?= htmlspecialchars($k['basim_yili']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }
                    else{ ?>
                <div class = "col-32">
                    <div class = "alert alert-dark text-center">
                        Aradiniz kriteleerlelele bulunamadi
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
</body>
</html>