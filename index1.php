<?php
include 'koneksi.php';

// Variable awal untuk form
$id = "";
$nis = "";
$nama = "";
$jurusan = "";
$is_edit = false;

// 1. PROSES TAMBAH DATA (INSERT)
if (isset($_POST['simpan'])) {
    $nis     = $_POST['nis'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, jurusan) VALUES ('$nis', '$nama', '$jurusan')");
    header("Location: index.php");
}

// 2. PROSES HAPUS DATA (DELETE)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'");
    header("Location: index.php");
}

// 3. PERSIAPAN EDIT DATA (Ambil data ke form)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $is_edit = true;
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);

    $nis     = $data['nis'];
    $nama    = $data['nama'];
    $jurusan = $data['jurusan'];
}

// 4. PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id      = $_POST['id'];
    $nis     = $_POST['nis'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "UPDATE siswa SET nis='$nis', nama='$nama', jurusan='$jurusan' WHERE id='$id'");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana Data Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; width: 350px; }
        input[type=text] { width: 100%; padding: 8px; margin: 5px 0 15px 0; box-sizing: border-box; }
        button { padding: 8px 15px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        .btn-update { background-color: #ffc107; color: black; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; padding: 4px 8px; color: white; border-radius: 3px; font-size: 12px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-hapus { background-color: #dc3545; }
    </style>
</head>
<body>

    <h2>Aplikasi Data Siswa (CRUD Sederhana)</h2>

    <!-- FORM INPUT / EDIT -->
    <form method="POST" action="">
        <h3><?= $is_edit ? "Edit Data Siswa" : "Tambah Data Siswa"; ?></h3>
        
        <input type="hidden" name="id" value="<?= $id; ?>">

        <label>NIS:</label>
        <input type="text" name="nis" value="<?= $nis; ?>" required>

        <label>Nama Siswa:</label>
        <input type="text" name="nama" value="<?= $nama; ?>" required>

        <label>Jurusan:</label>
        <input type="text" name="jurusan" value="<?= $jurusan; ?>" required>

        <?php if ($is_edit): ?>
            <button type="submit" name="update" class="btn-update">Perbarui Data</button>
            <a href="index.php" style="color: black; margin-left: 10px;">Batal</a>
        <?php else: ?>
            <button type="submit" name="simpan">Simpan Data</button>
        <?php endif; ?>
    </form>

    <!-- TABEL TAMPIL DATA (READ) -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC");
            while ($d = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $d['nis']; ?></td>
                <td><?= $d['nama']; ?></td>
                <td><?= $d['jurusan']; ?></td>
                <td>
                    <a href="index.php?edit=<?= $d['id']; ?>" class="btn-edit">Edit</a>
                    <a href="index.php?hapus=<?= $d['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
