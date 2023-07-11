<?php
function hapusexpired($id)
{
    $conn = mysqli_connect("localhost", "root", "", "db_kasir");
    mysqli_query($conn, "DELETE FROM expired WHERE id='$id'"); ?>
        <?php return mysqli_affected_rows($conn);
    }

    $id = $_GET['id'];

    if (hapusexpired($id) > 0) {
        echo "
        <script>
            alert('Data berhasil dihapus');
            document.location.href = 'produk.php';
        </script>";
    } else {
        echo "
            <script>
                alert('Data gagal dihapus');
                document.location.href = 'produk.php';
            </script>";
    }


        ?>