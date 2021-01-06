<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "arkademy";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

//uji data akan di edit atau disimpan baru
if (isset($_POST['bsimpan']))
{
  if ($_GET['hal']=='edit')
  {

    $edit = mysqli_query($koneksi, "UPDATE produk set
                                    nama_produk= '$_POST[tnama_produk]',
                                    keterangan= '$_POST[tketerangan_produk]',
                                    harga= '$_POST[tharga_produk]',
                                    jumlah= '$_POST[tjumlah_produk]'
                                    WHERE id_produk='$_GET[id]'
                                      ");
  
    if ($edit)
    {
      echo "<script>
            alert('Edit data sukses!');
            document.location='index.php';
            </script>";
    }
    else
    {
      echo "<script>
            alert('Edit data gagal!');
            document.location='index.php';
            </script>";
    }

  }

  else
  {
    //jika tombol simpan diklik
    if (isset($_POST['bsimpan']))
    {

      $simpan = mysqli_query($koneksi, " INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
                                    VALUES ('$_POST[tnama_produk]', 
                                            '$_POST[tketerangan_produk]',
                                           '$_POST[tharga_produk]',
                                           '$_POST[tjumlah_produk]')
                                    
                                      ");

      if ($simpan)
      {
      echo "<script>
          alert('Simpan data sukses!');
          document.location='index.php';
          </script>";
      }
      else
      {
      echo "<script>
          alert('Simpan data gagal!');
          document.location='index.php';
          </script>";
      }
    }

  }
}



//pengujian tombol hapus atau edit
if (isset($_GET['hal']))
{
    //pengujian jika edit data
    if($_GET['hal']=='edit')
    {
      //tampilkan data yang akan diedit
      $tampil= mysqli_query($koneksi, " SELECT * FROM produk WHERE id_produk= '$_GET[id]'" );
      $data = mysqli_fetch_array($tampil);

      if($data){
        //jika data ditemukan maka akan ditampung kedalam variabel
        $vnama_produk = $data['nama_produk'];
        $vketerangan = $data['keterangan'];
        $vharga = $data['harga'];
        $vjumlah = $data['jumlah'];
      }
    }

    //pengujian jika hapus data
    else if($_GET['hal']=='hapus')
    {

      //persiapan hapus data
      $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk= '$_GET[id]' ");

      if($hapus)
      {
        echo "<script>
          alert('Hapus data berhasil!');
          document.location='index.php';
          </script>";
      }
      else
      {
        echo "<script>
          alert('Hapus data gagal!');
          document.location='index.php';
          </script>";

      }

    }
}


?>


<!Doctype html>

<html>
<head>
<title>TOKO ARKADEMY</title>
<link rel = "stylesheet" type="text/css" href = "css/bootstrap.min.css">
</head>

<body>
<div class="container">
<h1 class="text-center">FORM INFROMASI PRODUK</h1>
<h1 class="text-center"> TOKO ARKADEMY </h1>

<!-- Awal Form Card -->
<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Input Data Produk
  </div>
  <div class="card-body">
    <form method="POST" action="">

    <div class="form-group">
    <label> Nama Produk </label>
    <input type="text" name="tnama_produk" class="form-control" value="<?=@$vnama_produk?>" placeholder="Input nama produk anda disini" required>
    </div>

    <div class="form-group">
    <label> Keterangan</label>
    <input type="text" name="tketerangan_produk" class="form-control" value="<?=@$vketerangan?>" placeholder="Input keterangan produk anda disini" required>
    </div>

    <div class="form-group">
    <label> Harga </label>
    <textarea name="tharga_produk" class="form-control" placeholder="Input harga produk anda disini"><?=@$vharga?></textarea>
    </div>

    <div class="form-group">
    <label> Jumlah </label>
    <input type="text" name="tjumlah_produk" class="form-control" value="<?=@$vjumlah?>" placeholder="Input jumlah produk anda disini" required>
    </div>

    <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
    <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

    </form>
  </div>
</div>
<!-- Akhir Form Card -->

<!-- Awal Tabel Card -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Tabel Informasi Produk
  </div>
  <div class="card-body">

  <table class="table table-bordered table-striped">
  <tr>
  <th>No.</th>
  <th>Nama Produk</th>
  <th>Keterangan</th>
  <th>Harga</th>
  <th>Jumlah</th>
  <th>Aksi</th>
  </tr>

  <?php
    $no = 1;
    $tampil = mysqli_query($koneksi, "SELECT * from produk order by id_produk asc");
    while($data=mysqli_fetch_array($tampil)):
  ?>

  <tr>
  <td> <?=$no++;?> </td>
  <td> <?=$data['nama_produk']?> </td>
  <td> <?=$data['keterangan']?> </td>
  <td> <?=$data['harga']?> </td>
  <td> <?=$data['jumlah']?> </td>
  <td>
  <a href="index.php?hal=edit&id=<?=$data['id_produk']?>" class="btn btn-warning">Edit</a>
  <a href="index.php?hal=hapus&id=<?=$data['id_produk']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')"
  class="btn btn-danger">Hapus</a>
  </td>
  </tr>

<?php endwhile;  ?>

  </table>
    
  </div>
</div>
<!-- Akhir Tabel Card -->

</div>
<script type="text/javascript" href = "js/bootstrap.min.js"> </script>
</body>
</html>