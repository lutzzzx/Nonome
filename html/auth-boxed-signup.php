<?php
include("koneksi.php");

if (isset($_POST['regisbtn'])){
  $username = $_POST['inpUser'];
  $email    = $_POST['inpEmail'];
  $password = $_POST['inpPass'];
  $hash = md5($password);

  $sql    = "SELECT * FROM user WHERE email = '$email'";
  $query  = mysqli_query($connect, $sql);
  $check  = mysqli_num_rows($query);

  if ($check > 0){
    ?>
    <script>
      alert("Email telah terdaftar");
    </script>"; 
    <?php
  } else {
      $sqlins   = "INSERT INTO user (username, email, password) VALUES ('$username','$email','$hash')";
      $queryins = mysqli_query($connect, $sqlins);
      echo "<script>
              alert('Registrasi Success');
              window.location.href = 'auth-boxed-signin.php';
            </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign Up</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template" />
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../src/bootstrap/css/bootstrap.min-2.css" />
    <link
      rel="stylesheet"
      href="../src/font-awesome/css/font-awesome.min.css"
    />

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../src/assets/css/light/auth.css" />
  </head>

  <body data-theme="light" class="font-nunito">
    <!-- WRAPPER -->
    <div id="wrapper" class="theme-cyan">
      <div class="vertical-align-wrap">
        <div class="vertical-align-middle auth-main">
          <div class="auth-box">
            <div class="top">
              <h2>NOTES</h2>
            </div>
            <div class="card">
              <div class="header">
                <p class="lead">Create an account</p>
              </div>
              
              <div id="myModal" class="modal">
                <div class="modal-content">
                  <span class="close">&times;</span>
                    <p>This username is already registered. Please choose another one.</p>
                  </div>
              </div>

              <div class="body">
                <form class="form-auth-small" method="POST">
                  <div class="form-group">
                    <label for="signup-name" class="control-label sr-only"
                      >Name</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="signup-name"
                      name="inpUser"
                      placeholder="Username"
                    />
                  </div>
                  <div class="form-group">
                    <label for="signup-email" class="control-label sr-only"
                      >Email</label
                    >
                    <input
                      type="email"
                      class="form-control"
                      id="signup-email"
                      name="inpEmail"
                      placeholder="Your email"
                    />
                  </div>
                  <div class="form-group">
                    <label for="signup-password" class="control-label sr-only"
                      >Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="signup-password"
                      name="inpPass"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group">
                    <label for="signup-password" class="control-label sr-only"
                      >Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="signup-password"
                      placeholder="Confirm password"
                    />
                  </div>
                  <button
                    type="submit"
                    class="btn btn-primary btn-lg btn-block"
                    name="regisbtn"
                  >
                    REGISTER
                  </button>
                  <div class="bottom">
                    <span class="helper-text"
                      >Already have an account?
                      <a href="auth-boxed-signin.php">Login</a></span
                    >
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END WRAPPER -->
  </body>
</html>
