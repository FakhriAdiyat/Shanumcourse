<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css"
    integrity="sha384-nEnU7Ae+3lD52AK+RGNzgieBWMnEfgTbRHIwEvp1XXPdqdO6uLTd/NwXbzboqjc2" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      background-image: url('img/bk.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      height: 100vh;
      color: #fff;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
    }


    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }



    .clock {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 26px;
      animation: fadeIn 1s;
    }

    .login-container {
      margin-top: 100px;
      /* Atur sesuai kebutuhan */
      border-radius: 20px;
      background-color: chocolate;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      animation: slideIn 1s forwards;
      padding: 20px;
      max-width: 1000px;
      color: black;
    }

    .title {
      text-align: center;
      font-size: 36px;
      font-weight: 800;
      animation: fadeIn 3s;
      color: black;
      text-shadow: 2px 2px 0px white;
    }

    .card {
      background-color: rgba(200, 200, 200, 0.5);
    }

    label {
      color: white;
    }

    .main-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: transparent;
      padding: 20px;
      font-family: Arial, sans-serif;
      color: purple;
      height: 100px;
   }

    .main-footer p {
      margin: 0;
      flex: 1;
      text-align: center;
    }

    .main-footer img {
      max-width: 50px; /* Sesuaikan ukuran GIF */
      height: auto;
    }

    .success-icon {
      animation: popIn 0.6s ease-out;
    }

    .spinner-border {
      width: 2.5rem;
      height: 2.5rem;
      border-width: 0.3rem;
    }

    .modal-content {
      animation: fadeIn 1s; /* Animasi muncul modal */
    }

    @keyframes slideIn {
      from {
        transform: translateY(-200%);
      }

      to {
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes popIn {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      50% {
        transform: scale(1.2);
        opacity: 1;
      }
      100% {
        transform: scale(1);
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg w-100">
    <a class="navbar-brand" href="#"><i class="fa-solid fa-book"></i> Online Course</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./../index.php"><i class="fas fa-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./../public/register.php"><i class="fas fa-sign-in"></i></i> Register</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="clock py-5" id="clock"></div>
  <script>
    function updateClock() {
      const now = new Date();
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');
      document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock(); // Initialize clock immediately
  </script>

  <div class="login-container">
          <div class="card">
              <div class="card-header text-center">
                  <h4 class="text-white">Login</h4>
              </div>
              <!-- Tampilkan pesan sukses -->
              <div class="text-center">
                  <?php
                  if (!empty($success)) {
                      echo "<script>document.addEventListener('DOMContentLoaded', function() {
                          $('#successModal').modal('show');
                      });</script>";
                  }
                  ?>
              </div>

              <div class="card-body">
                  <form action="../src/controller/login.php" method="POST" class="form-login">
                      <div class="form-group">
                          <label for="username">Email</label>
                          <input type="text" name="email" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" name="password" class="form-control" required>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block">Login</button>
                  </form>
                  <div class="text-center mt-3">
                      <p>Belum memiliki akun? <b><a href="register.php" class="btn btn-warning">Daftar di
                              sini</a></b></p>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center" style="background-color: #1e1e2f; color: white; border-radius: 15px;">
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center">
                        <!-- GIF Animasi -->
                        <img src="img/scs.gif" alt="Login Success" style="width: 150px; height: auto; margin-bottom: 20px;">
                        <!-- Pesan -->
                        <h4 class="mb-3" style="font-weight: bold;">Berhasil Login!</h4>
                        <p class="mb-4">Mohon tunggu, Anda akan diarahkan ke dashboard...</p>
                        <!-- Spinner -->
                        <div class="spinner-border text-light" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>


    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer.gif" alt="Footer GIF" width="100">
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginSuccess = localStorage.getItem('loginSuccess');
            const redirectUrl = localStorage.getItem('redirectUrl');

            if (loginSuccess === 'true' && redirectUrl) {
                // Tampilkan modal preload
                $('#successModal').modal({
                    backdrop: 'static', // Nonaktifkan klik luar
                    keyboard: false     // Nonaktifkan tombol ESC
                });

                // Hapus data localStorage dan redirect setelah beberapa saat
                setTimeout(function () {
                    localStorage.removeItem('loginSuccess');
                    localStorage.removeItem('redirectUrl');
                    window.location.href = redirectUrl; // Redirect ke dashboard sesuai role
                }, 3000); // 3 detik
            }
        });
    </script>
</body>

</html>