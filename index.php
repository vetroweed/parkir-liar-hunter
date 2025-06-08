<?php
session_start();
include 'conn/koneksi.php';

// Tangani proses login sebelum HTML
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password']));

    $sql = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($sql);
    $data = mysqli_fetch_assoc($sql);

    $sql2 = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
    $cek2 = mysqli_num_rows($sql2);
    $data2 = mysqli_fetch_assoc($sql2);

    if ($cek > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['data'] = $data;
        $_SESSION['level'] = 'masyarakat';
        header('Location: masyarakat/');
        exit;
    } elseif ($cek2 > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['data'] = $data2;
        if ($data2['level'] == "admin") {
            header('Location: admin/');
            exit;
        }
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/favicon2.ico" type="image/x-icon">
    <title>WEB - Parkir Liar Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-4">
        <?php
        include 'conn/koneksi.php';
        $page = $_GET['p'] ?? 'login';

        if ($page === "login") {
            include_once 'login.php';
        } elseif ($page === "logout") {
            include_once 'logout.php';
        }
        ?>
    </div>

</body>

</html>
