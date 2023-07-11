<?php include 'sidebar.php'; ?>
<!-- isinya -->

<!-- Kolom Kasir -->
<div class="bg-purple p-2 text-white" style="border-radius:0.25rem; background: #00105b; height:50px; margin-bottom:10px;">
  </h4> <button class="btn btn-basic btn-sm border-0 float-right" type="button" data-toggle="modal" data-target="#LiatProdukExpired"> <i class="fa fa-bell" style="margin-right:5px;"></i>Expired Info
  </button>
  <h4 class="mb-0">Data Produk
</div>

<!-- Kolom Tanggal-->
<div class="bg-purple p-2 text-white" style="border-radius:0.25rem; background:#00105b; height:50px; margin-top:10px; margin-bottom:10px;">
  <h5 class="mb-0">Hari/Tanggal : <span id="tanggalwaktu"></span></h5>
  <!-- Cara Menuntukan Tanggal Hari ini-->
  <script>
    var tw = new Date();
    if (tw.getTimezoneOffset() == 0)(a = tw.getTime() + (7 * 60 * 60 * 1000))
    else(a = tw.getTime());
    tw.setTime(a);
    var tahun = tw.getFullYear();
    var hari = tw.getDay();
    var bulan = tw.getMonth();
    var tanggal = tw.getDate();
    var hariarray = new Array("Minggu,", "Senin,", "Selasa,", "Rabu,", "Kamis,", "Jum'at,", "Sabtu,");
    var bulanarray = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
    document.getElementById("tanggalwaktu").innerHTML = hariarray[hari] + " " + tanggal + " " + bulanarray[bulan] + " " + tahun;
  </script>
</div>

<h1 class="h3 mb-0" style>
  <button class="btn btn-success btn-sm border-0 float-left btn-primary" type="button" data-toggle="modal" data-target="#TambahProduk">+ Tambah Produk</button>
  <br>
</h1>
<hr>

<!-- Modal Notifikasi Produk Expired -->
<div class="modal fade" id="LiatProdukExpired" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
      <form method="post">
        <div class="modal-header bg-danger">
          <h5 class="modal-title text-white">Notifikasi Expired Produk</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          $tgl = date("Y-m-d"); ?>
          <?php $periksa = mysqli_query($conn, "SELECT produk.*, expired.id, min(expired.tgl) as exp, DATEDIFF(min(expired.tgl), '$tgl') as dif FROM `produk` inner JOIN expired ON produk.kode_produk=expired.kode_produk GROUP BY id order by dif asc;");

          echo "<h6 style='color:#FF0000'>Produk Sudah Expired</h6>";
          foreach ($periksa as $produk) {
            $id = $produk['id'];
            $nama_produk = $produk['nama_produk'];
            $exp = $produk['exp'];
            if ($produk['dif'] < 0) { ?>
              <div style='padding:5px' style='width:50px'><span class='glyphicon glyphicon-info-sign'></span><?= $produk["exp"] ?><span style='color:red'>: <?= $nama_produk ?></span> <a href='hapusexpired.php?id=<?= $id ?>'>(hapus)</a> </div>
            <?php }
          }

          echo "<br><h6 style='color:#FF0000'>Produk Hari Ini Akan Expired</h6>";
          foreach ($periksa as $produk) {
            $id = $produk['id'];
            $nama_produk = $produk['nama_produk'];
            $exp = $produk['exp'];
            if ($produk['dif'] === '0') { ?>
              <!-- // echo "<div style='padding:5px' style='width:50px' ><span class='glyphicon glyphicon-info-sign'></span>".$product['exp']."</div>"; ///nama_produk=".$nama_produk."&tgl=".$exp. -->
              <div style='padding:5px' style='width:50px'><span class='glyphicon glyphicon-info-sign'></span><?= $produk["exp"] ?><span style='color:red'>: <?= $nama_produk ?></span> <a href='hapusexpired.php?id=<?= $id ?>'>(hapus)</a> </div>
            <?php }
          }

          echo "<br><h6 style='color:#FF0000'>Produk Minggu Ini Akan Expired</h6>";
          foreach ($periksa as $produk) {
            $id = $produk['id'];
            $nama_produk = $produk['nama_produk'];
            $exp = $produk['exp'];
            if ($produk['dif'] > 0 && $produk['dif'] < 8) { ?>
              <div style='padding:5px' style='width:50px'><span class='glyphicon glyphicon-info-sign'></span><?= $produk["exp"] ?><span style='color:red'>: <?= $nama_produk ?></span> <a href='hapusexpired.php?id=<?= $id ?>'>(hapus)</a> </div>
          <?php }
          } ?>
        </div>
        <div class="modal-footer">

        </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal Produk -->



