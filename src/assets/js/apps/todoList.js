$('.input-search').on('keyup', function() {
  var rex = new RegExp($(this).val(), 'i');
    $('.todo-box .todo-item').hide();
    $('.todo-box .todo-item').filter(function() {
        return rex.test($(this).text());
    }).show();
});

const taskViewScroll = new PerfectScrollbar('.task-text', {
    wheelSpeed:.5,
    swipeEasing:!0,
    minScrollbarLength:40,
    maxScrollbarLength:300,
    suppressScrollX : true
});

function dynamicBadgeNotification( setTodoCategoryCount ) {
  var todoCategoryCount = setTodoCategoryCount;

  // Get Parents Div(s)
  var get_ParentsDiv = $('.todo-item');
  var get_TodoAllListParentsDiv = $('.todo-item.all-list');
  var get_TodoCompletedListParentsDiv = $('.todo-item.todo-task-done');
  var get_TodoImportantListParentsDiv = $('.todo-item.todo-task-important');

  // Get Parents Div(s) Counts
  var get_TodoListElementsCount = get_TodoAllListParentsDiv.length;
  var get_CompletedTaskElementsCount = get_TodoCompletedListParentsDiv.length;
  var get_ImportantTaskElementsCount = get_TodoImportantListParentsDiv.length;

  // Get Badge Div(s)
  var getBadgeTodoAllListDiv = $('#all-list .todo-badge');
  var getBadgeCompletedTaskListDiv = $('#todo-task-done .todo-badge');
  var getBadgeImportantTaskListDiv = $('#todo-task-important .todo-badge');


  if (todoCategoryCount === 'allList') {
    if (get_TodoListElementsCount === 0) {
      getBadgeTodoAllListDiv.text('');
      return;
    }
    if (get_TodoListElementsCount > 9) {
        getBadgeTodoAllListDiv.css({
            padding: '2px 0px',
            height: '25px',
            width: '25px'
        });
    } else if (get_TodoListElementsCount <= 9) {
        getBadgeTodoAllListDiv.removeAttr('style');
    }
    getBadgeTodoAllListDiv.text(get_TodoListElementsCount);
  }
  else if (todoCategoryCount === 'completedList') {
    if (get_CompletedTaskElementsCount === 0) {
      getBadgeCompletedTaskListDiv.text('');
      return;
    }
    if (get_CompletedTaskElementsCount > 9) {
        getBadgeCompletedTaskListDiv.css({
            padding: '2px 0px',
            height: '25px',
            width: '25px'
        });
    } else if (get_CompletedTaskElementsCount <= 9) {
        getBadgeCompletedTaskListDiv.removeAttr('style');
    }
    getBadgeCompletedTaskListDiv.text(get_CompletedTaskElementsCount);
  }
  else if (todoCategoryCount === 'importantList') {
    if (get_ImportantTaskElementsCount === 0) {
      getBadgeImportantTaskListDiv.text('');
      return;
    }
    if (get_ImportantTaskElementsCount > 9) {
        getBadgeImportantTaskListDiv.css({
            padding: '2px 0px',
            height: '25px',
            width: '25px'
        });
    } else if (get_ImportantTaskElementsCount <= 9) {
        getBadgeImportantTaskListDiv.removeAttr('style');
    }
    getBadgeImportantTaskListDiv.text(get_ImportantTaskElementsCount);
  }
}

new dynamicBadgeNotification('allList');
new dynamicBadgeNotification('completedList');

/*
  ====================
    Quill Editor
  ====================
*/



$('#addTaskModal').on('hidden.bs.modal', function (e) {
  // do something...
  $(this)
    .find("input,textarea,select")
       .val('')
       .end();

  quill.deleteText(0, 2000);
})
$('.mail-menu').on('click', function(event) {
  $('.tab-title').addClass('mail-menu-show');
  $('.mail-overlay').addClass('mail-overlay-show');
})
$('.mail-overlay').on('click', function(event) {
  $('.tab-title').removeClass('mail-menu-show');
  $('.mail-overlay').removeClass('mail-overlay-show');
})
$('#addTask').on('click', function(event) {
  event.preventDefault();
  $('.add-tsk').show();
  $('.edit-tsk').hide();
  $('.add-title').show();
  $('.edit-title').hide();
  $('#addTaskModal').modal('show');
  const ps = new PerfectScrollbar('.todo-box-scroll', {
    suppressScrollX : true
  });
});
const ps = new PerfectScrollbar('.todo-box-scroll', {
    suppressScrollX : true
  });

