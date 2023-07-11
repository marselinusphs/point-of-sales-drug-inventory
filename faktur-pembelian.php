<?php include 'sidebar.php';
$dataselect = mysqli_query($conn, "SELECT * FROM produk"); ?>

<!-- isinya -->
<!-- Kolom Faktur-->
<div class="bg-purple p-2 text-white" style="border-radius:0.25rem; background: #00105b; height:50px; margin-bottom:10px;">
    <h4 class="mb-0">Faktur Pembelian</h4>
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

<h1 class="h3 mb-0">
    <button class="btn btn-success btn-sm border-0 float-left btn-primary" type="button" data-toggle="modal" data-target="#RiwayatPembelian">Tambah Faktur</button>
</h1>
<br>
<hr>

<table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Beli</th>
            <th>Nama Produk</th>
            <th>Qty (Pcs)</th>
            <th>Expired Date</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $tglskrg = date("Y-m-d");
        $data_barang = mysqli_query($conn, "SELECT faktur_beli.*, produk.nama_produk FROM `faktur_beli` left join produk on faktur_beli.kode_produk = produk.kode_produk order by tgl desc;");
        while ($d = mysqli_fetch_array($data_barang)) {
            // var_dump($d['qty']);
        ?>
            <tr>

                <td><?php echo $no++; ?></td>
                <td><?php echo $d['tgl']; ?></td>
                <td><?php echo $d['nama_produk']; ?></td>
                <td><?php echo $d['qty']; ?></td>
                <td><?php echo $d['expired']; ?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-xs mr-1" data-toggle="modal" data-target="#EditProduk<?php echo $d['id_faktur']; ?>">
                        <i class="fas fa-pencil-alt fa-xs mr-1"></i>Edit
                    </button>
                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#Hapus<?php echo $d['id_faktur']; ?>" style="color:white;">
                        <i class="fas fa-trash-alt fa-xs mr-1" style="color:white;"></i>Hapus</a>
                    <!-- Modal Hapus -->
                    <div class="modal fade" id="Hapus<?php echo $d['id_faktur']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content border-0">
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                    <h3 class="mb-4">Apakah anda yakin ingin hapus?</h3>
                                    <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">Batal</button>
                                    <a href="hapusfaktur.php?id_faktur=<?= $d['id_faktur']; ?>" class="btn btn-primary px-4">Iya</a>
                                </div>
                            </div>
                        </div>
                        <!-- end Modal Exit -->
                </td>
            </tr>


            <!-- Modal Tambah Produk -->
            <div class="modal fade" id="EditProduk<?php echo $d['id_faktur']; ?>" tabindex="-1" role="dialog">
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
                                    <label class="samll">Tanggal Pembelian :</label>
                                    <input type="date" name="Edit_Tanggal_Pembelian" value="<?php echo $d['tgl']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="samll">Kode Produk :</label>
                                    <input type="hidden" name="idproduk" value="<?php echo $d['kode_produk']; ?>">
                                    <input type="text" name="Edit_Kode_Produk" value="<?php echo $d['kode_produk']; ?>" class="form-control" required list="datalist2">
                                    <datalist id="datalist2">
                                        <?php if (mysqli_num_rows($dataselect)) { ?>
                                            <?php while ($row_brg = mysqli_fetch_array($dataselect)) { ?>
                                                <option value="<?php echo $row_brg["kode_produk"] ?>"> <?php echo $row_brg["kode_produk"] ?></option>
                                            <?php
                                            } ?>
                                        <?php } ?>
                                    </datalist>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label class="samll">ID :</label>
                                    <input type="hidden" name="Edit_ID" value="<?php echo $d['id_faktur']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="samll">Qty :</label>
                                    <input type="number" placeholder="0" name="Edit_Qty" value="<?php echo $d['qty']; ?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="samll">Expired :</label>
                                    <input type="date" placeholder="0" name="Edit_Expired" value="<?php echo $d['expired']; ?>" class="form-control" required>
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
    $tgl = htmlspecialchars($_POST['Tambah_Tanggal_Pembelian']);
    $kodeproduk = htmlspecialchars($_POST['Tambah_Nama_Produk']);
    $qty = htmlspecialchars($_POST['Tambah_Qty']);
    $expired = htmlspecialchars($_POST['Tambah_Expired']);
    // $kodeproduk = slugify($namaproduk);

    $cekkode = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk='$kodeproduk'"));
    $InputProduk = mysqli_query($conn, "INSERT INTO faktur_beli (tgl, kode_produk, qty, expired)
     values ('$tgl', '$kodeproduk','$qty','$expired')");
    $InsertExp = mysqli_query($conn, "INSERT INTO expired (kode_produk, tgl)
     values ('$kodeproduk','$expired')");
    $UpdateProduk = mysqli_query($conn, "UPDATE produk SET stok=stok+$qty WHERE kode_produk='$kodeproduk'");
    if ($InputProduk && $UpdateProduk && $InsertExp) {
        echo '<script>history.go(-1);</script>';
    } else {
        echo '<script>alert("Gagal Menambahkan Data");history.go(-1);</script>';
    }
};
if (isset($_POST['SimpanEdit'])) {
    $id = htmlspecialchars($_POST['Edit_ID']);
    $tgl1 = htmlspecialchars($_POST['Edit_Tanggal_Pembelian']);
    $idproduk1 = htmlspecialchars($_POST['Edit_Kode_Produk']);
    // $namaproduk1 = htmlspecialchars($_POST['Edit_Nama_Produk']);
    $qty1 = htmlspecialchars($_POST['Edit_Qty']);
    $expired1 = htmlspecialchars($_POST['Edit_Expired']);
    // $kodeproduk1 = slugify($namaproduk1);

    // $CariProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk='$kodeproduk1' and idproduk!='$idproduk1'");
    // $HasilData = mysqli_num_rows($CariProduk);

    // if ($HasilData > 0) {
    //     echo '<script>alert("Maaf! kode produk sudah ada");history.go(-1);</script>';
    // } else {
    $cekDataUpdate =  mysqli_query($conn, "UPDATE faktur_beli SET tgl='$tgl1', kode_produk='$idproduk1', qty='$qty1', expired='$expired1'
         WHERE id_faktur='$id'") or die(mysqli_connect_error());
    if ($cekDataUpdate) {
        echo '<script>history.go(-1);</script>';
    } else {
        echo '<script>alert("Gagal Edit Data Produk");history.go(-1);</script>';
    }
    // }
};
if (!empty($_GET['hapus'])) {
    $idproduk1 = $_GET['hapus'];
    $hapus_data = mysqli_query($conn, "DELETE FROM faktur_beli WHERE id_faktur='$id'");
    if ($hapus_data) {
        echo '<script>history.go(-1);</script>';
    } else {
        echo '<script>alert("Gagal Hapus Data Produk");history.go(-1);</script>';
    }
};
?>

<!-- Modal Tambah Riwayat Pembelian -->
<div class="modal fade" id="RiwayatPembelian" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <form method="post">
                <div class="modal-header bg-succes" style="background:#096623">
                    <h5 class="modal-title text-white">Tambah Riwayat Faktur Pembelian</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        $tgl = date("Y-m-d"); ?>
                        <label class="samll">Tanggal Pembelian :</label>
                        <input type="date" name="Tambah_Tanggal_Pembelian" value="<?php echo $tgl ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="samll">Nama Produk:</label>
                        <input type="text" name="Tambah_Nama_Produk" class="form-control" list="datalist2" autocomplete="off" required>
                        <datalist id="datalist1">
                            <?php if (mysqli_num_rows($dataselect)) { ?>
                                <?php while ($row_brg = mysqli_fetch_array($dataselect)) { ?>
                                    <option value="<?php echo $row_brg["kode_produk"] ?>"> <?php echo $row_brg["kode_produk"] ?></option>
                                <?php
                                } ?>
                            <?php } ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label class="samll">Qty:</label>
                        <input type="number" placeholder="0" name="Tambah_Qty" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="samll">Expired :</label>
                        <input type="date" placeholder="0" name="Tambah_Expired" class="form-control" required>
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