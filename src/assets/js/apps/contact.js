$(document).ready(function() {

  checkall('contact-check-all', 'contact-chkbox');

  $('#input-search').on('keyup', function() {
    var rex = new RegExp($(this).val(), 'i');
      $('.searchable-items .items:not(.items-header-section)').hide();
      $('.searchable-items .items:not(.items-header-section)').filter(function() {
          return rex.test($(this).text());
      }).show();
  });

  $('.view-grid').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */

    $(this).parents('.switch').find('.view-list').removeClass('active-view');
    $(this).addClass('active-view');

    $(this).parents('.searchable-container').removeClass('list');
    $(this).parents('.searchable-container').addClass('grid');

    $(this).parents('.searchable-container').find('.searchable-items').removeClass('list');
    $(this).parents('.searchable-container').find('.searchable-items').addClass('grid');

  });

  $('.view-list').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    $(this).parents('.switch').find('.view-grid').removeClass('active-view');
    $(this).addClass('active-view');

    $(this).parents('.searchable-container').removeClass('grid');
    $(this).parents('.searchable-container').addClass('list');

    $(this).parents('.searchable-container').find('.searchable-items').removeClass('grid');
    $(this).parents('.searchable-container').find('.searchable-items').addClass('list');
  });


});




$(".delete-multiple").on("click", function() {
    var inboxCheckboxParents = $(".contact-chkbox:checked").parents('.items');   
      inboxCheckboxParents.remove();
})

deleteContact();


// Menghapus data formulir setelah halaman dimuat
window.onload = function() {
  if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
  }
}

// Validation Process

var $_getValidationField = document.getElementsByClassName('validation-text');
var reg = /^.+@[^\.].*\.[a-z]{2,}$/;
var phoneReg = /^\d{12}$/;

getNameInput = document.getElementById('c-name');

getNameInput.addEventListener('input', function() {

  getNameInputValue = this.value;

  if (getNameInputValue == "") {
    $_getValidationField[0].innerHTML = 'Name Required';
    $_getValidationField[0].style.display = 'block';
  } else {
    $_getValidationField[0].style.display = 'none';
  }

})


getEmailInput = document.getElementById('c-email');

getEmailInput.addEventListener('input', function() {

    getEmailInputValue = this.value;

    if (getEmailInputValue == "") {
      $_getValidationField[1].innerHTML = 'Email Required';
      $_getValidationField[1].style.display = 'block';
    } else if((reg.test(getEmailInputValue) == false)) {
      $_getValidationField[1].innerHTML = 'Invalid Email';
      $_getValidationField[1].style.display = 'block';
    } else {
      $_getValidationField[1].style.display = 'none';
    }

})

getPhoneInput = document.getElementById('c-phone');

getPhoneInput.addEventListener('input', function() {

  getPhoneInputValue = this.value;

  if (getPhoneInputValue == "") {
    $_getValidationField[2].innerHTML = 'Phone Number Required';
    $_getValidationField[2].style.display = 'block';
  } else if((phoneReg.test(getPhoneInputValue) == false)) {
    $_getValidationField[2].innerHTML = 'Invalid (Enter 12 Digits)';
    $_getValidationField[2].style.display = 'block';
  } else {
    $_getValidationField[2].style.display = 'none';
  }

})