<table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <th>Harga Modal (pcs)</th>
      <th>Harga Jual (pcs)</th>
      <th>Stok (pcs)</th>
      <!-- <th>Tgl Input</th> -->
      <th>Expired Terdekat</th>
      <th>Opsi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $tglskrg = date("Y-m-d");
    $data_barang = mysqli_query($conn, "SELECT produk.*, min(expired.tgl) as exp FROM `produk` LEFT JOIN expired ON produk.kode_produk=expired.kode_produk GROUP BY produk.kode_produk order by produk.kode_produk asc;");
    while ($d = mysqli_fetch_array($data_barang)) {
    ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['kode_produk']; ?></td>
        <td><?php echo $d['nama_produk']; ?></td>
        <td>Rp. <?php echo ribuan($d['harga_modal']); ?></td>
        <td>Rp. <?php echo ribuan($d['harga_jual']); ?></td>
        <td><?php echo $d['stok']; ?></td>
        <td><?php echo $d['exp']; ?></td>
        <td>
          <button type="button" class="btn btn-primary btn-xs mr-1" data-toggle="modal" data-target="#EditProduk<?php echo $d['idproduk']; ?>">
            <i class="fas fa-pencil-alt fa-xs mr-1"></i>Edit
          </button>
          <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#Hapus<?php echo $d['idproduk']; ?>" style="color:white;">
            <i class="fas fa-trash-alt fa-xs mr-1" style="color:white;"></i>Hapus</a>
          <!-- Modal Hapus -->
          <div class="modal fade" id="Hapus<?php echo $d['idproduk']; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content border-0">
                <div class="modal-body text-center">
                  <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                  <h3 class="mb-4">Apakah anda yakin ingin hapus?</h3>
                  <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">Batal</button>
                  <a href="?hapus=<?php echo $d['kode_produk']; ?>" class="btn btn-primary px-4">Iya</a>
                </div>
              </div>
            </div>
            <!-- end Modal Exit -->
        </td>
      </tr>
      <!-- Modal Tambah Produk -->
      <div class="modal fade" id="EditProduk<?php echo $d['idproduk']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content border-0">
            <form method="post">
              <div class="modal-header bg-succes" style="background:#096623">
                <h5 class="modal-title text-white">Edit Produk</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <!-- <label class="samll">Kode Produk :</label> -->
                  <input type="hidden" name="idproduk" value="<?php echo $d['idproduk']; ?>">
                  <!-- <input type="text" name="Edit_Kode_Produk" value="<?php echo $d['kode_produk']; ?>" class="form-control" required> -->
                </div>
                <div class="form-group">
                  <label class="samll">Nama Produk :</label>
                  <input type="text" name="Edit_Nama_Produk" value="<?php echo $d['nama_produk']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                  <label class="samll">Harga Modal :</label>
                  <input type="number" placeholder="0" name="Edit_Harga_Modal" value="<?php echo $d['harga_modal']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                  <label class="samll">Harga Jual :</label>
                  <input type="number" placeholder="0" name="Edit_Harga_Jual" value="<?php echo $d['harga_jual']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="SimpanEdit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- end Modal Produk -->
    <?php } ?>
  </tbody>
</table>
<?php
function slugify($text, string $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

if (isset($_POST['TambahProduk'])) {
  $namaproduk = htmlspecialchars($_POST['Tambah_Nama_Produk']);
  $harga_modal = htmlspecialchars($_POST['Tambah_Harga_Modal']);
  $harga_jual = htmlspecialchars($_POST['Tambah_Harga_Jual']);
  $kodeproduk = slugify($namaproduk);

  $cekkode = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk='$kodeproduk'"));
  if ($cekkode > 0) {
    echo '<script>alert("Maaf! kode produk sudah ada");history.go(-1);</script>';
  } else {
    $InputProduk = mysqli_query($conn, "INSERT INTO produk (kode_produk,nama_produk,harga_modal,harga_jual)
     values ('$kodeproduk','$namaproduk','$harga_modal','$harga_jual')");
    if ($InputProduk) {
      echo '<script>history.go(-1);</script>';
    } else {
      echo '<script>alert("Gagal Menambahkan Data");history.go(-1);</script>';
    }
  }
};
if (isset($_POST['SimpanEdit'])) {
  $idproduk1 = htmlspecialchars($_POST['idproduk']);
  // $kodeproduk1 = htmlspecialchars($_POST['Edit_Kode_Produk']);
  $namaproduk1 = htmlspecialchars($_POST['Edit_Nama_Produk']);
  $harga_modal1 = htmlspecialchars($_POST['Edit_Harga_Modal']);
  $harga_jual1 = htmlspecialchars($_POST['Edit_Harga_Jual']);
  $kodeproduk1 = slugify($namaproduk1);

  $CariProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk='$kodeproduk1' and idproduk!='$idproduk1'");
  $HasilData = mysqli_num_rows($CariProduk);

  if ($HasilData > 0) {
    echo '<script>alert("Maaf! kode produk sudah ada");history.go(-1);</script>';
  } else {
    $cekDataUpdate =  mysqli_query($conn, "UPDATE produk SET kode_produk='$kodeproduk1',
        nama_produk='$namaproduk1',harga_modal='$harga_modal1',harga_jual='$harga_jual1'
         WHERE idproduk='$idproduk1'") or die(mysqli_connect_error());
    if ($cekDataUpdate) {
      echo '<script>history.go(-1);</script>';
    } else {
      echo '<script>alert("Gagal Edit Data Produk");history.go(-1);</script>';
    }
  }
};
if (!empty($_GET['hapus'])) {
  $idproduk1 = $_GET['hapus'];
  $hapus_data = mysqli_query($conn, "DELETE FROM produk WHERE kode_produk='$idproduk1'");
  if ($hapus_data) {
    echo '<script>history.go(-1);</script>';
  } else {
    echo '<script>alert("Gagal Hapus Data Produk");history.go(-1);</script>';
  }
};
?>
<!-- Modal Tambah Produk -->
<div class="modal fade" id="TambahProduk" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
      <form method="post">
        <div class="modal-header bg-succes" style="background:#096623">
          <h5 class="modal-title text-white">Tambah Produk</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- <div class="form-group">
            <label class="samll">Kode Produk :</label>
            <input type="text" name="Tambah_Kode_Produk" class="form-control" required>
          </div> -->
          <div class="form-group">
            <label class="samll">Nama Produk :</label>
            <input type="text" name="Tambah_Nama_Produk" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="samll">Harga Modal :</label>
            <input type="number" placeholder="0" name="Tambah_Harga_Modal" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="samll">Harga Jual :</label>
            <input type="number" placeholder="0" name="Tambah_Harga_Jual" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" name="TambahProduk" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal Produk -->

<!-- end isinya -->
<?php include 'footer.php'; ?>