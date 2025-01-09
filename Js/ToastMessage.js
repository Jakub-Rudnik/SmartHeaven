function showToastMessage(message, status) {
    Toastify({
      text: message,
      duration: 3000,
      gravity: 'top',  // top lub bottom
      position: 'right',  // right lub left
      stopOnFocus: true,
      style: {
        background: status
          ? 'linear-gradient(to right, #233cb8, #a71aae)'
          : 'linear-gradient(to right, #a71aae, #233cb8)'
      }
    }).showToast();
  }
  