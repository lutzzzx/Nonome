<?php
include("koneksi.php");
session_start();

if (isset($_POST['btnLogin'])){
  $email    = $_POST['inpEmail'];
  $password = $_POST['inpPass'];
  $hash     = md5($password);
 // $ingat    = $_POST['remember'];

  $sql    = "SELECT * FROM user WHERE email = '$email' AND password = '$hash'";
  $query  = mysqli_query($connect, $sql);
  $result = mysqli_fetch_assoc($query);
  
  if ($result['email']===$email && $result['password']===$hash){
    $_SESSION['id_user'] = $result['id'];
    
    if ($ingat == 1){
      $cookie_name  = "cookie_email";
      $cookie_value = $email;
      $cookie_time  = time() + (60*60*24*30);
      setcookie($cookie_name, $cookie_value, $cookie_time,"/");

      $cookie_password = "cookie_password";
      $cookie_value    = md5($password);
      $cookie_time     = time() + (60*60*24*30);
      setcookie($cookie_password, $cookie_value, $cookie_time,"/");
    }
    header("location: index.php");

  } else {
    ?>
    <script>alert('Username atau Password salah!');</script>;
    <?php
  }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign In</title>
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
                <p class="lead">Login to your account</p>
              </div>
              <div class="body">
                <form class="form-auth-small" method="POST">
                  <div class="form-group">
                    <label for="signin-email" class="control-label sr-only"
                      >Email</label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="signin-email"
                      name="inpEmail"
                      placeholder="Email"
                    />
                  </div>
                  <div class="form-group">
                    <label for="signin-password" class="control-label sr-only"
                      >Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="signin-password"
                      name="inpPass"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group clearfix">
                    <label class="fancy-checkbox element-left">
                      <input type="checkbox" name="remember"/>
                      <span>Remember me</span>
                    </label>
                  </div>
                  <button
                    type="submit"
                    class="btn btn-primary btn-lg btn-block"
                    name="btnLogin"
                  >
                    LOGIN
                  </button>
                  <div class="bottom">
                    <span class="helper-text m-b-10"
                      ><i class="fa fa-lock"></i>
                      <a href="auth-forgot-password.html"
                        >Forgot password?</a
                      ></span
                    >
                    <span
                      >Don't have an account?
                      <a href="auth-boxed-signup.php">Register</a></span
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
