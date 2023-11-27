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
    <?php
        include "komponen/navbar.php";
    ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php
            include "komponen/sidebar.php"
        ?>
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