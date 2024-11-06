<?php
session_start();
include 'db.php';

// Handle mahasiswa registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_mahasiswa'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Check if the username already exists
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $error = "Username atau email sudah terdaftar!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Insert new mahasiswa into the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, role, email) VALUES ('$username', '$hashed_password', 'mahasiswa', '$email')";
        
        if ($conn->query($query) === TRUE) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Terjadi kesalahan saat registrasi!";
        }
    }
}



// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Debugging: Print username and stored hash for verification
        echo 'Username: ' . $username . '<br>';
        echo 'Stored Hash: ' . $user['password'] . '<br>';

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Debugging: Check session values
            echo 'Session set: ' . $_SESSION['user_id'] . ' with role ' . $_SESSION['role'] . '<br>';

            // Redirect based on role
            if ($user['role'] == 'mahasiswa') {
                header('Location: dashboard_mahasiswa.php');
            } elseif ($user['role'] == 'admin') {
                header('Location: dashboard_admin.php');
            } elseif ($user['role'] == 'kajur') {
                $_SESSION['dosen_id'] = $user['dosen_id'];  // Store dosen_id in session for kajur
                header('Location: dashboard_kajur.php');
            } elseif ($user['role'] == 'wakil_dekan') {
                $_SESSION['wakil_dekan_id'] = $user['wakil_dekan_id']; // Store wakil_dekan_id in session
                header('Location: dashboard_wadek.php');
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Pengguna tidak ditemukan!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUDISMA - Surat Dispensasi Mahasiswa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <!-- Title Section -->
            <div class="col-md-6 d-flex flex-column align-items-start text-white mb-4 mb-md-0">
                <h1 class="display-4 font-weight-bold">S U D I S M A</h1>
                <p class="lead">Surat Dispensasi Mahasiswa</p>
                <img src="image/image.png" alt="Illustration of a student working at a desk" class="img-fluid mt-3 rounded shadow-sm custom-img-shift">
            </div>
            
            <!-- Login / Register Form Section -->
            <div class="col-md-6">
                <div class="card p-4 shadow-lg">
                    <h2 class="card-title mb-3">Selamat Datang di Aplikasi SUDISMA!</h2>
                    <p class="text-muted">Silakan login untuk masuk ke aplikasi</p>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif (isset($success)) : ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form id="loginForm" action="" method="POST">
                        <div class="form-group">
                            <label for="username" class="text-dark">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    </form>

                    <hr>

                    <!-- Display registration link only if not logged in -->
                    <?php if (!isset($_SESSION['user_id'])) : ?>
                        <p class="text-muted" id="registerText">Belum punya akun? <a href="javascript:void(0);" id="toRegisterMahasiswa">Daftar sebagai Mahasiswa</a></p>
                    <?php endif; ?>

                    <!-- Mahasiswa Registration Form -->
                    <div id="registerMahasiswaForm" class="d-none">
                        
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="registerUsername" class="text-dark">Username</label>
                                <input type="text" id="registerUsername" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="registerEmail" class="text-dark">Email</label>
                                <input type="email" id="registerEmail" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="registerPassword" class="text-dark">Password</label>
                                <input type="password" id="registerPassword" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="registerConfirmPassword" class="text-dark">Konfirmasi Password</label>
                                <input type="password" id="registerConfirmPassword" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" name="register_mahasiswa" class="btn btn-success btn-block">Register Mahasiswa</button>
                        </form>
                        
                        <!-- Change register link to login when on register form -->
                        <p class="text-muted mt-3" id="backToLoginText">Sudah punya akun? <a href="javascript:void(0);" id="toLogin">Login</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Switch to Mahasiswa Registration Form
            $('#toRegisterMahasiswa').click(function() {
                $('#loginForm').addClass('d-none');
                $('#registerMahasiswaForm').removeClass('d-none');
                $('#registerText').addClass('d-none'); // Hide the 'Daftar sebagai Mahasiswa' link
            });

            // Switch back to Login Form from Registration Form
            $('#toLogin').click(function() {
                $('#registerMahasiswaForm').addClass('d-none');
                $('#loginForm').removeClass('d-none');
                $('#registerText').removeClass('d-none'); // Show the 'Belum punya akun?' link again
            });
        });
    </script>
</body>
</html>
