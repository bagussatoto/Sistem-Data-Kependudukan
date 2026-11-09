<?php
if(isset($_GET['kode'])){
    $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);

    // Ambil id_pdd untuk mengembalikan status penduduk menjadi 'Ada'
    $sql_cek = "SELECT id_pdd FROM tb_mendu WHERE id_mendu='$kode'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

    if ($data_cek) {
        $id_pdd = $data_cek['id_pdd'];

        $sql_hapus = "DELETE FROM tb_mendu WHERE id_mendu='$kode'";
        $query_hapus = mysqli_query($koneksi, $sql_hapus);

        if ($query_hapus) {
            mysqli_query($koneksi, "UPDATE tb_pdd SET status='Ada' WHERE id_pend='$id_pdd'");

            echo "<script>
            Swal.fire({title: 'Hapus Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data-mendu';
                }
            })</script>";
        } else {
            echo "<script>
            Swal.fire({title: 'Hapus Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data-mendu';
                }
            })</script>";
        }
    } else {
        echo "<script>
        Swal.fire({title: 'Data Tidak Ditemukan',text: '',icon: 'warning',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-mendu';
            }
        })</script>";
    }
}
?>
