<?php
  session_start();
  include "inc/koneksi.php";

  if (isset($_SESSION["ses_username"]) && !empty($_SESSION["ses_username"])) {
      header("location: index.php");
      exit();
  }

  $pesan_login = "";
  if (isset($_POST['btnLogin'])) {  
      // anti inject sql
      $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
      $password = $_POST['password'];

      // query login cek username
      $sql_login = "SELECT * FROM tb_pengguna WHERE BINARY username='$username'";
      $query_login = mysqli_query($koneksi, $sql_login);
      $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);

      if ($data_login) {
          $password_valid = false;
          // Cek hash modern bcrypt ATAU verifikasi plaintext lama (backward compatibility)
          if (password_verify($password, $data_login['password'])) {
              $password_valid = true;
          } elseif ($password === $data_login['password']) {
              $password_valid = true;
              // Migrasi otomatis password lama menjadi hash bcrypt
              $new_hash = password_hash($password, PASSWORD_DEFAULT);
              $id_u = $data_login['id_pengguna'];
              mysqli_query($koneksi, "UPDATE tb_pengguna SET password='$new_hash' WHERE id_pengguna='$id_u'");
          }

          if ($password_valid) {
              $_SESSION["ses_id"] = $data_login["id_pengguna"];
              $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
              $_SESSION["ses_username"] = $data_login["username"];
              $_SESSION["ses_password"] = $data_login["password"];
              $_SESSION["ses_level"] = $data_login["level"];

              $pesan_login = "success";
          } else {
              $pesan_login = "failed";
          }
      } else {
          $pesan_login = "failed";
      }
  }
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>login | SIDAK</title>
	<link rel="icon" href="dist/img/izin.png">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<center>
					<img src="dist/img/izin.png" width=170px />
					<br>
					<br>
					<h5>
						<b>Sistem Data Kependudukan</b>
						<p>Desa Tamantirto</p>
					</h5>
					<br>
				</center>

				<form action="" method="post">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" placeholder="Username" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-danger btn-block btn-flat" name="btnLogin" title="Masuk Sistem">
								<b>Login</b>
							</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- Alert -->
	<script src="plugins/alert.js"></script>

<?php if ($pesan_login == "success") { ?>
	<script>
		Swal.fire({title: 'Login Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) { window.location = 'index.php'; }
		});
	</script>
<?php } elseif ($pesan_login == "failed") { ?>
	<script>
		Swal.fire({title: 'Login Gagal', text: '', icon: 'error', confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) { window.location = 'login.php'; }
		});
	</script>
<?php } ?>

</body>

</html>
