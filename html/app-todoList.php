<?php
include('koneksi.php');
session_start();

$id_user = $_SESSION['id_user'];

if (!isset($_SESSION['id_user'])) {
    header("Location: auth-boxed-signin.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$view    = "SELECT * FROM todo WHERE id_user = '$id_user'";
$queryv  = mysqli_query($connect, $view);

if (isset($_POST['addTask-btn'])){
    $taskName = $_POST['taskName'];
    $taskDesc = $_POST['taskDesc'];
    $deadline = $_POST['deadline'];

    $sql   = "INSERT INTO todo (id_user, judul, deskripsi, deadline) VALUES ('$id_user',
                                                                             '$taskName',
                                                                             '$taskDesc',
                                                                             '$deadline')";
    $query = mysqli_query($connect, $sql);

    if ($query) {
        header('Location: app-todoList.php');
        exit();
    } else {
        die('Error: ' . mysqli_error($connect));
    }
}
?>
<?php
    if (isset($_POST['updTask-btn'])){
        $taskId   = $_POST['idTaskUpd'];
        $taskName = $_POST['taskUpdName'];
        $taskDesc = $_POST['taskUpdDesc'];
        $deadline = $_POST['deadlineUpd'];

        $sqlupdate = "UPDATE todo SET judul = '$taskName', 
                                  deskripsi = '$taskDesc',
                                  deadline  = '$deadline' 
                                   WHERE id = '$taskId'";

        $queryupd  = mysqli_query($connect, $sqlupdate);
        header("location: app-todoList.php");
    }
?>
<?php
    if (isset($_POST['delTask'])){
        $idTask = $_POST['idTaskdel'];

        $sqldel    = "DELETE FROM todo WHERE id = '$idTask'";
        $queryddel = mysqli_query($connect, $sqldel);
        header("location: app-todoList.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Todo List</title>
</head>
<body class="layout-boxed ">
    
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
    
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12">
    
                            <div class="mail-box-container">
                                <div class="mail-overlay"></div>
    
                                <div class="tab-title">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-12 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                            <h5 class="app-title">Todo List</h5>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-12 ps-0">
                                            <div class="todoList-sidebar-scroll mt-4">
                                                <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link list-actions active" id="all-list" data-toggle="pill" href="#pills-inbox" role="tab" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg> Task <span class="todo-badge badge"></span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link list-actions" id="todo-task-done" data-toggle="pill" href="#pills-sentmail" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg> Done <span class="todo-badge badge"></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-12">
                                        <a class="btn btn-secondary" id="addTask" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> New Task</a>
                                        </div>
                                    </div>
                                </div>
    
                                <div id="todo-inbox" class="accordion todo-inbox">
                                    <div class="search">
                                        <input type="text" class="form-control input-search" placeholder="Search Task...">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    </div>

                                    
                                    <div class="todo-box">
                                        <div id="ct" class="todo-box-scroll">
                                        <?php while ($row = mysqli_fetch_assoc($queryv)){ ?>
                                        <div class="todo-item all-list">
                                            <div class="todo-item-inner">
                                                <div class="n-chk text-center">
                                                    <div class="form-check form-check-primary form-check-inline mt-1 me-0" data-bs-toggle="collapse" data-bs-target>
                                                        <input data data-dead="<?= $row['deadline']; ?>" id="<?php echo $row['id']; ?>" class="form-check-input inbox-chkbox" type="checkbox">
                                                    </div>
                                                </div>

                                                <div class="todo-content" 
                                                       data-id     = "<?= $row['id']; ?>"
                                                       data-title  = "<?= $row['judul']; ?>"
                                                       data-desc   = "<?= $row['deskripsi']; ?>"
                                                       data-dead   = "<?= $row['deadline']; ?>">
                                                    <a class="todoClick"></a>
                                                    <h5 class="todo-heading" data-todoHeading=""><?php echo $row['judul']; ?></h5>
                                                </div>
                                                <div class="action-dropdown custom-dropdown-icon">
                                                    <div style="display: flex; flex-direction: row;">
                                                    <h6 style="margin-right: 15px; white-space: nowrap; margin-top: 5px;">(<?php echo $row['deadline']; ?>)</h6>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                        </a>

                                                        <div class="dropdown-menu left" aria-labelledby="dropdownMenuLink-2">
                                                            
                                                            <a class="edit dropdown-item" id="taskEdit"
                                                                data-id     = "<?= $row['id']; ?>"
                                                                data-title  = "<?= $row['judul']; ?>"
                                                                data-desc   = "<?= $row['deskripsi']; ?>"
                                                                data-deadl  = "<?= $row['deadline']; ?>"
                                                            >Edit</a>
                                                            
                                                            <a class="dropdown-item delete" id="taskDel"
                                                                data-id = "<?= $row['id']; ?>"
                                                            >Delete</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        } ?>

                                    <!-- Modal View -->
                                        <div class="modal fade" id="todoShowListItem" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <input type="hidden" id="idTask">
                                                    <h5 id="taskHeader" class="task-heading modal-title mb-0"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="compose-box">
                                                        <div class="compose-content">
                                                            <p id="taskDesc" class="task-text"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>                                   
    
                                </div>                                    
                            </div>
    
                            <!-- Modal Insert -->
                            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title add-title" id="addTaskModalTitleLabel1">Add Task</h5>
                                            <h5 class="modal-title edit-title" id="addTaskModalTitleLabel2" style="display: none;">Edit Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <div class="compose-box">
                                                <div class="compose-content" id="addTaskModalTitle">
                                                    <form method="POST">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="d-flex mail-to mb-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 flaticon-notes"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                                    <div class="w-100">
                                                                        <input type="text" id="task" placeholder="Task" class="form-control" name="taskName" required>
                                                                        <span class="validation-text"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="d-flex  mail-subject">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text flaticon-menu-list"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                            <div class="w-100">
                                                                <div class="">
                                                                    <textarea class="form-control" id="taskdescription" name="taskDesc" cols="30" rows="10" placeholder="Description" required></textarea>
                                                                </div>
                                                                <input class="form-control" style="margin-top: 15px;" type="date" name="deadline">
                                                                <span class="validation-text"></span>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-" data-bs-dismiss="modal" value="Discard">
                                            <input class="btn add-tsk btn-primary" type="submit" value="Add Task" name="addTask-btn">
                                            <input class="btn edit-tsk btn-success" type="submit" value="Save" name="updTask-btn"">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal delete -->
                            <div class="modal fade" id="addContactModalDelete" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title add-title" id="addContactModalTitleLabel1" style="display: none;">Add Contact</h5>
                                                        <h5 class="modal-title edit-title" id="addContactModalTitleLabel2">Delete Task</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <div id="modal-delete" class="modal-body">
                                                        <div class="add-contact-box">
                                                            <div class="add-contact-content">
                                                            <form method="POST">
                                                            <input id="deleteTask" type="hidden" name="idTaskdel">
                                                            <p>Anda yakin untuk menghapus Tugas ini?</p>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="modal-footer">
                                                                <Input name="delTask" id="btn-del" class="btn btn-warning" type="submit" data-bs-dismiss="modal" value="Delete"> <i class="flaticon-delete-1"></i>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                            
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title add-title" id="addTaskModalTitleLabel1" >Add Task</h5>
                                            <h5 class="modal-title edit-title" id="addTaskModalTitleLabel2" style="display: none;">Edit Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <div class="compose-box">
                                                <div class="compose-content" id="addTaskModalTitle">
                                                    <form method="POST">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="d-flex mail-to mb-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 flaticon-notes"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                                    <div class="w-100">
                                                                        <input type="hidden" name="idTaskUpd" id="idTaskUpd">
                                                                        <input type="text" id="judulTask" placeholder="Task" class="form-control" name="taskUpdName">
                                                                        <span class="validation-text"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="d-flex  mail-subject">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text flaticon-menu-list"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                            <div class="w-100">
                                                                <div class="deskripsi">
                                                                    <textarea class="form-control" id="taskdescription" name="taskUpdDesc" cols="30" rows="10" placeholder="Description"></textarea>
                                                                </div>
                                                                <div class="deadlineupdate">
                                                                <input type="date" id="dateUpdate" class="form-control" style="margin-top: 15px;" name="deadlineUpd">
                                                                </div>
                                                                <span class="validation-text"></span>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input class="btn btn-" type="submit" data-bs-dismiss="modal" value="Discard">
                                            <input class="btn add-tsk btn-primary" type="submit" value="Add Task" name="addTask-btn">
                                            <input class="btn edit-tsk btn-success" type="submit" value="Save" name="updTask-btn"">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> 
            </div>
            
            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper mt-0">
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="../src/plugins/src/global/vendors.min.js"></script>
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../src/plugins/src/waves/waves.min.js"></script>
    <script src="../layouts/vertical-light-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    <script src="../src/plugins/src/editors/quill/quill.js"></script>
    <script src="../src/assets/js/apps/todoList.js"></script>

    <script>
        var currentURL = window.location.href;
        if (currentURL.indexOf("app-todoList.php") !== -1) {
            document.getElementById("app-todoList").classList.add("active");
        }
    </script>
</body>
</html>