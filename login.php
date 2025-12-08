<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors',1);
include "db.php";
$tab = isset($_GET["tab"]) ? $_GET["tab"] : "login";
$hata_mesaji = "";
$basarili = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $isim = trim($_POST["isim"]);
    $sifre = trim($_POST["sifre"]);
    $sifre_tekrar = isset ($_POST['sifre_tekrar']) ? trim ($_POST["sifre_tekrar"]) : null ;

    if ($tab == "login"){
        $stmt =  $pdo->prepare ("SELECT * FROM kutuphane.kullanicilar where isim = ?;");
        $stmt -> execute([$isim]);
        $kullanici = $stmt-> fetch();

           if($isim == $kullanici['isim'] && $sifre == $kullanici['sifre']){ 
            $_SESSION['kullanici'] = $kullanici;
            header("location: index.php");
        }
        else{
            $hata_mesaji = "Hatalı kullanıcı adı ve şifre";
        }
    }elseif ($tab == "register") 
        {
            if ($sifre != $sifre_tekrar)
            {
              $hata_mesaji = "Sifreler eşleşmiyor";
            }
            else{
              //Veri tabanında bu kullanıcı var mı kontrolu
              $stmt = $pdo -> prepare("SELECT * FROM kutuphane.kullanicilar where isim = ?");
              $stmt -> execute([$isim]);
              if ($stmt -> fetch())//Kullanıcı verı tabanında varsa
              { 
                $hata_mesaji = "Bu kullanıcı adı zaten alınmış";
              }else
              {
                $stmt = $pdo->prepare("INSERT INTO kutuphane.kullanicilar (isim,sifre) VALUES(?,?)");
                $stmt -> execute([$isim , $sifre]);
                $basarili = "Kayıt başarılı. Giriş yapabilirsiniz";
                $tab = "login";
              }
            }
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <div class="card mx-auto" style="max-width: 100%;">
        <div class="card-body">
          <h3 class="text-center mb-4 fw-bold">📚 Kütüphane</h3>
            
          <?php if (!empty($hata_mesaji)) : ?>
            <div class="alert alert-danger">
                <?= $hata_mesaji ?>
            </div>
            
            <?php endif ?><?php if (!empty($basarili)) : ?>
            <div class="alert alert-success">
                <?= $basarili ?>
            </div>
            <?php endif ?>
       
          <ul class="nav nav-tabs mb-4 justify-content-center flex-wrap">
            <li class="nav-item flex-fill text-center">
              <a class="nav-link <?= $tab === 'login' ? 'active' : '' ?>" href="?tab=login">Giriş Yap</a>
            </li>
            <li class="nav-item flex-fill text-center">
              <a class="nav-link <?= $tab === 'register' ? 'active' : '' ?>" href="?tab=register">Kayıt Ol</a>
            </li>
          </ul>
          <hr>

          <form method="post">
            <div class="mb-3">
              <label for="isim" class="form-label">Kullanıcı Adı</label>
              <input type="text" class="form-control" id="isim" name="isim" placeholder="Kullanıcı adınızı girin" required>
            </div>
            <div class="mb-3">
              <label for="sifre" class="form-label">Şifre</label>
              <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifrenizi girin" required>
            </div>
            
            <?php if($tab ==="register"){?>

            <div class="mb-3">
              <label for="sifre_tekrar" class="form-label">Şifre Tekrar</label>
              <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifrenizi tekrar girin" required>
            </div>
            <?php }?>

            <button type="submit" class="btn btn-primary w-100 py-2">
             <?= $tab === "login" ? "Giriş Yap" : "Kayıt Ol"?>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>