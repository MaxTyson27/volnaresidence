$(function () {
  $('.modal__form-input[type="tel"]').inputmask({ "mask": "+7(999) 999-99-99" });

  $(".modal__form").submit(function (event) {
    event.preventDefault();
    var str = $(this).serialize();
    if (true) {
      $.ajax({
        type: "POST",
        url: "submit.php",
        data: str,
        success: function () {
          console.log("send")
          var downloadLink = document.createElement('a');
          downloadLink.setAttribute('href', '/Volna Residence.pdf');
          downloadLink.setAttribute('download', 'Volna Residence.pdf');
          downloadLink.click();
          $('.modal').removeClass('modal--active')
          $('.success').addClass('success--active')
          $(".modal__form")[0].reset();
        },
        error: function () {
          console.log('fail');
        }
      });
    }
    return false;
  });

});

'use strict';

const formFunction = () => {
  const form = document.querySelector('.modal__form')
  form.addEventListener('input', (e) => {
    if (e.target.classList.contains('input-name')) {

      e.target.value = e.target.value.replace(/[^a-zA-Zа-яёА-ЯЁ\ ]+/gi, '')
      if (e.target.value[0] === ' ') {
        e.target.value = ''
      }
      if (e.target.value.length == 1) {
        e.target.value = e.target.value.toUpperCase()
      }
    }
  })
}

const modalFunction = () => {
  const btn = document.querySelector('.content__link')
  const modal = document.querySelector('.modal')
  const modalBg = document.querySelector('.modal--close')
  const closeIcon = modal.querySelector('.modal__close')
  const successModal = document.querySelector('.success')
  const successModalCloseIcon = successModal.querySelector('.success__close')

  const removeClasses = () => {
    modalBg.classList.remove('bg--active')
    modal.classList.remove('modal--active')
    successModal.classList.remove('success--active')
  }

  const openModal = () => {
    btn.addEventListener('click', (e) => {
      e.preventDefault()
      modal.classList.add('modal--active')
      modalBg.classList.add('bg--active')
    })
  }

  const closeModal = () => {
    modalBg.addEventListener('click', () => {
      removeClasses()
    })

    closeIcon.addEventListener('click', () => {
      removeClasses()
    })

    successModalCloseIcon.addEventListener('click', () => {
      removeClasses()
    })
  }




  openModal()
  closeModal()
}

formFunction()

modalFunction()