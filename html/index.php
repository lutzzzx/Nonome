<?php
include 'koneksi.php';
session_start();

$id_user = $_SESSION['id_user'];

if (!isset($_SESSION['id_user'])) {
    header("Location: auth-boxed-signin.php");
    exit();
}
$data_notes = mysqli_query($connect, "SELECT * FROM notes WHERE id_user=$id_user ORDER BY tanggal DESC LIMIT 9");
$data_todo = mysqli_query($connect,"SELECT * FROM todo WHERE id_user = '$id_user'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>EQUATION Admin - Multipurpose Bootstrap Dashboard Template </title>
</head>
<body class="layout-boxed">
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
    <div class="main-container" id="container">

        <div class="overlay"></div>
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

                    <div class="row layout-top-spacing">

                        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-chart-three">
                                <div class="widget-heading">
                                    <div class="">
                                        <h5 class="">Notes</h5>
                                    </div>

                                    <div class="task-action">
                                        <div class="dropdown ">
                                            <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
    
                                            <div class="dropdown-menu left" aria-labelledby="uniqueVisitors">
                                                <a class="dropdown-item" href="app-notes.php">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="widget-content">
                                <div id='ct' class='note-container note-grid mb-3'>  
                                        <div class="note-container">    
                                        <?php
                                        while ($data = mysqli_fetch_assoc($data_notes)) {
                                        $tanggal_format = date('d/m/Y', strtotime($data['tanggal']));
                                        $favorite = "";
                                        if ($data['favorite'] == true) {
                                            $favorite = "note-fav";
                                        }  
                                        $data_tags = mysqli_query($connect, "SELECT tags.* FROM tags JOIN tag_note ON tags.id = tag_note.tag_id WHERE tag_note.note_id = $data[id] AND tag_note.id_user=$id_user");
                                        echo "
                                            <div class='note-item all-notes $favorite'>
                                                <div class='note-inner-content'>
                                                    <a class='tampilkanModal' data-idnote='$data[id]'>
                                                        <div class='note-content'>
                                                            <p class='note-title' data-noteTitle='$data[judul]'>$data[judul]</p>
                                                            <p class='meta-time'>$tanggal_format</p>
                                                            <div class='note-description-content'>
                                                                <p class='note-description' data-noteDescription='$data[konten]'>$data[konten]</p>
                                                            </div>
                                                        </div>
                                                    </a>";
                                                    while ($tag_data = mysqli_fetch_assoc($data_tags)) {
                                                      echo "<span class='badge rounded-pill text-bg-light'>#$tag_data[name]</span> ";
                                                    }
                                                    echo "
                                                </div>
                                            </div>
                                        ";
                                        }
                                        ?>
                                        </div>  
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                            <div class="widget widget-activity-five">

                                <div class="widget-heading">
                                    <h5 class="">Todo List</h5>

                                    <div class="task-action">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="activitylog" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>

                                            <div class="dropdown-menu left" aria-labelledby="activitylog" style="will-change: transform;">
                                                <a class="dropdown-item" href="app-todoList.php">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="widget-content">

                                    <div class="w-shadow-top"></div>

                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            
                                        <?php
                                            while ($data = mysqli_fetch_assoc($data_todo)) {
                                                echo "
                                                <div class='item-timeline timeline-new'>
                                                    <div class='t-dot'>
                                                        <div class='t-secondary'></div>
                                                    </div>
                                                    <div class='t-content'>
                                                        <div class='t-uppercontent'>
                                                            <h5>$data[judul]</h5>
                                                        </div>
                                                        <p>$data[deadline]</p>
                                                    </div> 
                                                </div>  
                                                ";
                                            }
                                        ?>
                                 
                                        </div>                                    
                                    </div>

                                    <div class="w-shadow-bottom"></div>
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

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../src/plugins/src/apex/apexcharts.min.js"></script>
    <script src="../src/assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->]

    <!--ACTIVE SIDEBAR -->
    <script>
        var currentURL = window.location.href;
        if (currentURL.indexOf("index.php") !== -1) {
            document.getElementById("index").classList.add("active");
        }
    </script>
    <!-- END ACTIVE SIDEBAR -->
</body>
</html>