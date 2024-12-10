<?php
include 'db.php';

date_default_timezone_set('Asia/Makassar');

// Fungsi untuk menghitung total dari tabel tertentu
function getTotalFromTableByDate($tableName, $conn, $filterDate)
{
    $query = "SELECT SUM(total) AS total FROM $tableName WHERE DATE(tanggal) = '$filterDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    } else {
        return 0;
    }
}

function getBersihKGFromTableByDate($tableName, $conn, $filterDate)
{
    $query = "SELECT SUM(bersih) AS bersih FROM $tableName WHERE DATE(tanggal) = '$filterDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['bersih'] ? $row['bersih'] : 0;
    } else {
        return 0;
    }
}

function getTotalKGFromTableByDate($tableName, $conn, $filterDate)
{
    $query = "SELECT SUM(berat) AS berat FROM $tableName WHERE DATE(tanggal) = '$filterDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['berat'] ? $row['berat'] : 0;
    } else {
        return 0;
    }
}



$filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : date('Y-m-d');

$totalKgKopi = getTotalKGFromTableByDate('kopi', $conn, $filterDate);
$totalKgKemiri = getTotalKGFromTableByDate('kemiri', $conn, $filterDate);
$totalKgCoklat = getBersihKGFromTableByDate('coklat', $conn, $filterDate);
$totalKgKopra = getBersihKGFromTableByDate('kopra', $conn, $filterDate);
$totalKgMente = getTotalKGFromTableByDate('mente', $conn, $filterDate);

$totalKopi = getTotalFromTableByDate('kopi', $conn, $filterDate);
$totalKemiri = getTotalFromTableByDate('kemiri', $conn, $filterDate);
$totalCoklat = getTotalFromTableByDate('coklat', $conn, $filterDate);
$totalKopra = getTotalFromTableByDate('kopra', $conn, $filterDate);
$totalMente = getTotalFromTableByDate('mente', $conn, $filterDate);

$totalKeseluruhan = $totalKopi + $totalKemiri + $totalCoklat + $totalKopra;

// echo "Waktu sekarang: " . date('Y-m-d H:i:s');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>UD - DEA</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">UD - DEA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Input</div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="coklat.php">
                    <i class="fas fa-seedling"></i>
                    <span>Coklat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kemiri.php">
                    <i class="fas fa-leaf"></i>
                    <span>Kemiri</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kopra.php">
                    <i class="fas fa-tree"></i>
                    <span>Kopra</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kopi.php">
                    <i class="fas fa-coffee"></i>
                    <span>Kopi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mente.php">
                    <i class="fab fa-nutritionix"></i>
                    <span>Mente</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="d-flex flex-column text-gray-500 mr-3">
                                    <span class="font-weight-bold">Welcome, UD - DEA</span>
                                </div>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="Profile Image"
                                    style="width: 35px; height: 35px; object-fit: cover" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div> -->
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate
                            Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <!-- Content Row -->
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="filterDate">Pilih Tanggal:</label>
                            <input type="date" name="filterDate" id="filterDate" class="form-control"
                                value="<?php echo isset($_POST['filterDate']) ? $_POST['filterDate'] : date('Y-m-d'); ?>">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                    <div class="row">
                        <!-- Card for Kopra -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Coklat
                                            </div>
                                            <!-- <div class="row mt-3"> -->
                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                <p class="card-text">Rp
                                                    <?php echo number_format($totalCoklat, 2, ',', '.'); ?>
                                                </p>
                                            </div>
                                            <div>
                                                <div class="mb-0 font-weight-bold text-gray-800">
                                                    <p class="card-text">
                                                        <?php echo number_format($totalKgCoklat, 2, ',', '.'); ?>
                                                        KG
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-seedling fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for Coklat -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kemiri
                                            </div>
                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                <p class="card-text">Rp
                                                    <?php echo number_format($totalKemiri, 2, ',', '.'); ?>
                                                </p>
                                            </div>
                                            <div>
                                                <div class="mb-0 font-weight-bold text-gray-800">
                                                    <p class="card-text">
                                                        <?php echo number_format($totalKgKemiri, 2, ',', '.'); ?>
                                                        KG
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-leaf fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for Kemiri -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Kopra
                                            </div>
                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                <p class="card-text">Rp
                                                    <?php echo number_format($totalKopra, 2, ',', '.'); ?>
                                                </p>
                                            </div>
                                            <div>
                                                <div class="mb-0 font-weight-bold text-gray-800">
                                                    <p class="card-text">
                                                        <?php echo number_format($totalKgKopra, 2, ',', '.'); ?>
                                                        KG
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tree fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Kopi
                                            </div>
                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                <p class="card-text">Rp
                                                    <?php echo number_format($totalKopi, 2, ',', '.'); ?>
                                                </p>
                                            </div>
                                            <div>
                                                <div class="mb-0 font-weight-bold text-gray-800">
                                                    <p class="card-text">
                                                        <?php echo number_format($totalKgKopi, 2, ',', '.'); ?>
                                                        KG
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-coffee fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-primary shadow py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Mente
                                        </div>
                                        <!-- <div class="row mt-3"> -->
                                        <div class="mb-0 font-weight-bold text-gray-800">
                                            <p class="card-text">Rp
                                                <?php echo number_format($totalMente, 2, ',', '.'); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                <p class="card-text">
                                                    <?php echo number_format($totalKgMente, 2, ',', '.'); ?>
                                                    KG
                                                </p>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-auto">
                                        <i class="fab fa-nutritionix fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChart2" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; UD - DEA 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you are ready to end your current session.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">
                            Cancel
                        </button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Data untuk chart Area (Earnings Overview)
            var ctxArea = document.getElementById("myAreaChart2").getContext("2d");
            var myAreaChart = new Chart(ctxArea, {
                type: 'line', // Tipe grafik Area
                data: {
                    labels: ['Kopi', 'Kemiri', 'Coklat', 'Kopra', 'Mente'], // Label untuk x-axis
                    datasets: [{
                        label: 'Total Earnings',
                        data: [<?php echo $totalKopi; ?>, <?php echo $totalKemiri; ?>,
                            <?php echo $totalCoklat; ?>, <?php echo $totalKopra; ?>, <?php echo $totalMente; ?>
                        ], // Data dari PHP
                        backgroundColor: 'rgba(78, 115, 223, 0.05)', // Warna latar belakang area
                        borderColor: 'rgba(78, 115, 223, 1)', // Warna garis
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Data untuk chart Pie (Revenue Sources)
            var ctxPie = document.getElementById("myPieChart2").getContext("2d");
            var myPieChart = new Chart(ctxPie, {
                type: 'pie', // Tipe grafik Pie
                data: {
                    labels: ['Kopi', 'Kemiri', 'Coklat', 'Kopra', 'Mente'], // Label untuk pie chart
                    datasets: [{
                        data: [<?php echo $totalKopi; ?>, <?php echo $totalKemiri; ?>,
                            <?php echo $totalCoklat; ?>, <?php echo $totalKopra; ?>, <?php echo $totalMente; ?>
                        ], // Data dari PHP
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc',
                            '#f6c23e', '#9b59b6'
                        ], // Warna untuk setiap bagian
                        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf',
                            '#e0a100', '#8e44ad'
                        ], // Warna saat hover
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label;
                                    var value = tooltipItem.raw;
                                    return label + ': Rp ' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                        '$&,'); // Menampilkan angka dengan format mata uang
                                }
                            }
                        }
                    }
                }
            });
        </script>


        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>