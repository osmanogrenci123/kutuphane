
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kütüphane Giriş / Kayıt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to bottom right, #ffffff, #a8a8a8);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.5);
    }
    .card-body {
      padding: 2rem;
    }
    .nav-tabs {
      border-bottom: none;
    }
    .nav-tabs .nav-link.active {
      background-color: #764ba2;
      color: white;
      border-radius: 0.5rem 0.5rem 0 0;
    }
    .nav-tabs .nav-link {
      color: #764ba2;
      font-weight: 500;
      margin-right: 0.5rem;
    }
    .form-control:focus {
      border-color: #764ba2;
      box-shadow: 0 0 0 0.2rem rgba(118,75,162,0.25);
    }
    .btn-primary {
      background-color: #764ba2;
      border-color: #764ba2;
    }
    .btn-primary:hover {
      background-color: #667eea;
      border-color: #667eea;
    }
    .alert {
      border-radius: 0.5rem;
    }
    .nav-tabs.justify-content-start {
      justify-content: flex-start !important;
    }
    .nav-tabs {
  border-bottom: none;
  padding-left: 0;
}

.nav-tabs .nav-link {
  color: #764ba2;
  font-weight: 600;
  margin-right: 0.5rem;
  background-color: #f0f0f0; /* pasif sekmeler için açık ton */
  border: 1px solid transparent;
  border-radius: 0.5rem 0.5rem 0 0;
  padding: 0.5rem 1rem;
  transition: all 0.3s;
}

.nav-tabs .nav-link.active {
  background-color: #764ba2; /* aktif sekme */
  color: #fff;
  font-weight: 700;
  border: 1px solid #764ba2;
  border-bottom: none;
}

.nav-tabs .nav-link:hover {
  background-color: #5e3ea1;
  color: #fff;
}
/* Mobilde kart padding azalt */
@media (max-width: 700px) {
  .card-body {
    padding: 1.5rem;
  }

  /* Sekmeler mobilde full genişlik */
  .nav-tabs .nav-item {
    flex: 1 1 100%;
    margin-bottom: 0.25rem;
  }
  .nav-tabs .nav-link {
    text-align: center;
  }
}


  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <div class="card mx-auto" style="max-width: 100%;">
        <div class="card-body">
          <h3 class="text-center mb-4 fw-bold">📚 Kütüphane</h3>

       

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

            <div class="mb-3">
              <label for="sifre_tekrar" class="form-label">Şifre Tekrar</label>
              <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifrenizi tekrar girin" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
             Giriş Yap
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
