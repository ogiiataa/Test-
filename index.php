<?php  
//koneksi database
$server = "localhost";
$user = "root";
$pass = "";
$database = "database_mlm";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));


//Jika Tombol Simpan di Klik 
if (isset($_POST['bsimpan'])) 
{

	// Pengujian apakah data akan disimpan atau di edit baru 
	if ($_GET ['hal'] =="edit") 
	{
		// Data akan di edit

		$edit = mysqli_query($koneksi," UPDATE mlm set 
										id = '$_POST[tid]',
										nama = '$_POST[tnama]',
										alamat = '$_POST[talamat]',
										notelp = '$_POST[ttelp]',
										namaupline = '$_POST[tupline]'
										WHERE no = '$_GET[no]'
									");
	if ($edit)  //Jika Edit Sukses 
	{
		echo "<script>
		alert('Edit Data Sukses !');
		document.location='index.php';
		</script>";
	}
	else 
	{
		echo "<script>
		alert('Edit Data Gagal !!!');
		document.location='index.php';
		</script>";
	}

	}else
	{
		// Data akan disimpan baru
		$simpan = mysqli_query($koneksi,"INSERT INTO mlm (id, nama, alamat, notelp, namaupline)
									VALUES ('$_POST[tid]',
									        '$_POST[tnama]',
									        '$_POST[talamat]',
									        '$_POST[ttelp]',
									        '$_POST[tupline]')
									");
	if ($simpan)  //Jika Simpan Sukses 
	{
		echo "<script>
		alert('Simpan Data Sukses !');
		document.location='index.php';
		</script>";
	}
	else 
	{
		echo "<script>
		alert('Simpan Data Gagal !!!');
		document.location='index.php';
		</script>";
	} 
	}

	
}


//Pengujian jika tombol edit atau hapus di klik 
if (isset($_GET['hal'])) 
{
	//Pengujian jika edit data
	if ($_GET['hal'] == "edit") 
	{
		//Tampilkan data yang akan di edit
		$tampil = mysqli_query($koneksi, "SELECT * FROM mlm WHERE no = '$_GET[no]'");
		$data = mysqli_fetch_array($tampil);
		if ($data) 
		{
			//Jika data ditemukan, maka data ditampung ke dalam variabel
			$vid = $data['id'];
			$vnama = $data['nama'];
			$valamat = $data['alamat'];
			$vnotelp = $data['notelp'];
			$vnamaupline = $data['namaupline'];
		}
	}

	else if ($_GET['hal'] == "hapus")
	{

		//Persiapan hapus data 
		$hapus = mysqli_query($koneksi, "DELETE FROM mlm WHERE no = '$_GET[no]'");
			if ($hapus) {
		echo "<script>
		alert('Hapus Data Berhasil!');
		document.location='index.php';
		</script>";
			}
	}
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>MLM</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		

	<h1 class="text-center">Input Member Baru</h1>
	<h2 class="text-center">MLM</h2>

<!-- Awal Card F -->
	<div class="card mt-4">
  <div class="card-header bg-primary text-white">
    Input Member
  </div>
  <div class="card-body">
   <form method="post" action="">

   	<div class="form-group">
   		<label>ID</label>
   		<input type="text" name="tid" value="<?=@$vid?>" class="form-control" placeholder="Input No Id Anda Di Sini" required>
   	</div>

   		<div class="form-group">
   		<label>Nama</label>
   		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda Di Sini" required>
   	</div>

   		<div class="form-group">
   		<label>Alamat</label>
   		<textarea class="form-control" name="talamat" placeholder="Input Alamat Anda Di Sini" required><?=@$valamat?></textarea>
   	</div>

   		<div class="form-group">
   		<label>No. Telp</label>
   		<input type="text" name="ttelp" value="<?=@$vnotelp?>" class="form-control" placeholder="Input No Telp Anda Di Sini" required>
   	</div>

   		<div class="form-group">
   		<label>Nama Upline</label>
   		<input type="text" name="tupline" value="<?=@$vnamaupline?>" class="form-control" placeholder="Input Nama Upline Anda Di Sini" required>

   		   	</div>
   		   	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
   		   	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
   		   	<button type="search" class="btn btn-success" name="bsearch">Cari</button>

   </form> 
  </div>
</div>

<!-- Akhir Card F -->

<!-- Awal Card Tabel -->
	<div class="card mt-4">
  <div class="card-header bg-success text-white">
    Daftar Member
  </div>
  <div class="card-body">
   <table class="table table-bordered table-striped">
   	<tr>
   		<th>No</th>
   		<th>Id</th>
   		<th>Nama</th>
   		<th>Alamat</th>
   		<th>No. Telp</th>
   		<th>Nama Upline</th>
   		<th>Action</th>
   	</tr>
<?php
$no = 1;
$tampil = mysqli_query($koneksi, "SELECT * from mlm order by id desc");
while($data = mysqli_fetch_array($tampil)) : 
 ?>
   	<tr>
   		<td><?=$no++;?></td>
   		<td><?=$data['id']?></td>
   		<td><?=$data['nama']?></td>
   		<td><?=$data['alamat']?></td>
   		<td><?=$data['notelp']?></td>
   		<td><?=$data['namaupline']?></td>
   		<td>
   			<a href="index.php?hal=edit&no=<?=$data['no'] ?>" class="btn btn-warning">Edit</a>
   			<a href="index.php?hal=hapus&no=<?=$data['no']?>" onclick="return confirm('Apakah yakin akan menghapus data ini ?')"  class="btn btn-danger">Hapus</a>
   		</td>
   	</tr>
<?php endwhile; //Penutup Perulangan While ?>

   </table>
  </div>
</div>

<!-- Akhir Card Tabel -->

	</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>