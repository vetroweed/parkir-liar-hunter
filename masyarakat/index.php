<?php
session_start();
error_reporting(0);
include '../conn/koneksi.php';
if (!isset($_SESSION['username'])) {
  header('location:../index.php');
  exit(); // Added exit to prevent further execution
} elseif ($_SESSION['level'] != "masyarakat") {
  header('location:../index.php');
  exit(); // Added exit to prevent further execution
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../img/favicon2.ico" type="image/x-icon">
  <link rel="shortcut icon" href="../img/favicon2.ico" type="image/x-icon">
  <title>Parkir Liar Hunter</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
          }
        }
      }
    }
  </script>
  <script>
    $(document).ready(function () {
      $('#example').DataTable();
    });
  </script>
</head>

<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <!-- Sidebar Desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 bg-white border-r border-gray-200">
        <div class="flex flex-col items-center justify-center h-16 border-b border-gray-200 m-4">
          <img src="../img/logo3.png" alt="Logo Desa" class="h-16 object-contain ">
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
          <div class="flex items-center mb-8">
            <img class="w-12 h-12 rounded-full" src="../img/profil.jpg" alt="User avatar">
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-700">
                <?php echo htmlspecialchars(ucwords($_SESSION['data']['nama'])); ?>
              </p>
              <p class="text-xs text-gray-500">Masyarakat</p>
            </div>
          </div>
          <nav class="flex-1 space-y-2">
            <a href="index.php?p=dashboard"
              class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200">
              <i class="fas fa-tachometer-alt mr-3"></i>
              Dashboard
            </a>
            <div class="border-t border-gray-200 my-2"></div>
            <a href="../index.php?p=logout"
              class="flex items-center px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-gray-200">
              <i class="fas fa-sign-out-alt mr-3"></i>
              Logout
            </a>
          </nav>
        </div>
      </div>
    </div>

    <!-- Mobile sidebar -->
    <!-- Mobile sidebar -->
    <div class="md:hidden fixed inset-0 z-40 hidden" id="mobile-sidebar">
      <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
      <div class="relative flex flex-col w-full max-w-xs bg-white">
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
          <span class="text-lg font-semibold text-gray-700">Menu</span>
          <button class="text-gray-500 hover:text-gray-600" onclick="toggleMobileSidebar()">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
          <div class="flex items-center mb-8">
            <img class="w-10 h-10 rounded-full" src="../img/profil.jpg" alt="User avatar">
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-700">
                <?php echo htmlspecialchars(ucwords($_SESSION['data']['nama'])); ?>
              </p>
            </div>
          </div>
          <nav class="flex-1 space-y-2">
            <a href="index.php?p=dashboard"
              class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200">
              <i class="fas fa-tachometer-alt mr-3"></i>
              Dashboard
            </a>
            <a href="index.php?p=pengaduan"
              class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200">
              <i class="fas fa-exclamation-circle mr-3"></i>
              Buat Pengaduan
            </a>
            <div class="border-t border-gray-200 my-2"></div>
            <a href="../index.php?p=logout"
              class="flex items-center px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-gray-200">
              <i class="fas fa-sign-out-alt mr-3"></i>
              Logout
            </a>
          </nav>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="flex flex-col flex-1 overflow-hidden">
      <!-- Mobile header -->
      <!-- Mobile header -->
      <header class="md:hidden bg-white shadow">
        <div class="flex items-center justify-between h-16 px-4">
          <button class="text-gray-500 hover:text-gray-600" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i>
          </button>
          <img src="../img/logo2.png" alt="Logo Desa" class="h-8">
          <div class="w-8"></div>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4">
        <?php
        if (@$_GET['p'] == "" || @$_GET['p'] == "dashboard") {
          include_once 'dashboard.php';
        } elseif (@$_GET['p'] == "pengaduan_hapus") {
          $id_pengaduan = mysqli_real_escape_string($koneksi, $_GET['id_pengaduan']);
          $query = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");

          if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if ($data['foto'] != 'noImage.png') {
              unlink('../img/' . $data['foto']);
            }

            if ($data['status'] == "proses") {
              $delete = mysqli_query($koneksi, "DELETE FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");
              if ($delete) {
                ob_end_clean();
                header('location:index.php?p=dashboard');
                exit();
              }
            } elseif ($data['status'] == "selesai") {
              $delete = mysqli_query($koneksi, "DELETE FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");
              if ($delete) {
                $delete2 = mysqli_query($koneksi, "DELETE FROM tanggapan WHERE id_pengaduan='$id_pengaduan'");
                if ($delete2) {
                  ob_end_clean();
                  header('location:index.php?p=dashboard');
                  exit();
                }
              }
            }
          }
        } elseif (@$_GET['p'] == "more") {
          include_once 'more.php';
        }
        ?>
      </main>
    </div>
  </div>

  <script>
    function toggleMobileSidebar() {
      const sidebar = document.getElementById('mobile-sidebar');
      sidebar.classList.toggle('hidden');
    }
  </script>
</body>

</html>
