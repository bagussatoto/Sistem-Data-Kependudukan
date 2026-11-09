<?php

    if(isset($_GET['kode'])){
        $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
        $sql_cek = "SELECT * FROM tb_pengguna WHERE id_pengguna='$kode'";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<div class="card card-success">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-edit"></i> Ubah Data</h3>
	</div>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="card-body">

			<input type='hidden' class="form-control" name="id_pengguna" value="<?php echo $data_cek['id_pengguna']; ?>"
			 readonly/>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Nama User</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?php echo $data_cek['nama_pengguna']; ?>"
					/>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Username</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="username" name="username" value="<?php echo $data_cek['username']; ?>"
					/>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-6">
					<input type="password" class="form-control" id="pass" name="password" value="<?php echo $data_cek['password']; ?>"
					/>
					<input id="mybutton" onclick="change()" type="checkbox" class="form-checkbox"> Lihat Password
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Level</label>
				<div class="col-sm-4">
					<select name="level" id="level" class="form-control">
						<option value="">-- Pilih Level --</option>
						<?php
                //menhecek data yg dipilih sebelumnya
                if ($data_cek['level'] == "Administrator") echo "<option value='Administrator' selected>Administrator</option>";
                else echo "<option value='Administrator'>Administrator</option>";

                if ($data_cek['level'] == "Kaur Pemerintah") echo "<option value='Kaur Pemerintah' selected>Kaur Pemerintah</option>";
                else echo "<option value='Kaur Pemerintah'>Kaur Pemerintah</option>";
            ?>
					</select>
				</div>
			</div>

		</div>
		<div class="card-footer">
			<input type="submit" name="Ubah" value="Simpan" class="btn btn-success">
			<a href="?page=data-pengguna" title="Kembali" class="btn btn-secondary">Batal</a>
		</div>
	</form>
</div>



<?php

    if (isset ($_POST['Ubah'])){
        $id_pengguna   = mysqli_real_escape_string($koneksi, trim($_POST['id_pengguna']));
        $nama_pengguna = mysqli_real_escape_string($koneksi, trim($_POST['nama_pengguna']));
        $username      = mysqli_real_escape_string($koneksi, trim($_POST['username']));
        $level         = mysqli_real_escape_string($koneksi, trim($_POST['level']));

        // Cek jika password diubah
        $pass_input = $_POST['password'];
        if ($pass_input === $data_cek['password']) {
            $password = mysqli_real_escape_string($koneksi, $data_cek['password']);
        } else {
            $password = mysqli_real_escape_string($koneksi, password_hash($pass_input, PASSWORD_DEFAULT));
        }

        $sql_ubah = "UPDATE tb_pengguna SET
            nama_pengguna='$nama_pengguna',
            username='$username',
            password='$password',
            level='$level'
            WHERE id_pengguna='$id_pengguna'";
        $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
      Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {if (result.value)
        {window.location = 'index.php?page=data-pengguna';
        }
      })</script>";
      }else{
      echo "<script>
      Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {if (result.value)
        {window.location = 'index.php?page=data-pengguna';
        }
      })</script>";
    }}
?>

<script type="text/javascript">
    function change()
    {
    var x = document.getElementById('pass').type;

    if (x == 'password')
    {
        document.getElementById('pass').type = 'text';
        document.getElementById('mybutton').innerHTML;
    }
    else
    {
        document.getElementById('pass').type = 'password';
        document.getElementById('mybutton').innerHTML;
    }
    }
</script>