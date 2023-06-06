<?php
// koneksi ke DBMS
$conn = mysqli_connect("localhost","root","","phpdasar2");

// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])) {
    // ambil data dari tiap elemen dalam form
    $nrp = htmlspecialchars($_POST["nrp"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $jurusan = htmlspecialchars($_POST["jurusan"]);
    $gambar = htmlspecialchars($_POST["gambar"]);

    // query insert data
    $query = "INSERT INTO mahasiswa (nrp,nama,email,jurusan,gambar)
                VALUES (
                '$nrp',
                '$nama',
                '$email',
                '$jurusan',
                '$gambar'
                )";
    mysqli_query($conn, $query);

    // cek apakah data berhasil ditambahkan atau tidak
    if(mysqli_affected_rows($conn) > 0) {
        echo " 
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else { 
        echo " 
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamabh data mahasiswa</title>
</head>
<body>
    
    <form action="" method="post">
        <ul>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required>
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="text" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah data!</button>
            </li>
        </ul>
    </form>


</body>
</html>