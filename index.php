<?php
    //koneksi db
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "pendataan";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

    if(isset($_POST['bsave']))
    {
        //Pengujian Edit
        if($_GET['hal'] == "edit")
        {
        
            $edit = mysqli_query($koneksi, "UPDATE pedagang set kode = '$_POST[tkode]',
                                                                nama = '$_POST[tnama]',
                                                                produk = '$_POST[tproduk]',
                                                                jp = '$_POST[tjp]'
                                                            WHERE id = '$_GET[id]'
                                                            ");


            if($edit)
            {
                echo "<script>
                alert('Edit data sukses!');
                document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('Edit data GAGAL!!!');
                document.location='index.php';
                </script>";
            }
        }
        else
        {
            //data akan disimpan ulang
        

        $simpan = mysqli_query($koneksi, "INSERT INTO pedagang (kode, nama, produk, jp)
                                          VALUES ('$_POST[tkode]', '$_POST[tnama]', '$_POST[tproduk]', '$_POST[tjp]')
        ");
        if($simpan)
        {
            echo "<script>
                  alert('Simpan data sukses!');
                  document.location='index.php';
                  </script>";
        }
        else
        {
            echo "<script>
            alert('Simpan data GAGAL!!!');
            document.location='index.php';
            </script>";
        }
    }
}
    //edit atau hapus
    if(isset($_GET['hal']))
    {
        //pengujian edit data
        if($_GET['hal'] == "edit")
        {
            //menampilkan data
            $tampil = mysqli_query($koneksi, "SELECT * from pedagang WHERE id = '$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan
                $vkode = $data['kode'];
                $vnama = $data['nama'];
                $vproduk = $data['produk'];
                $vjp = $data['jp'];
            }
        }
        else if($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE from pedagang WHERE id = '$_GET[id]'");
            if($hapus)
            {
                echo "<script>
                alert('Hapus data Sukses!');
                document.location='index.php';
                </script>";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAS CRUD</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>
    <div class="container">
    <h1 class="text-center">UAS Crud</h1>
    <h3 class="text-center">Pendataan Usaha</h3>

<!-- Card Form -->
    <div class="card mt-5">
  <div class="card-header bg-primary text-white">
    Form Input Data Pedagang
  </div>
  <div class="card-body">
    <form method="POST" action="">
        <div class="form-group">
            <label>Kode Lahan</label>
            <input type="text" name="tkode" value="<?=@$vkode?>" class="form-control" placeholder="masukkan kode anda" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="masukkan nama usaha anda" required>
        </div>
        <div class="form-group">
            <label>Produk Yang Ditawarkan</label>
            <input type="text" name="tproduk" value="<?=@$vproduk?>" class="form-control" placeholder="masukkan produk anda" required>
        </div>
        <div class="form-group">
            <label>Jenis Produk</label>
            <select class="form-control" name="tjp" >
                <option value="<?=@$vjp?>"><?=@$vjp?></option>
                <option value="Makanan & Minuman">Makanan & Minuman</option>
                <option value="ATK">Alat Tulis Kantor</option>
                <option value="Jasa">Jasa</option>
                <option value="Perabot">Peralatan Rumah</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" name="bsave">Simpan</button>
        <button type="reset" class="btn btn-danger" name="breset">Reset</button>

    </form>
  </div>
</div>
<!-- Card Form -->

<!-- Card Table -->
<div class="card mt-5">
  <div class="card-header bg-success text-white">
    Daftar Pedagang
  </div>
  <div class="card-body">
    
    <table class="table table-bordered table-stripped">
        <tr>
            <th>No.</th>
            <th>Kode Lahan</th>
            <th>Nama</th>
            <th>Produk Yang Ditawarkan</th>
            <th>Jenis Produk</th>
            <th>Aksi</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from pedagang order by id desc");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['kode']?></td>
            <td><?=$data['nama']?></td>
            <td><?=$data['produk']?></td>
            <td><?=$data['jp']?></td>
            <td>
                <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
            <?php endwhile; //penutup pengulangan while ?>
    </table>

  </div>
</div>
<!-- Card Table -->

</div>
    <script type="text/javascript" src="js/bootstrap.min.js></script>
</body>
</html>