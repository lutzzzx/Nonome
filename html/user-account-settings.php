<?php
include('koneksi.php');
session_start();

$id_user = $_SESSION['id_user'];
$sqlview = "SELECT * FROM user WHERE id = '$id_user'";
$queryview = mysqli_query($connect, $sqlview);
$row = mysqli_fetch_assoc($queryview);

if (isset($_POST['btnSave'])){
    $id_user   = $_SESSION['id_user'];
    $username  = $_POST['userUpd'];
    $pekerjaan = $_POST['jobUpd'];
    $alamat    = $_POST['addressUpd'];
    $no_hp     = $_POST['nohpUpd'];
    $email     = $_POST['emailUpd'];

    $viewupd  = "SELECT * FROM user WHERE id = '$id_user'";
    $queryupd = mysqli_query($connect, $viewupd);
    $col      = mysqli_fetch_assoc($queryupd);

    $updateUpload   = $col['foto'];

    if (!empty($_FILES['fotoUpd']['name'])){
        $updatePhoto    = $_FILES['fotoUpd']['name'];
        $updateUpload   = 'photo-profile/'.$updatePhoto;
        move_uploaded_file($_FILES['fotoUpd']['tmp_name'], $updateUpload);      
    }

    $sqlupd = "UPDATE user SET foto = '$updateUpload', username = '$username', alamat ='$alamat', pekerjaan ='$pekerjaan', email = '$email', no_hp='$no_hp' WHERE id = '$id_user'";
    $queryupd = mysqli_query($connect, $sqlupd);

    if ($queryupd) {
        header("location: user-profile.php");
    } else {
        echo "Gagal melakukan pembaruan: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Account Settings | EQUATION - Multipurpose Bootstrap Dashboard Template </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico"/>
    <link href="../layouts/vertical-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/vertical-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" href="../src/plugins/src/filepond/filepond.min.css">
    <link rel="stylesheet" href="../src/plugins/src/filepond/FilePondPluginImagePreview.min.css">
    <link href="../src/plugins/src/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../src/plugins/src/sweetalerts2/sweetalerts2.css">
    
    <link href="../src/plugins/css/light/filepond/custom-filepond.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/light/components/tabs.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../src/assets/css/light/elements/alert.css">
    
    <link href="../src/plugins/css/light/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/light/notification/snackbar/custom-snackbar.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../src/assets/css/light/forms/switches.css">
    <link href="../src/assets/css/light/components/list-group.css" rel="stylesheet" type="text/css">

    <link href="../src/assets/css/light/users/account-setting.css" rel="stylesheet" type="text/css" />



    <link href="../src/plugins/css/dark/filepond/custom-filepond.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/components/tabs.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../src/assets/css/dark/elements/alert.css">
    
    <link href="../src/plugins/css/dark/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../src/plugins/css/dark/notification/snackbar/custom-snackbar.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../src/assets/css/dark/forms/switches.css">
    <link href="../src/assets/css/dark/components/list-group.css" rel="stylesheet" type="text/css">

    <link href="../src/assets/css/dark/users/account-setting.css" rel="stylesheet" type="text/css" />

    <link href="../layouts/vertical-light-menu/css/dark/structure-mod.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/vertical-light-menu/css/light/structure-mod.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>
<body class="">
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <a href="javascript:void(0);" class="sidebarCollapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </a>

            <div class="search-animated toggle-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x search-close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </div>
                </form>
                <span class="badge badge-secondary">Ctrl + /</span>
            </div>

            <ul class="navbar-item flex-row ms-lg-auto ms-0">

                

                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    </a>
                </li>

                

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                            <img alt="avatar" src="<?= $row['foto']; ?>" class="rounded-circle">
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5><?php echo $row['username']; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="user-profile.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="app-mailbox.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>Inbox</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="auth-boxed-lockscreen.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="./index.html">
                                <img src="../src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="./index.html" class="nav-link"> Equation </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">
                        <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                            <li>
                                <a href="./index.html"> Analytics </a>
                            </li>
                            <li>
                                <a href="./index2.html"> Sales </a>
                            </li>
                            <li>
                                <a href="./index3.html"> Real Estate </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>

                    <li class="menu">
                        <a href="./app-calendar.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>Calendar</span>
                            </div>
                        </a>
                    </li>
                    


                    <li class="menu">
                        <a href="./app-todoList.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>Todo List</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./app-notes.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span>Notes</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="./app-contacts.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Contacts</span>
                            </div>
                        </a>
                    </li>

                    
                    
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!-- BREADCRUMB -->
                    
                    <!-- /BREADCRUMB -->
                        
                    <div class="account-settings-container layout-top-spacing">
    
                        <div class="account-content">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h2>Settings</h2>

                                    
                                </div>
                            </div>
    
                            <div class="tab-content" id="animateLineContent-4">
                                <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                            <form class="section general-info" method="POST" enctype="multipart/form-data">
                                                <div class="info">
                                                    <h6 class="">General Information</h6>
                                                    <div class="row">
                                                        <div class="col-lg-11 mx-auto">
                                                            <div class="row">
                                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                                    <div class="profile-image  mt-4 pe-md-4">

                                                                        <!-- // The classic file input element we'll enhance
                                                                        // to a file pond, we moved the configuration
                                                                        // properties to JavaScript -->

                                                                    
                                                                            <img id="fotoEdit" src="<?= $row['foto']; ?>" style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover;" alt="Upload Foto">
                                                        
                                                                            <input style="margin-top: 15px; margin-left: -15px;" type="file" id="c-photo" name="fotoUpd" class="form-control" accept=".jpg, .png, .jpeg">
                                                                        
                                                    
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                                    <div class="form">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="fullName">Full Name</label>
                                                                                    <input type="text" name="userUpd" class="form-control mb-3" id="fullName" placeholder="Full Name" value="<?= $row['username']; ?>">
                                                                                </div>
                                                                            </div>
            
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="profession">Profession</label>
                                                                                    <input type="text" name="jobUpd" class="form-control mb-3" id="profession" placeholder="Profession" value="<?= $row['pekerjaan']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="address">Address</label>
                                                                                    <input type="text" name="addressUpd" class="form-control mb-3" id="address" placeholder="Address" value="<?= $row['alamat']; ?>" >
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="phone">Phone</label>
                                                                                    <input type="text" name="nohpUpd" class="form-control mb-3" id="phone" placeholder="Write your phone number here" value="<?= $row['no_hp']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="email">Email</label>
                                                                                    <input type="text" name="emailUpd" class="form-control mb-3" id="email" placeholder="Write your email here" value="<?= $row['email']; ?>">
                                                                                </div>
                                                                            </div>                                    
    
                                                                           
    
                                                                            <div class="col-md-12 mt-1">
                                                                                <div class="form-group text-end">
                                                                                    <button class="btn btn-secondary" name="btnSave">Save</button>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
            

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info payment-info">
                                                <div class="info">
                                                    <h6 class="">Billing Address</h6>
                                                    <p>Changes to your <span class="text-success">Billing</span> information will take effect starting with scheduled payment and will be refelected on your next invoice.</p>
    
                                                    <div class="list-group mt-4">
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress1" checked>
                                                                    </div>
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">Address #1</div>
                                                                    <p>2249 Caynor Circle, New Brunswick, New Jersey</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                       
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress2">
                                                                    </div>
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">Address #2</div>
                                                                    <p>4262 Leverton Cove Road, Springfield, Massachusetts</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="billingAddress" id="billingAddress3">
                                                                    </div>
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">Address #3</div>
                                                                    <p>2692 Berkshire Circle, Knoxville, Tennessee</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
    
                                                    <button class="btn btn-secondary mt-4 add-address">Add Address</button>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info payment-info">
                                                <div class="info">
                                                    <h6 class="">Payment Method</h6>
                                                    <p>Changes to your <span class="text-success">Payment Method</span> information will take effect starting with scheduled payment and will be refelected on your next invoice.</p>
    
                                                    <div class="list-group mt-4">
                                                        
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod1">
                                                                    </div>
                                                                </div>
                                                                <div class="payment-card">
                                                                    <img src="../src/assets/img/card-mastercard.svg" class="align-self-center me-3" alt="americanexpress">
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">Mastercard</div>
                                                                    <p>XXXX XXXX XXXX 9704</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod2" checked>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-card">
                                                                    <img src="../src/assets/img/card-americanexpress.svg" class="align-self-center me-3" alt="americanexpress">
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">American Express</div>
                                                                    <p>XXXX XXXX XXXX 310</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <label class="list-group-item">
                                                            <div class="d-flex w-100">
                                                                <div class="billing-radio me-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMethod3">
                                                                    </div>
                                                                </div>
                                                                <div class="payment-card">
                                                                    <img src="../src/assets/img/card-visa.svg" class="align-self-center me-3" alt="americanexpress">
                                                                </div>
                                                                <div class="billing-content">
                                                                    <div class="fw-bold">Visa</div>
                                                                    <p>XXXX XXXX XXXX 5264</p>
                                                                </div>
                                                                <div class="billing-edit align-self-center ms-auto">
                                                                    <button class="btn btn-dark">Edit</button>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
    
                                                    <button class="btn btn-secondary mt-4 add-payment">Add Payment Method</button>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info payment-info">
                                                <div class="info">
                                                    <h6 class="">Add Billing Address</h6>
                                                    <p>Changes your New <span class="text-success">Billing</span> Information.</p>
    
                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" class="form-control add-billing-address-input">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Address</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">City</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Country</label>
                                                                <select class="form-select">
                                                                    <option selected="">Choose...</option>
                                                                    <option value="united-states">United States</option>
                                                                    <option value="brazil">Brazil</option>
                                                                    <option value="indonesia">Indonesia</option>
                                                                    <option value="turkey">Turkey</option>
                                                                    <option value="russia">Russia</option>
                                                                    <option value="india">India</option>
                                                                    <option value="germany">Germany</option>
                                                                </select>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">ZIP</label>
                                                                <input type="tel" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <button class="btn btn-primary mt-4">Add</button>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info payment-info">
                                                <div class="info">
                                                    <h6 class="">Add Payment Method</h6>
                                                    <p>Changes your New <span class="text-success">Payment Method</span> Information.</p>
    
                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Card Brand</label>
                                                                <div class="invoice-action-currency">
                                                                    <div class="dropdown selectable-dropdown cardName-select">
                                                                        <a id="cardBrandDropdown" href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../src/assets/img/card-mastercard.svg" class="flag-width" alt="flag"> <span class="selectable-text">Mastercard</span> <span class="selectable-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span></a>
                                                                        <div class="dropdown-menu" aria-labelledby="cardBrandDropdown">
                                                                            <a class="dropdown-item" data-img-value="../src/assets/img/card-mastercard.svg" data-value="GBP - British Pound" href="javascript:void(0);"><img src="../src/assets/img/card-mastercard.svg" class="flag-width" alt="flag"> Mastercard</a>
                                                                            <a class="dropdown-item" data-img-value="../src/assets/img/card-americanexpress.svg" data-value="IDR - Indonesian Rupiah" href="javascript:void(0);"><img src="../src/assets/img/card-americanexpress.svg" class="flag-width" alt="flag"> American Express</a>
                                                                            <a class="dropdown-item" data-img-value="../src/assets/img/card-visa.svg" data-value="USD - US Dollar" href="javascript:void(0);"><img src="../src/assets/img/card-visa.svg" class="flag-width" alt="flag"> Visa</a>
                                                                            <a class="dropdown-item" data-img-value="../src/assets/img/card-discover.svg" data-value="INR - Indian Rupee" href="javascript:void(0);"><img src="../src/assets/img/card-discover.svg" class="flag-width" alt="flag"> Discover</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                         <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Card Number</label>
                                                                <input type="text" class="form-control add-payment-method-input">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Holder Name</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">CVV/CVV2</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Card Expiry</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <button class="btn btn-primary mt-4">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
    
                                <div class="tab-pane fade" id="animated-underline-preferences" role="tabpanel" aria-labelledby="animated-underline-preferences-tab">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Choose Theme</h6>
                                                    <div class="d-sm-flex justify-content-around">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                              <img class="ms-3" width="100" height="68" alt="settings-dark" src="../src/assets/img/settings-light.svg">
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                <img class="ms-3" width="100" height="68" alt="settings-light" src="../src/assets/img/settings-dark.svg">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-6 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Activity data</h6>
                                                    <p>Download your Summary, Task and Payment History Data</p>
                                                    <div class="form-group mt-4">
                                                        <button class="btn btn-primary">Download Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Public Profile</h6>
                                                    <p>Your <span class="text-success">Profile</span> will be visible to anyone on the network.</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="publicProfile" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Show my email</h6>
                                                    <p>Your <span class="text-success">Email</span> will be visible to anyone on the network.</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="showMyEmail">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Enable keyboard shortcuts</h6>
                                                    <p>When enabled, press <code class="text-success">ctrl</code> for help</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="EnableKeyboardShortcut">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Hide left navigation</h6>
                                                    <p>Sidebar will be <span class="text-success">hidden</span> by default</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="hideLeftNavigation">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Advertisements</h6>
                                                    <p>Display <span class="text-success">Ads</span> on your dashboard</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="advertisements">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Social Profile</h6>
                                                    <p>Enable your <span class="text-success">social</span> profiles on this network</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-secondary mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="socialprofile" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="animated-underline-contact" role="tabpanel" aria-labelledby="animated-underline-contact-tab">
                                    <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                        <strong>Warning!</strong> Please proceed with caution. For any assistance - <a href="javascript:void(0);">Contact Us</a>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Purge Cache</h6>
                                                    <p>Remove the active resource from the cache without waiting for the predetermined cache expiry time.</p>
                                                    <div class="form-group mt-4">
                                                        <button class="btn btn-secondary btn-clear-purge">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Deactivate Account</h6>
                                                    <p>You will not be able to receive messages, notifications for up to 24 hours.</p>
                                                    <div class="form-group mt-4">
                                                        <div class="switch form-switch-custom switch-inline form-switch-success mt-1">
                                                            <input class="switch-input" type="checkbox" role="switch" id="socialformprofile-custom-switch-success">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-12 col-md-12 layout-spacing">
                                            <div class="section general-info">
                                                <div class="info">
                                                    <h6 class="">Delete Account</h6>
                                                    <p>Once you delete the account, there is no going back. Please be certain.</p>
                                                    <div class="form-group mt-4">
                                                        <button class="btn btn-danger btn-delete-account">Delete my account</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>

                </div>

            </div>

            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" https://designreset.com/equation/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
            
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-light-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="../src/plugins/src/filepond/filepond.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="../src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="../src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script>
    <script src="../src/plugins/src/notification/snackbar/snackbar.min.js"></script>
    <script src="../src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <script src="../src/assets/js/users/account-settings.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
        $("#uploadButton").on("click", function() {
            $("#c-photo").trigger("click");
         });

</script>


        
</script>
</body>
</html>