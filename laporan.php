<?php include 'sidebar.php'; ?>
<!-- isinya -->
<?php
$i1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(qty) as totqty FROM laporan"));
$i2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(qty*harga_modal) as totdpt FROM laporan"));
$i3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(subtotal-qty*harga_modal) as totdpt1 FROM laporan"));
$i4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(subtotal) as isub FROM laporan"));
?>

<!-- Kolom Laporan-->
<div class="bg-purple p-2 text-white" style="border-radius:0.25rem; background: #00105b; height:50px; margin-bottom:10px;">
  <button class="btn btn-basic btn-sm border-0 float-right" type="button" onclick="document.title='LAPORAN BULANAN';window.print()">Cetak Laporan
  </button>
  <h4 class="mb-0">Data Laporan Transaksi </h4>
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

<div class="row">

  <div class="col-6 col-sm-6 col-md-3 col-lg-3 m-pr-1 m-mb-1">
    <div class="box-laporan" style="background:#63aff7;">
      <p class="small mb-0">Terjual</p>
      <h5 class="mb-0"><?php echo ribuan($i1['totqty']); ?></h5>
    </div>
  </div>

  <div class="col-6 col-sm-6 col-md-3 col-lg-3 m-pl-1 m-mb-1">
    <div class="box-laporan" style="background:#63aff7;">
      <p class="small mb-0">Pendapatan</p>
      <h5 class="mb-0">Rp. <?php echo ribuan($i3['totdpt1']); ?></h5>
    </div>
  </div>

  <div class="col-6 col-sm-6 col-md-3 col-lg-3 m-pr-1">
    <div class="box-laporan" style="background:#63aff7;">
      <p class="small mb-0">Penjualan</p>
      <h5 class="mb-0">Rp. <?php echo ribuan($i2['totdpt']); ?></h5>
    </div>
  </div>

  <div class="col-6 col-sm-6 col-md-3 col-lg-3 m-pl-1">
    <div class="box-laporan" style="background:#63aff7;">
      <p class="small mb-0">Total</p>
      <h5 class="mb-0">Rp. <?php echo ribuan($i4['isub']); ?></h5>
    </div>
  </div>
</div>
<hr>

