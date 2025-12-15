<?php 

include "db.php";
include "navbar.php";

$succes = "";
$error = "";

if(!isset ($_SESSION['kullanici'])){
    header("location: login.php");
    exit;
}
$search = '';
if (isset($_GET['search']))
{
$search = trim($_GET['search']);
$stmt = $pdo -> prepare("SELECT * FROM kutuphane.kitaplar WHERE isim LIKE ? OR yazar LIKE ?  OR tur LIKE ?  OR basim_yili LIKE ?  ORDER BY kitap_id DESC ");
$stmt -> execute([ "%$search%","%$search%","%$search%","%$search%"]);
$kitaplar = $stmt -> fetchAll();
}
else{
$stmt = $pdo -> query("SELECT * FROM kutuphane.kitaplar order by kitap_id desc");
$kitaplar = $stmt -> fetchAll();
}

if (isset($_POST["add"])){
    $isim = $_POST["isim"];
    $yazar = $_POST["yazar"];
    $yayin_evi = $_POST["yayin_evi"];
    $basim_yili = $_POST["basim_yili"];
    $tur = $_POST["tur"];

    $stmt = $pdo -> prepare("SELECT * FROM kutuphane.kitaplar r WHERE isim = ? AND yazar = ? ");
    $stmt -> execute([$isim,$yazar]);

    if ($stmt -> rowCount()>0) {
        $error = "<p class = 'text-dark'>This Book or Author is taken</p>";
    }
    else {
        $stmt = $pdo -> prepare("INSERT INTO kutuphane.kitaplar (isim,yazar,tur,basim_yili,yayin_evi) VALUES(?,?,?,?,?)");

        if ($stmt -> execute([$isim,$yazar,$tur,$basim_yili,$yayin_evi])){
            $succes = "$isim has been succesfully added";
        }else{
            $error = "$isim has failed while adding";
        }
    }
}

$user = $_SESSION['kullanici'];

if (isset($_GET['delete'])){
    $kitap_id = $_GET['delete'];
    $stmt = $pdo -> prepare("DELETE FROM kutuphane.kitaplar WHERE kitap_id=?");
    $stmt -> execute([$kitap_id]);
    if ($stmt -> execute([$kitap_id])){
        $succes = "Book succesfully deleted";
    }
    else{
        $error = "Book Failed to delete";
    }
}

if (isset($_POST['update'])){
    $kitap_id = $_POST["kitap_id"];
    $isim = $_POST["isim"];
    $yazar = $_POST["yazar"];
    $yayin_evi = $_POST["yayin_evi"];
    $basim_yili = $_POST["basim_yili"];
    $tur = $_POST["tur"];
    
    $stmt = $pdo -> prepare("UPDATE kutuphane.kitaplar SET isim=?, yazar=?, tur=?, basim_yili=?, yayin_evi=?  WHERE kitap_id=?");
    if ($stmt -> execute([$isim,$yazar,$tur,$basim_yili,$yayin_evi,$kitap_id])){
        $succes = "Book succesfully update";
        header("Location:yonetim.php");
    }
    else{
        $error = "Book Failed to update";
    }
}

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
    
    <div class="container py-5">
        <h2 class="text-black mb-4">📚 Admin Panel</h2>

        <?php if($error): ?> <!-- short if statement | if you didnt know https://davidwalsh.name/php-ternary-examples -->
            <div class="alert alert-damger"> <?= $error ?> </div>
        <?php endif ?>
            
        <?php if($succes): ?>
            <div class="alert alert-success"> <?= $succes ?> </div>
        <?php endif ?>
        <div class="mb-3">
            <button aria-expanded="false" aria-controls="addbookform" class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#addbookform">Add Book</button>
        </div>
        <div class="collapse mb-4" id="addbookform">
            <div class="card p-3">
                <form action="" method="POST">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="text-black">Book name:</label>
                            <input class="form-control" name="isim" type="text" placeholder="Enter Book name">
                        </div>
                        <div class="col">
                            <label for="" class="text-black">Author name:</label>
                            <input class="form-control" name="yazar" type="text" placeholder="Enter Author name">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="text-black">Type:</label>
                            <input class="form-control" name="tur" type="text" placeholder="Enter Type">
                        </div>
                        <div class="col">
                            <label for="" class="text-black">Publishing House:</label>
                            <input class="form-control" name="yayin_evi" type="text" placeholder="Enter Publishing House">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="text-black">Published Date:</label>
                            <input class="form-control" name="basim_yili" type="number" placeholder="Ex. 1800-2025" min="1800" max="<?= date('Y') ?>">
                        </div>
                    </div>
                        <div class="mb-3">
                            <button class="btn btn-success w-100" type="submit" name = "add">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" class = " d-flex">
                        <input class="form-control me-2" type="text" name="search" placeholder="Search Books and Authors">
                        <button class="btn btn-primary" >Search</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white fw-bold">Book list</div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hocer">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Book Names</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Published House</th>
                            <th>Realeased Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kitaplar as $kitap): ?>
                            <tr>
                                <td><?= $kitap['kitap_id'] ?></td>
                                <td><?= $kitap['isim'] ?></td>
                                <td><?= $kitap['yazar'] ?></td>
                                <td><?= $kitap['tur'] ?></td>
                                <td><?= $kitap['yayin_evi'] ?></td>
                                <td><?= $kitap['basim_yili'] ?></td>
                                <td>
                                    <div class="d-flex">
                                        <button onclick="return confirm('Are you sure you want to delete this')" class="btn btn-danger w-100" type="submit"><a  href="?delete=<?=$kitap['kitap_id']?>" class="nav-link">Delete</a></button>
                                        <button class="btn btn-primary w-100" data-bs-target="#editModal<?= $kitap['kitap_id']?>" data-bs-toggle="modal">Update</button>
                                        <div class="modal" id="editModal<?= $kitap['kitap_id']?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="" method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal_title">Update Book</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="kitap_id" value="<?= $kitap['kitap_id'] ?>" required>
                                                            <input class="mb-2" type="text" class="form-control" name="isim" value="<?= $kitap['isim'] ?>" required>
                                                            <input class="mb-2" type="text" class="form-control" name="yazar" value="<?= $kitap['yazar'] ?>" required>
                                                            <input class="mb-2" type="text" class="form-control" name="tur" value="<?= $kitap['tur'] ?>" required>
                                                            <input class="mb-2" type="text" class="form-control" name="yayin_evi" value="<?= $kitap['yayin_evi'] ?>" required>
                                                            <input class="mb-2" type="number" class="form-control" name="basim_yili" value="<?= $kitap['basim_yili'] ?>" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary w-100" type="submit" name="update">Update</button>
                                                            <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- bootstrap modal data-bs-toggle="modal_<$kitap['kitap_id']?>" data-bs-target="#modal_$kitap['kitap_id']?>"
                                    <div class="modal fade" id="modal_$kitap['kitap_id']?>" tabindex="-1" aria-labelledby="modalLabel_$kitap['kitap_id']?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel_$kitap['kitap_id']?>">Delete Book</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this Book?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary button_shadow" data-bs-dismiss="modal">No</button>
                                                    <a href="" class="btn btn-danger button_shadow" role="button">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>