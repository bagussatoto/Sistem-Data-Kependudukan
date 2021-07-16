<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-file"></i> Su-Ket Pendatang</h3>
	</div>
	<form action="./report/cetak_datang.php" method="post" enctype="multipart/form-data">
		<div class="card-body">

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Pendatang</label>
				<div class="col-sm-6">
					<select name="id_datang" id="id_datang" class="form-control select2bs4" required>
						<option selected="selected">- Pilih Data -</option>
						<?php
				// ambil data dari database
				$query = "select * from tb_datang";
				$hasil = mysqli_query($koneksi, $query);
				while ($row = mysqli_fetch_array($hasil)) {
				?>
						<option value="<?php echo $row['id_datang'] ?>">
							<?php echo $row['nik'] ?>
							-
							<?php echo $row['nama_datang'] ?>
						</option>
						<?php
				}
				?>
					</select>
				</div>
			</div>

		</div>
		<div class="card-footer">

			<input target="_blank" type="submit" name="Cetak" value="Cetak" class="btn btn-info"></input>
		</div>
	</form>
</div>