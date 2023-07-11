<?php
function hapusfaktur($id_faktur)
{
    $conn = mysqli_connect("localhost", "root", "", "db_kasir");
    mysqli_query($conn, "DELETE FROM faktur_beli WHERE id_faktur='$id_faktur'"); ?>
        <?php return mysqli_affected_rows($conn);
    }

    $id_faktur = $_GET['id_faktur'];

    if (hapusfaktur($id_faktur) > 0) {
        echo "
        <script>
            alert('Data berhasil dihapus');
            document.location.href = 'faktur-pembelian.php';
        </script>";
    } else {
        echo "
            <script>
                alert('Data gagal dihapus');
                document.location.href = 'faktur-pembelian.php';
            </script>";
    }


        ?>