<?php 
  include 'koneksi.php';

  session_start();

  $id_user = $_SESSION['id_user'];

  if (!isset($_SESSION['id_user'])) {
      header("Location: auth-boxed-signin.php");
      exit();
  }

  //READ NOTES
  $data_tags = mysqli_query($connect, "SELECT * FROM tags WHERE id_user=$id_user");
  $edit_note = false;
  $edit_tag = false;

    if (isset($_POST['fav_id'])) {
        $id = $_POST['fav_id'];
        $stmt_select= mysqli_query($connect, "SELECT favorite FROM notes WHERE id=$id AND id_user=$id_user");
        $data = mysqli_fetch_assoc($stmt_select);
        $new_favorite = ($data['favorite'] == 1) ? 0 : 1;
        $stmt_update = mysqli_query($connect, "UPDATE notes SET favorite=$new_favorite WHERE id=$id");
    }
    
    if (isset($_POST['addnote'])) {
        $judul = $_POST['judul'];
        $konten = $_POST['konten'];
        $tags = isset($_POST['tags']) ? json_decode($_POST['tags']) : array();
        $tags = array_map('intval', $tags);
        $stmt_insert = mysqli_query($connect, "INSERT INTO notes(judul, konten, id_user) VALUES ('$judul', '$konten', '$id_user')");
        $note_id = mysqli_insert_id($connect);
        if (isset($_POST['tags'])) {
            foreach($tags as $tag_id) {
                $stmt_insert_tags = mysqli_query($connect, "INSERT INTO tag_note(note_id, tag_id, id_user) VALUES ('$note_id', '$tag_id', '$id_user')");
            }
        }
    }

    if (isset($_POST['editnote'])) {
      $id = $_POST['id'];
      $judul = $_POST['judul'];
      $konten = $_POST['konten'];
      $tags = isset($_POST['tags']) ? json_decode($_POST['tags']) : array();
      $tags = array_map('intval', $tags);
      $stmt_delete_tags = mysqli_query($connect, "DELETE FROM tag_note WHERE note_id = '$id'");
      $stmt_update = mysqli_query($connect, "UPDATE notes SET judul='$judul', konten='$konten' WHERE id='$id' AND id_user='$id_user'");
      if (isset($_POST['tags'])) {
          foreach($tags as $tag_id) {
              $stmt_insert_tags = mysqli_query($connect, "INSERT INTO tag_note(note_id, tag_id, id_user) VALUES ('$id', '$tag_id', '$id_user')");
          }
      }
    }
    if (isset($_GET['delete_tag'])) {
      $id = $_GET['delete_tag'];
      $stmt_delete = mysqli_query($connect, "DELETE FROM tags WHERE id=$id");
      $stmt_delete_tags = mysqli_query($connect, "DELETE FROM tag_note WHERE tag_id=$id");
      header("Location: b.php");
    }
    if (isset($_GET['editTagId'])) {
      $id = $_GET['editTagId'];
      $stmt_select_edit = mysqli_query($connect, "SELECT * FROM tags WHERE id=$id");
      $data_tag_edit = mysqli_fetch_assoc($stmt_select_edit);
      $edit_tag = true;
    }
    if (isset($_POST['edittag'])) {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $stmt_insert = mysqli_query($connect, "UPDATE tags SET name='$name' WHERE id='$id' AND id_user='$id_user'");
    }


    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt_delete = mysqli_query($connect, "DELETE FROM notes WHERE id=$id");
        $stmt_delete_tags = mysqli_query($connect, "DELETE FROM tag_note WHERE note_id=$id");
    }
    if (isset($_GET['editNoteId'])) {
        $id = $_GET['editNoteId'];
        $stmt_select_edit = mysqli_query($connect, "SELECT * FROM notes WHERE id=$id");
        $data_note_edit = mysqli_fetch_assoc($stmt_select_edit);
    
        $tags_query = mysqli_query($connect, "SELECT tag_id FROM tag_note WHERE note_id=$id");
        $tags = array();
        while ($tag = mysqli_fetch_assoc($tags_query)) {
            $tags[] = $tag['tag_id'];
        }
        $edit_note = true;
    }
    
    if (isset($_POST['addtag'])) {
      $name = $_POST['name'];
      $stmt_insert = mysqli_query($connect, "INSERT INTO tags(name, id_user) VALUES ('$name', '$id_user')");
    }

    if (isset($_POST['tag_select'])) {
        $tag_id = $_POST['tag_select'];
        $data_name_tag = mysqli_query($connect, "SELECT * FROM tags WHERE id=$tag_id");
        $name_tag = mysqli_fetch_assoc($data_name_tag);
        if ($tag_id == 000) {
            $data_notes = mysqli_query($connect, "SELECT * FROM notes WHERE id_user=$id_user ORDER BY tanggal DESC");
        } else {
            $data_notes = mysqli_query($connect, "SELECT notes.* FROM notes
            JOIN tag_note ON notes.id = tag_note.note_id
            WHERE tag_note.tag_id = $tag_id AND tag_note.id_user=$id_user
            ORDER BY notes.tanggal DESC");
        }

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
                        <a href='#' class='tampilkanModal' data-idnote='$data[id]'>
                            <div class='note-content'>
                                <p class='note-title' data-noteTitle='$data[judul]'>$data[judul]</p>
                                <p class='meta-time'>$tanggal_format</p>
                                <div class='note-description-content'>
                                    <p class='note-description' data-noteDescription='$data[konten]'>$data[konten]</p>
                                </div>
                            </div>
                        </a>
                        <div class='note-action'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star fav-note' onclick='toggleFavorite($data[id])'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon></svg>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2 delete-note' onclick='toggleDelete($data[id])'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>
                        </div> <br> ";
                        while ($tag_data = mysqli_fetch_assoc($data_tags)) {
                          echo "<span class='badge rounded-pill text-bg-light'>#$tag_data[name]</span> ";
                        }
                        echo "
                    </div>
                </div>
              ";
            }
        exit;
    }
    $data_notes = mysqli_query($connect, "SELECT * FROM notes WHERE id_user=$id_user ORDER BY tanggal DESC");
    