<table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Invoice</th>
      <th>Qty</th>
      <th>SubTotal</th>
      <th>Pembayaran</th>
      <th>Kembalian</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $data_laporan = mysqli_query($conn, "SELECT * FROM inv WHERE status='selesai' ORDER BY invid ASC");
    while ($d = mysqli_fetch_array($data_laporan)) {
      $oninv = $d['invoice'];
    ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><a href="invoice.php?detail=<?php echo $oninv ?>"><?php echo $d['invoice']; ?></a></td>
        <td><?php
            $result1 = mysqli_query($conn, "SELECT SUM(qty) AS count FROM laporan WHERE invoice='$oninv'");
            $cekrow = mysqli_num_rows($result1);
            $row1 = mysqli_fetch_assoc($result1);
            $count = $row1['count'];
            if ($cekrow > 0) {
              echo ribuan($count);
            } else {
              echo '0';
            } ?></td>
        <td>Rp. <?php
                $result2 = mysqli_query($conn, "SELECT SUM(subtotal) AS count1 FROM laporan WHERE invoice='$oninv'");
                $cekrow1 = mysqli_num_rows($result2);
                $row2 = mysqli_fetch_assoc($result2);
                $count1 = $row2['count1'];
                if ($cekrow1 > 0) {
                  echo ribuan($count1);
                } else {
                  echo '0';
                } ?></td>
        <td>Rp. <?php echo ribuan($d['pembayaran']); ?></td>
        <td>Rp. <?php echo ribuan($d['kembalian']); ?></td>
        <td><?php echo $d['tgl_inv']; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<div>
  <!-- <button class="btn btn-danger btn-sm border-0 float-right " type="button" style="margin-top:10px;" data-toggle="modal" data-target="#Hapusa<?php echo $d['invoice']; ?>">Hapus Semua Data</button> -->
  <!-- Modal Hapus -->
  <div class="modal fade" id="Hapusa<?php echo $d['invoice']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content border-0">
        <div class="modal-body text-center">
          <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
          <h3 class="mb-4">Apakah anda yakin ingin hapus?</h3>
          <form method="post">
            <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">Batal</button>
            <button type="submit" name="RemoveAll" class="btn btn-primary px-4 mr-2">
              Hapus</button>
          </form>
        </div>
      </div>
    </div>
    <!-- end Modal Exit -->
  </div>

  <?php
  if (isset($_POST['Remove'])) {
    $nona = $_POST['nona'];
    $hapus_data_Cart_all = mysqli_query($conn, "DELETE FROM laporan WHERE invoice='$nona'");
    $hapus_data_Cart_all1 = mysqli_query($conn, "DELETE FROM inv WHERE invoice='$nona'");
    if ($hapus_data_Cart_all && $hapus_data_Cart_all1) {
      echo '<script>;window.location="laporan.php"</script>';
    } else {
      echo '<script>alert("Gagal Hapus Data keranjang");history.go(-1);</script>';
    }
  };


  if (isset($_POST['RemoveAll'])) {
    $hapus_data_Cart_all = mysqli_query($conn, "DELETE FROM laporan WHERE 1");
    $hapus_data_Cart_all1 = mysqli_query($conn, "DELETE FROM inv WHERE 1");
    if ($hapus_data_Cart_all && $hapus_data_Cart_all1) {
      echo '<script>;window.location="laporan.php"</script>';
    } else {
      echo '<script>alert("Gagal Hapus Data keranjang");history.go(-1);</script>';
    }
  };

  ?>

  <!-- data print -->
  <section id="print">
    <div class="d-none pt-5 px-5 print-show">
      <div class="text-center mb-5 pt-2">
        <h2 class="mb-3" style="font-size:60px;">LAPORAN PENJUALAN </h2>
        <h2 class="mb-3" style="font-size:60px;">BULAN <span class="mb-3" style="font-size:60px;" id="bulan"></span></h2>
        <script>
          var tw = new Date();
          if (tw.getTimezoneOffset() == 0)(a = tw.getTime() + (7 * 60 * 60 * 1000))
          else(a = tw.getTime());
          tw.setTime(a);
          var tahun = tw.getFullYear();
          var bulan = tw.getMonth();
          var bulanarray = new Array("JANUARI", "FEBUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
          document.getElementById("bulan").innerHTML = bulanarray[bulan] + " " + tahun;
        </script>
        </h2>
        <h2 class="mb-3" style="font-size:60px;"><?php echo $toko ?></h2>
        <h2 class="mb-0"><?php echo $alamat ?></h2>
        <h2 class="mb-4">Telp : <?php echo $telepon ?></h2>
      </div>
      <div class="row">
        <div class="col-12 py-3 my-3 border-top border-bottom">
          <div class="row">
            <div class="col-5">
              <h2 class="mb-0 py-1" style="font-weight:700;">Invoice</h2>
            </div>
            <div class="col-3">
              <h2 class="mb-0 py-1" style="font-weight:700;">Qty</h2>
            </div>
            <div class="col-4">
              <h2 class="mb-0 py-1" style="font-weight:700;">Subtotal</h2>
            </div>
          </div>
        </div>
        <?php
        $no = 1;
        $dataprint = mysqli_query($conn, "SELECT * FROM laporan inner JOIN inv ON laporan.invoice=inv.invoice");
        while ($c = mysqli_fetch_array($dataprint)) {
        ?>
          <div class="col-12">
            <div class="row">
              <div class="col-5">
                <h2 class="mb-0 py-1" style="font-weight:500;"><?php echo $c['invoice']; ?></h2>
              </div>
              <div class="col-3">
                <h2 class="mb-0 py-1" style="font-weight:500;"><?php echo ribuan($c['qty']); ?></h2>
              </div>
              <div class="col-4">
                <h2 class="mb-0 py-1" style="font-weight:500;"><?php echo ribuan($c['subtotal']); ?></h2>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="col-12 py-3 my-3 border-top">
          <div class="row justify-content-end">
            <div class="col-12 text-left border-bottom">
              <h2 class="mb-1" style="font-weight:500;">Total Qty Terjual Bulan Ini<span class="ml-5">:</span> <span class="mb-1" style="font-weight:700;"><?php echo ribuan($i1['totqty']); ?></span></h2>
              <h2 class="mb-1" style="font-weight:500;">Total Keuntungan Bulan Ini <span class="ml-3">:</span> <span class="mb-1" style="font-weight:700;"><?php echo ribuan($i3['totdpt1']) ?></span></h2>
              <h2 class="mb-1" style="font-weight:500;">Total Penjualan Bulan Ini <span class="ml-5">:</span> <span class="mb-1" style="font-weight:700;"><?php echo ribuan($i2['totdpt']) ?></span></h2>
            </div>
          </div>
        </div>
        <div class="col-12 text-center mt-5">
          <h2>* Apotik Sidhi Sari Pharma *</h2>
        </div>
      </div><!-- end row -->
    </div><!-- end box print -->
  </section>
  <!-- end data print -->
  </section>
  <!-- end data print -->
  <!-- end isinya -->
  <?php include 'footer.php'; ?>