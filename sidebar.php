<?php
include "config.php";
session_start();
if ($_SESSION['log'] != "login") {
  header("location:login.php");
}
function ribuan($nilai)
{
  return number_format($nilai, 0, ',', '.');
}
$uid = $_SESSION['userid'];
$DataLogin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM login WHERE userid='$uid'"));
$username = $DataLogin['username'];
$toko = $DataLogin['toko'];
$alamat = $DataLogin['alamat'];
$telepon = $DataLogin['telepon'];
$logo = $DataLogin['logo'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Kasir</title>
  <link rel="icon" href="favicon.ico">
  <link rel="icon" href="favicon.ico" type="image/ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/vendor/datatables/responsive.bootstrap4.min.css" rel="stylesheet">
</head>

<body style="background: #dfeffd;">
  <header style="background: #00115b; height:47px;">
    <br><br>
    <div class="page-wrapper chiller-theme toggled">
      <a id="show-sidebar" class="btn btn-sm btn-success border-0" href="#">
        <i class="fas fa-bars"></i>
      </a>
      <nav id="sidebar" class="sidebar-wrapper" style="background: #63aff7;">
        <div class="sidebar-content">
          <div class="sidebar-brand" style="background: #00115b;">
            <a href="./"><i class="fa fa-book mr-1"></i>SIDHI SARI APP</a>
            <div id="close-sidebar">
              <i class="fas fa-arrow-circle-left"></i>
            </div>
          </div>
          <div class="sidebar-header">
            <div class="user-pic" style="height:50px; width:80%;">
              <img class="img-responsive img-rounded" src="assets/images/logo isi tulisan.png" alt="User picture">
              <h5 class="user-name"><?php echo $toko ?>
              </h5>
            </div>
            <div class="user-info" style="color: black">
              <h5 class="user-name" style="  text-align: center;"><?php echo $toko ?>
              </h5>
            </div>
          </div>
          <!-- sidebar-header  -->

          <div class="sidebar-menu">
            <ul style="color: black">
              <li class="header-menu">
                <span>Menu</span>
              </li>
              <li>
                <a href="produk.php">
                  <i class="fas fa-medkit"></i>
                  <span>Produk</span>
                </a>
              </li>
              <li>
                <a href="faktur-pembelian.php">
                  <i class="fa fa-chart-bar"></i>
                  <span>Faktur Pembelian</span>
                </a>
              </li>
              <li>
                <a href="laporan.php">
                  <i class="fa fa-file"></i>
                  <span>Laporan Transaksi</span>
                </a>
              </li>
              <li>
                <a href="pengaturan.php">
                  <i class="fa fa-cog"></i>
                  <span>Pengaturan</span>
                </a>
              </li>
              <li>
                <a href="#Exit" data-toggle="modal">
                  <i class="fa fa-power-off"></i>
                  <span>Keluar</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- sidebar-menu  -->
        </div>
        <div class="sidebar-footer" style="background: #00115b;">
          PT. SIDHI SARI PHARMA
        </div>
      </nav>
      <!-- sidebar-wrapper  -->
      <main class="page-content">
        <div class="container-fluid">

          <div class="d-block d-sm-block d-md-none d-lg-none py-2"></div>