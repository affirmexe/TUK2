document
  .getElementById('togglePassword')
  .addEventListener('click', function () {
    const pwd = document.getElementById('password');
    const icon = this.querySelector('i');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      pwd.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
