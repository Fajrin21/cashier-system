<?php

include 'db.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['harga'])) {
    $harga = str_replace(['Rp', '.', ' '], '', $_POST['harga']); // Menghapus "Rp", titik, dan spasi
    $berat = floatval($_POST['berat']);
    $total = str_replace(['Rp', '.', ' '], '', $_POST['Total']); // Bersihkan juga Total
    $tanggal = $_POST['tanggal'];

    if (empty($harga) || empty($berat) || empty($total) || empty($tanggal)) {
        $error_message = 'Semua field harus diisi!';
    } else {
        $stmt = $conn->prepare("INSERT INTO kemiri (harga, berat, total, tanggal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('idis', $harga, $berat, $total, $tanggal);

        if ($stmt->execute()) {
            // Setelah berhasil simpan, kembalikan URL PDF
            $stmt->close();
            $conn->close();

            // URL generator PDF
            $pdf_url = "kemiri-fpdf.php?harga=$harga&berat=$berat&total=$total&tanggal=$tanggal";
            echo json_encode(['success' => true, 'url' => $pdf_url]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data!']);
            exit;
        }
    }
}

// Handle POST request untuk menghapus data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM kemiri WHERE id = ?");
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        $success_message = 'Data berhasil dihapus!';
    } else {
        $error_message = 'Gagal menghapus data: ' . $stmt->error;
    }
    $stmt->close();
}

// Ambil data untuk ditampilkan di tabel
$result = $conn->query("SELECT * FROM kemiri ORDER BY id DESC");
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all']) && $_POST['delete_all'] === 'true') {
    $sql = "DELETE FROM kemiri";

    if ($conn->query($sql) === TRUE) {
        header('Location: kemiri.php');
    } else {
        header('Location: kemiri.php');
    }
    $conn->close();
    exit;
}

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

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
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
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Input</div>

            <!-- Nav Item - Tables -->
            <li class="nav-item ">
                <a class="nav-link" href="coklat.php">
                    <i class="fas fa-seedling"></i>
                    <span>Coklat</span>
                </a>
            </li>
            <li class="nav-item active">
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
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Tabel Data Kemiri
                            </h6>
                            <div class="ml-auto d-flex">
                                <!-- Form Hapus Semua Data -->
                                <form method="POST" class="mr-2">
                                    <input type="hidden" name="delete_all" value="true">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus Semua Data
                                    </button>
                                </form>

                                <!-- Button Tambah Data -->
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#inputModal">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Harga</th>
                                            <th>Berat (KG)</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($data) > 0): ?>
                                            <?php foreach ($data as $index => $item): ?>
                                                <tr>
                                                    <td><?= $index + 1; ?></td>
                                                    <td><?= 'Rp ' . number_format($item['harga'], 0, ',', '.'); ?></td>
                                                    <td><?= htmlspecialchars($item['berat']); ?> Kg</td>
                                                    <td><?= 'Rp ' . number_format($item['total'], 0, ',', '.'); ?></td>
                                                    <td><?= htmlspecialchars($item['tanggal']); ?></td>
                                                    <td>
                                                        <form method="POST" onsubmit="return confirmDelete(this);">
                                                            <input type="hidden" name="delete_id" value="<?= $item['id']; ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Input -->
                <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="inputModalLabel">
                                    Input Data kemiri
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" id="kemiriForm">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control" id="harga" name="harga" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat">Berat (KG)</label>
                                        <input type="number" class="form-control" id="berat" name="berat" required
                                            step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="Total">Total</label>
                                        <input type="text" class="form-control" id="Total" name="Total" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('kemiriForm').addEventListener('submit', async function(e) {
                        e.preventDefault(); // Cegah form dari pengiriman default

                        const formData = new FormData(this);

                        try {
                            const response = await fetch(this.action, {
                                method: 'POST',
                                body: formData,
                            });

                            const result = await response.json();

                            if (result.success) {
                                // Buka tab baru dengan URL PDF
                                window.open(result.url, '_blank');

                                // Reload halaman utama setelah tab baru dibuka
                                window.location.reload();
                            } else {
                                alert(result.message || 'Terjadi kesalahan!');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Gagal mengirim data!');
                        }
                    });
                    <?php if ($success_message): ?>
                        Swal.fire('Sukses', '<?= $success_message; ?>', 'success');
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                        Swal.fire('Gagal', '<?= $error_message; ?>', 'error');
                    <?php endif; ?>

                    function confirmDelete(form) {
                        Swal.fire({
                            title: 'Yakin ingin menghapus data?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                        return false;
                    }
                </script>

                <script>
                    $(document).ready(function() {
                        const today = new Date();
                        const localDate = today.toLocaleDateString('en-CA'); // Format YYYY-MM-DD
                        $("#tanggal").val(localDate);
                    });
                    $(document).ready(function() {
                        $("#berat, #potongan").on("input", function() {
                            const berat = parseFloat($("#berat").val()) || 0;
                            const potongan = parseFloat($("#potongan").val()) || 0;
                            const bersih = berat - potongan;
                            $("#bersih").val(bersih);

                            const harga =
                                parseFloat(
                                    $("#harga")
                                    .val()
                                    .replace(/[^0-9]/g, "")
                                ) || 0;
                            const total = harga * bersih;
                            $("#Total").val(formatRupiah(total.toString(), "Rp"));
                        });

                        $("#harga").on("keyup", function() {
                            this.value = formatRupiah(this.value, "Rp");
                        });
                    });

                    function formatRupiah(value, prefix) {
                        const numberString = value.replace(/[^,\d]/g, "").toString();
                        const split = numberString.split(",");
                        const sisa = split[0].length % 3;
                        let rupiah = split[0].substr(0, sisa);
                        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        if (ribuan) {
                            const separator = sisa ? "." : "";
                            rupiah += separator + ribuan.join(".");
                        }

                        rupiah =
                            split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
                        return prefix === undefined ?
                            rupiah :
                            rupiah ?
                            "Rp " + rupiah :
                            "";
                    }

                    $(document).ready(function() {
                        $("#harga").on("keyup", function() {
                            this.value = formatRupiah(this.value, "Rp");
                        });

                        $("#inputForm").on("submit", function(event) {
                            event.preventDefault();

                            const hargaInput = $("#harga")
                                .val()
                                .replace(/[^0-9]/g, "");
                            console.log("Harga tanpa format:", hargaInput);

                            const formData = $(this).serializeArray();
                            formData.find((field) => field.name === "harga").value =
                                hargaInput;

                            console.log("Form data:", formData);

                            $(this)[0].reset();
                            $("#inputModal").modal("hide");
                        });
                    });
                </script>
            </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>