<?php 
  include 'koneksi.php';
  session_start();
  //READ NOTES
  $id_user = $_SESSION['id_user'];
  $query_select = "SELECT * FROM notes WHERE id = '$id_user'";
  $data_notes = mysqli_query($connect, $query_select);
?>


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no'>
    <title>Notes</title>
</head>
<body class=''>
    
    <!-- BEGIN LOADER -->
    <div id='load_screen'> <div class='loader'> <div class='loader-content'>
        <div class='spinner-grow align-self-center'></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <?php
        include "komponen/navbar.php";
    ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class='main-container ' id='container'>

        <div class='overlay'></div>
        <div class='cs-overlay'></div>
        <div class='search-overlay'></div>

        <!--  BEGIN SIDEBAR  -->
        <?php
            include "komponen/sidebar.php"
        ?>
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id='content' class='main-content'>
            <div class='layout-px-spacing'>

                <div class='middle-content container-xxl p-0'>
                    
                    <div class='row app-notes layout-top-spacing' id='cancel-row'>
                        <div class='col-lg-12'>
                            <div class='app-hamburger-container'>
                                <div class='hamburger'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-menu chat-menu d-xl-none'><line x1='3' y1='12' x2='21' y2='12'></line><line x1='3' y1='6' x2='21' y2='6'></line><line x1='3' y1='18' x2='21' y2='18'></line></svg></div>
                            </div>
    
                            <div class='app-container'>
                                
                                <div class='app-note-container'>
    
                                    <div class='app-note-overlay'></div>
    
                                    <div class='tab-title'>
                                        <div class='row'>
                                            <div class='col-md-12 col-sm-12 col-12 mb-5'>
                                                <ul class='nav nav-pills d-block' id='pills-tab3' role='tablist'>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions active' id='all-notes'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path></svg> All Notes</a>
                                                    </li>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions' id='note-fav'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon></svg> Favourites</a>
                                                    </li>
                                                </ul>
    
                                                <hr/>
    
                                                <p class='group-section'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-tag'><path d='M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z'></path><line x1='7' y1='7' x2='7' y2='7'></line></svg> Tags</p>
    
                                                <ul class='nav nav-pills d-block group-list' id='pills-tab' role='tablist'>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions g-dot-primary' id='note-personal'>Personal</a>
                                                    </li>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions g-dot-warning' id='note-work'>Work</a>
                                                    </li>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions g-dot-success' id='note-social'>Social</a>
                                                    </li>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions g-dot-danger' id='note-important'>Important</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class='col-md-12 col-sm-12 col-12 text-center'>
                                                <a id='btn-add-notes' class='btn btn-secondary w-100' href='javascript:void(0);'>Add Note</a>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div id='ct' class='note-container note-grid'>

                                    <?php
                                    while ($data = mysqli_fetch_assoc($data_notes)) {
                                    
                                      echo "
                                        <div class='note-item all-notes'>
                                            <div class='note-inner-content'>
                                                <div class='note-content'>
                                                    <p class='note-title' data-noteTitle='$data[judul]'>$data[judul]</p>
                                                    <p class='meta-time'>$data[tanggal]</p>
                                                    <div class='note-description-content'>
                                                        <p class='note-description' data-noteDescription='$data[konten]'>$data[konten]</p>
                                                    </div>
                                                </div>
                                                <div class='note-action'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star fav-note'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon></svg>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2 delete-note'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>
                                                </div>
                                                <div class='note-footer'>
                                                    <div class='tags-selector btn-group'>
                                                        <a class='nav-link dropdown-toggle d-icon label-group' data-bs-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='true'>
                                                            <div class='tags'>
                                                                <div class='g-dot-personal'></div>
                                                                <div class='g-dot-work'></div>
                                                                <div class='g-dot-social'></div>
                                                                <div class='g-dot-important'></div>
                                                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-more-vertical'><circle cx='12' cy='12' r='1'></circle><circle cx='12' cy='5' r='1'></circle><circle cx='12' cy='19' r='1'></circle></svg>
                                                            </div>
                                                        </a>
                                                        <div class='dropdown-menu dropdown-menu-right d-icon-menu'>
                                                            <a class='note-personal label-group-item label-personal dropdown-item position-relative g-dot-personal' href='javascript:void(0);'> Personal</a>
                                                            <a class='note-work label-group-item label-work dropdown-item position-relative g-dot-work' href='javascript:void(0);'> Work</a>
                                                            <a class='note-social label-group-item label-social dropdown-item position-relative g-dot-social' href='javascript:void(0);'> Social</a>
                                                            <a class='note-important label-group-item label-important dropdown-item position-relative g-dot-important' href='javascript:void(0);'> Important</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      ";
                                    }
                                    ?>
    
                                    </div>
    
                                </div>
                                
                            </div>
    
                            <!-- Modal -->
                            <div class='modal fade' id='notesMailModal' tabindex='-1' role='dialog' aria-labelledby='notesMailModalTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title add-title' id='notesMailModalTitleeLabel'>Add Task</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>
                                              <svg aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-x'><line x1='18' y1='6' x2='6' y2='18'></line><line x1='6' y1='6' x2='18' y2='18'></line></svg>
                                            </button>
                                        </div>
                                        
                                        <div class='modal-body'>
                                            <div class='notes-box'>
                                                <div class='notes-content'>  

                                                    <form action='javascript:void(0);' id='notesMailModalTitle'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <div class='d-flex note-title'>
                                                                    <input type='text' id='n-title' class='form-control' maxlength='25' placeholder='Title'>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                            </div>
    
                                                            <div class='col-md-12'>
                                                                <div class='d-flex note-description'>
                                                                    <textarea id='n-description' class='form-control' maxlength='60' placeholder='Description' rows='3'></textarea>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                                <span class='d-inline-block mt-1 text-danger'>Maximum Limit 60 characters</span>
                                                            </div>
                                                        </div>
    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button id='btn-n-save' class='float-left btn'>Save</button>
                                            <button class='btn' data-bs-dismiss='modal'>Discard</button>
                                            <button id='btn-n-add' class='btn btn-primary'>Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
                
            </div>
            
            <!--  BEGIN FOOTER  -->
            <div class='footer-wrapper mt-0'>
                <div class='footer-section f-section-1'>
                    <p class=''>Copyright © <span class='dynamic-year'>2022</span> <a target='_blank' https://designreset.com/equation/'>DesignReset</a>, All rights reserved.</p>
                </div>
                <div class='footer-section f-section-2'>
                    <p class=''>Coded with <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-heart'><path d='M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z'></path></svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->
        
    </div>
    <!-- END MAIN CONTAINER -->
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src='../src/plugins/src/global/vendors.min.js'></script>
    <script src='../src/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js'></script>
    <script src='../src/plugins/src/mousetrap/mousetrap.min.js'></script>
    <script src='../src/plugins/src/waves/waves.min.js'></script>
    <script src='../layouts/vertical-light-menu/app.js'></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src='../src/assets/js/apps/notes.js'></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    
    <!--ACTIVE SIDEBAR -->
    <script>
        var currentURL = window.location.href;
        if (currentURL.indexOf("app-notes.php") !== -1) {
            document.getElementById("app-note").classList.add("active");
        }
    </script>
    <!-- END ACTIVE SIDEBAR -->
    
</body>
</html>