?>


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no'>
    <title>Notes | EQUATION - Multipurpose Bootstrap Dashboard Template </title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                                                <div class='col-md-12 col-sm-12 col-12 text-center'>
                                                    <a id='btn-add-notes' class='btn btn-primary w-100' href='javascript:void(0);'>Add Note</a>
                                                </div>
                                                <hr/>
                                                <ul class='nav nav-pills d-block' id='pills-tab3' role='tablist'>
                                                    <li class='nav-item'>
                                                        <a onclick='toggleTag(000)' class='nav-link list-actions active' id='all-notes'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path></svg> All Notes</a>
                                                    </li>
                                                    <li class='nav-item'>
                                                        <a class='nav-link list-actions' id='note-fav'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon></svg> Favourites</a>
                                                    </li>
                                                </ul>
                                                <p class='group-section'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-tag'><path d='M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z'></path><line x1='7' y1='7' x2='7' y2='7'></line></svg> Tags</p>
                                              
                                                <div class='col-md-12 col-sm-12 col-12 text-center mb-3'>
                                                    <a id='btn-show-tag' class='btn btn-secondary w-100' href='javascript:void(0);'>Add Tag</a>
                                                </div>
    
                                                 <?php
                                                while ($data = mysqli_fetch_assoc($data_tags)) {
                                                    if ($data != "") {
                                                    echo "
                                                    <ul class='nav nav-pills d-block group-list' id='pills-tab' role='tablist'>
                                                        <li class='nav-item'>
                                                            <a class='nav-link list-actions g-dot-success' id='all-notes' onclick='toggleTag($data[id])'>$data[name]</a> 
                                                        <div class='btn-group mb-2 mt-1 d-flex text-center'>
                                                            <button class='btn btn-outline-dark btn-sm dropdown-toggle w-50' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                Aksi <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'><polyline points='6 9 12 15 18 9'></polyline></svg>
                                                            </button>
                                                            <div class='dropdown-menu'>
                                                                <a href='#' id='tampilkanEditTag' data-idtag='$data[id]' class='dropdown-item'>Edit</a>
                                                                <a href='b.php?delete_tag=$data[id]' class='dropdown-item'>Hapus</a>
                                                            </div>
                                                        </div>
                                                        
                                                        </li>
                                                    </ul> ";
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div id='ct' class='note-container note-grid'>  
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
                                                    <a href='#' class='tampilkanModal' data-idnote='$data[id]'>
                                                        <div class='note-content'>
                                                            <p class='note-title' data-noteTitle='$data[judul]'>$data[judul]</p>
                                                            <p class='meta-time'>$tanggal_format</p>
                                                            <div class='note-description-content'>
                                                                <p class='note-description' data-noteDescription='$data[konten]'>$data[konten]</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class='note-action mb-3'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star fav-note' onclick='toggleFavorite($data[id])'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon></svg>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2 delete-note' onclick='toggleDelete($data[id])'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg>
                                                    </div> <br> ";
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


                            <!-- Modal -->
                            <div class='modal fade' id='notesMailModal' tabindex='-1' role='dialog' aria-labelledby='notesMailModalTitle' aria-modal='true'>
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
                                                                    <input name='judul' type='text' id='n-title' class='form-control' maxlength='50' placeholder='Title'>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                            </div>
    
                                                            <div class='col-md-12'>
                                                                <div class='d-flex note-description'>
                                                                    <textarea name='konten' id='n-description' class='form-control' maxlength='300' placeholder='Description' rows='7'></textarea>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                                <span class='d-inline-block mt-1 text-danger'>Maximum Limit 300 characters</span><br><br>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <select id="select-state" name="state[]" multiple placeholder="Tags" autocomplete="off">>
                                                                    <?php
                                                                    $data_tags = mysqli_query($connect, "SELECT * FROM tags WHERE id_user=$id_user");
                                                                    while ($data = mysqli_fetch_assoc($data_tags)) {
                                                                        echo "
                                                                            <option value='$data[id]'>$data[name]</option>
                                                                        ";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' data-bs-dismiss='modal'>Discard</button>
                                            <button id='btn-n-add' class='btn btn-primary' onclick='submitForm()'>Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                                                    
                            <!-- Modal Edit Note -->
                            <div class='modal fade' id='editNoteModal' tabindex='-1' role='dialog' aria-labelledby='notesMailModalTitle' aria-modal='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title add-title' id='notesMailModalTitleeLabel'>Edit Note</h5>
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
                                                                    <input type="hidden" id="edit-note-id" value="<?php if($edit_note) echo $data_note_edit['id'] ?>">
                                                                    <input name='judul' type='text' id='edit-note-title' class='form-control' maxlength='50' placeholder='Title' value="<?php if($edit_note) echo $data_note_edit['judul'] ?>">
                                                                </div>
                                                                <span class='validation-text'></span>
                                                            </div>
    
                                                            <div class='col-md-12'>
                                                                <div class='d-flex note-description'>
                                                                    <textarea name='konten' id='edit-note-description' class='form-control' maxlength='300' placeholder='Description' rows='7'><?php if($edit_note) echo $data_note_edit['konten'] ?></textarea>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                                <span class='d-inline-block mt-1 text-danger'>Maximum Limit 300 characters</span><br><br>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <select id="select-state-edit" name="state[]" multiple placeholder="Tags" autocomplete="off">>
                                                                    <?php
                                                                      if($edit_note) {
                                                                        $data_tags = mysqli_query($connect, "SELECT * FROM tags WHERE id_user=$id_user");
                                                                        while ($data = mysqli_fetch_assoc($data_tags)) {
                                                                            $selected = in_array($data['id'], $tags) ? 'selected' : '';
                                                                            echo "<option value='$data[id]' $selected>$data[name]</option>";
                                                                        }
                                                                      }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' data-bs-dismiss='modal'>Discard</button>
                                            <button id='btn-n-edit' class='btn btn-primary' onclick='submitFormEdit()' >Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal tambah Tag -->
                            <div class='modal fade' id='addTagModal' tabindex='-1' role='dialog' aria-labelledby='notesMailModalTitle' aria-modal='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title add-title' id='notesMailModalTitleeLabel'>Add Tag</h5>
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
                                                                    <input name='judul' type='text' id='tag-name' class='form-control' maxlength='50' placeholder='Name Tag'>
                                                                </div>
                                                                <span class='validation-text'></span>
                                                            </div>
                                                        </div>
    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' data-bs-dismiss='modal'>Discard</button>
                                            <button id='btn-add-tag' class='btn btn-primary' onclick='submitTag()'>Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            

                            <!-- Modal Edit Tag -->
                            <div class='modal fade' id='editTagModal' tabindex='-1' role='dialog' aria-labelledby='notesMailModalTitle' aria-modal='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title add-title' id='notesMailModalTitleeLabel'>Edit Tag</h5>
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
                                                                    <input type="hidden" name="" id='edit-tag-id' value="<?php if($edit_tag) echo $data_tag_edit['id'] ?>">
                                                                    <input name='judul' type='text' id='edit-tag-name' class='form-control' maxlength='50' placeholder='Name Tag' value="<?php if($edit_tag) echo $data_tag_edit['name'] ?>">
                                                                </div>
                                                                <span class='validation-text'></span>
                                                            </div>
                                                        </div>
    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' data-bs-dismiss='modal'>Discard</button>
                                            <button id='btn-edit-tag' class='btn btn-primary' onclick='submitEditTag()'>Save</button>
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
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="../src/assets/js/scrollspyNav.js"></script>
    <script src="../src/plugins/src/tomSelect/tom-select.base.js"></script>
    <script src="../src/plugins/src/tomSelect/custom-tom-select.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    
    <!--ACTIVE SIDEBAR -->
    <script>
        var currentURL = window.location.href;
        if (currentURL.indexOf("app-notes.php") !== -1) {
            document.getElementById("app-note").classList.add("active");
        }
    </script>
    <!-- END ACTIVE SIDEBAR -->

    <!--AJAX REQUEST ADD NOTE -->
    <script>
        function submitForm() {
            event.preventDefault();
            var judul = document.getElementById('n-title').value;
            var konten = document.getElementById('n-description').value;
            var selectedTags = [];
            var selectElement = document.getElementById('select-state');
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedTags.push(selectElement.options[i].value);
                }
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload()
                }
            };
            
            xhr.send("addnote=add" + "&judul=" + encodeURIComponent(judul) + "&konten=" + encodeURIComponent(konten) + "&tags=" + encodeURIComponent(JSON.stringify(selectedTags)));
        }
    </script>
     <!-- END AJAX REQUEST ADD NOTE -->
         <!--AJAX REQUEST EDIT NOTE -->
    <script>
        function submitFormEdit(event) {
            if (event) {
                event.preventDefault();
            }
            var id = document.getElementById('edit-note-id').value;
            var judul = document.getElementById('edit-note-title').value;
            var konten = document.getElementById('edit-note-description').value;
            var selectedTags = [];
            var selectElement = document.getElementById('select-state-edit');
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedTags.push(selectElement.options[i].value);
                }
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload()
                }
            };
            
            xhr.send("editnote=edit" + "&id=" + encodeURIComponent(id) + "&judul=" + encodeURIComponent(judul) + "&konten=" + encodeURIComponent(konten) + "&tags=" + encodeURIComponent(JSON.stringify(selectedTags)));
        }
        $("#btn-n-edit").on("click", function (event) {
          event.preventDefault();
          $("#editNoteModal").modal("hide");
          submitFormEdit(event);
        });
    </script>
     <!-- END AJAX REQUEST EDIT NOTE -->

    <!--AJAX REQUEST CHANGE FAVORITE -->
    <script>
        function toggleFavorite(id) {
            event.preventDefault();

            // Mengirim permintaan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send("fav_id=" + id);
        }
    </script>
    <!-- END AJAX REQUEST CHANGE FAVORITE -->
    <!--AJAX REQUEST CHANGE FAVORITE -->
    <script>
        function toggleDelete(id) {
            event.preventDefault();

            // Mengirim permintaan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload()
                }
            };
            xhr.send("delete_id=" + id);
        }
    </script>
    <!-- END AJAX REQUEST CHANGE FAVORITE -->
    <!--AJAX REQUEST VIEW BASED ON TAG -->
    <script>
        function toggleTag(id) {
            event.preventDefault();

            // Mengirim permintaan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var noteContainer = document.querySelector(".note-container");
                    noteContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send("tag_select=" + id);
        }
    </script>
    <!-- END AJAX REQUEST VIEW BASED ON TAG -->
    <script>
        function toggleEdit(id) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "b.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    console.log('Tags:', data.tags);
                    document.getElementById('n-title').value = data.judul;
                    document.getElementById('n-description').value = data.konten;
                    var selectElement = document.getElementById('select-state');
                    var tags = data.tags;
                }
            };
            xhr.send("edit_id=" + id);
        }
    </script>

    <script>
        new TomSelect("#select-state",{
        });
        new TomSelect("#select-state-edit",{
        });
    </script>

    <script>
      $(document).ready(function(){
        var modalStatus = localStorage.getItem('modalStatus');
        if (modalStatus === 'show') {
          localStorage.removeItem('modalStatus');
          setTimeout(function() {
            $("#editNoteModal").modal('show');
          }, 100);
        }

        $(document).on('click', '.tampilkanModal', function(){
          var idNote = $(this).data('idnote');
          localStorage.setItem('modalStatus', 'show');
          window.location.href = "b.php?editNoteId=" + idNote;
        });
      });
    </script>

    <script>
      $(document).ready(function(){
        var modalStatus = localStorage.getItem('modalStatus');
        if (modalStatus === 'editTag') {
          localStorage.removeItem('modalStatus');
          setTimeout(function() {
            $("#editTagModal").modal('show');
          }, 100);
        }

        $(document).on('click', '#tampilkanEditTag', function(){
          var idTag = $(this).data('idtag');
          localStorage.setItem('modalStatus', 'editTag');
          window.location.href = "b.php?editTagId=" + idTag;
        });
      });
    </script>

    <script>
      $("#btn-show-tag").on("click", function (event) {
        $("#addTagModal").modal("show");
      });

      function submitTag(event) {
          if (event) {
              event.preventDefault();
          }
          event.preventDefault();
          var tag = document.getElementById('tag-name').value;
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "b.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
                  location.reload()
              }
          };
          
          xhr.send("addtag=add" + "&name=" + encodeURIComponent(tag));
      }

      $("#btn-add-tag").on("click", function (event) {
        $("#addTagModal").modal("hide");
        submitTag(event)
      });

      function submitEditTag(event) {
          if (event) {
              event.preventDefault();
          }
          event.preventDefault();
          var id = document.getElementById('edit-tag-id').value;
          var tag = document.getElementById('edit-tag-name').value;
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "b.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
                  location.reload()
              }
          };
          
          xhr.send("edittag=edit" + "&id=" + encodeURIComponent(id) + "&name=" + encodeURIComponent(tag));
      }

      $("#btn-edit-tag").on("click", function (event) {
        $("#editTagModal").modal("hide");
        submitEditTag(event)
      });

    </script>

</body>
</html>