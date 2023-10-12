import './bootstrap';

import 'htmx.org';

import Toastify from 'toastify-js';

document.addEventListener("htmx:responseError", function (event) {
  let response = {};
  if (event.detail?.xhr?.response) {
    response = JSON.parse(event.detail?.xhr?.response);
  }

  if (response.hasOwnProperty('errors')) {
    const messages = response.errors.map(error => {
      return error + '\n';
    }).join('');

    Toastify({
      text: messages,
      newWindow: true,
      duration: 5000,
      // close: true,
      className: 'default error',
      stopOnFocus: true, // Prevents dismissing of toast on hover
    }).showToast()
    // alert(
    //   response.errors.map(error => {
    //     return error + '\n';
    //   }).join('')
    // )
  }
})