<?php
@ob_start();
session_start();
include 'config.php';
if (!isset($_SESSION['log'])) {
} else {
  header('location:produk.php');
};

if (isset($_POST['login'])) {
  $user = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  $queryuser = mysqli_query($conn, "SELECT * FROM login WHERE username='$user'");
  $cariuser = mysqli_fetch_assoc($queryuser);

  if (password_verify($pass, $cariuser['password'])) {
    $_SESSION['userid'] = $cariuser['userid'];
    $_SESSION['username'] = $cariuser['username'];
    $_SESSION['log'] = "login";

    if ($cariuser) {
      echo '<script>alert("Selamat Datang");window.location="produk.php"</script>';
    } else {
      echo '<script>alert("Data yang anda masukan salah");history.go(-1);</script>';
    }
    echo '<script>alert("Anda Berhasil Login");window.location="produk.php"</script>';
  } else {
    echo '<script>alert("Username atau password salah");history.go(-1);</script>';
  }
};
?>

<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="logincss/css/style.css">

</head>

<body>
  <section class="mt-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
          <div class="wrap">
            <div class="img" style="background-image: url(logincss/images/bg-1.jpg);"></div>
            <div class="login-wrap p-4 p-md-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">Masuk</h3>
                </div>
              </div>
              <form class="signin-form" method="POST">
                <div class="form-group mt-3 mt-3">
                  <input type="text" id="inputuser" name="username" class="form-control" required>
                  <label class="form-control-placeholder" for="username">Username</label>
                </div>
                <div class="form-group">
                  <input id="inputPassword" name="password" type="password" class="form-control" required>
                  <label class="form-control-placeholder" for="password">Password</label>
                  <span toggle="#inputPassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3" name="login">Masuk</button>
                </div>
              </form>
              <p class="text-center">Belum terdaftar? <a target="_blank" href="https://api.whatsapp.com/send/?phone=6282146335793&text&type=phone_number&app_absent=0">Hubungi Admin</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="logincss/js/jquery.min.js"></script>
  <script src="logincss/js/popper.js"></script>
  <script src="logincss/js/bootstrap.min.js"></script>
  <script src="logincss/js/main.js"></script>

</body>

</html>