const todoListScroll = new PerfectScrollbar('.todoList-sidebar-scroll', {
    suppressScrollX : true
  });
  
  function checkCheckbox() {
    $('.todo-item input[type="checkbox"]').each(function() {
      var checkboxId = $(this).attr('id');
      var isChecked = localStorage.getItem(checkboxId) === 'true';
  
      $(this).prop('checked', isChecked);
      $(this).on('change', function() {
        
        localStorage.setItem(checkboxId, $(this).prop('checked'));
        updateTodoItemView($(this));

      });
      updateTodoItemView($(this));
    });

    function updateTodoItemView(checkbox) {
      var todoItem = checkbox.parents('.todo-item');
      if (checkbox.is(":checked")) {
        todoItem.addClass('todo-task-done');
      } else {
        todoItem.removeClass('todo-task-done');
      }
      new dynamicBadgeNotification('completedList');
    }
  }
  
  function taskDone(){
    $('.todo-item input[type="checkbox"]').each(function(){
      var checkbox   = $(this).attr('id');
      var today      = new Date().toISOString().split('T')[0];
      var deadFromDb = $(this).data('dead');

      if (today === deadFromDb) {
        checkbox.checked = true;
      }
    })
  }

  $('.dropdown #taskDel').on('click', function(){
    $('#addContactModalDelete').modal('show');

    let id    = $(this).data('id')
    $('#addContactModalDelete #deleteTask').val(id);
  })


  $('.action-dropdown .dropdown-menu #taskEdit').on('click', function(){
    $('#editTaskModal').modal('show');

    $('.add-tsk').hide();
    $('.edit-tsk').show();

    $('.add-title').hide();
    $('.edit-title').show();

    let id    = $(this).data('id');
    let title = $(this).data('title');
    let desc  = $(this).data('desc');
    let dead  = $(this).data('deadl'); 

    $('#editTaskModal #idTaskUpd').val(id);
    $('#editTaskModal #judulTask').val(title);
    $('#editTaskModal #taskdescription').val(desc);
    $('#editTaskModal .deadlineupdate #dateUpdate').val(dead);    
  })


$('.todo-content').on('click', function() {
  let id    = $(this).data('id');
  let title = $(this).data('title');
  let desc  = $(this).data('desc');

  // Simpan data ke elemen dengan class tertentu
  let $todoClick = $(this).find('.todoClick');
  $todoClick.data('id', id);
  $todoClick.data('title', title);
  $todoClick.data('desc', desc);

  $todoClick.trigger('click');
});

$('.todoClick').on('click', function() {
  $('#todoShowListItem').modal('show');
  // Mengambil data dari elemen dengan class todoClick
  let id    = $(this).data('id');
  let title = $(this).data('title');
  let desc  = $(this).data('desc');

  $('.modal-header #idTask').val(id);
  $('.modal-content #taskHeader').html(title);
  $('.modal-body #taskDesc').html(desc);
});




var $btns = $('.list-actions').click(function() {
  if (this.id == 'all-list') {
    var $el = $('.' + this.id).fadeIn();
    $('#ct > div').not($el).hide();
  } else if (this.id == 'todo-task-trash') {
    var $el = $('.' + this.id).fadeIn();
    $('#ct > div').not($el).hide();
  } else {
    var $el = $('.' + this.id).fadeIn();
    $('#ct > div').not($el).hide();
  }
  $btns.removeClass('active');
  $(this).addClass('active');
})

checkCheckbox();
taskDone();

$('.tab-title .nav-pills a.nav-link').on('click', function(event) {
  $(this).parents('.mail-box-container').find('.tab-title').removeClass('mail-menu-show')
  $(this).parents('.mail-box-container').find('.mail-overlay').removeClass('mail-overlay-show')
})

// Validation Process

  var $_getValidationField = document.getElementsByClassName('validation-text');

  getTaskTitleInput = document.getElementById('task');

  getTaskTitleInput.addEventListener('input', function() {

      getTaskTitleInputValue = this.value;

      if (getTaskTitleInputValue == "") {
        $_getValidationField[0].innerHTML = 'Title Required';
        $_getValidationField[0].style.display = 'block';
      } else {
        $_getValidationField[0].style.display = 'none';
      }
  })

  getTaskDescriptionInput = document.getElementById('taskdescription');

  getTaskDescriptionInput.addEventListener('input', function() {

    getTaskDescriptionInputValue = this.value;

    if (getTaskDescriptionInputValue == "") {
      $_getValidationField[1].innerHTML = 'Description Required';
      $_getValidationField[1].style.display = 'block';
    } else {
      $_getValidationField[1].style.display = 'none';
    }

  })