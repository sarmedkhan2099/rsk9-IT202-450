// helper.js

function isNotEmpty(value) {
  return value.trim().length > 0;
}

function isValidEmail(email) {
  const re = /^\S+@\S+\.\S+$/;
  return re.test(email);
}

function showMessage(id, message, type) {
  const el = document.getElementById(id);
  if (el) {
    el.innerText = message;
    el.className = type;
  }
}

function validateRegister() {
  const form = document.forms['registerForm'];
  if (!isNotEmpty(form.username.value)) {
    showMessage('error-list', 'Username required', 'error');
    return false;
  }
  if (!isValidEmail(form.email.value)) {
    showMessage('error-list', 'Valid email required', 'error');
    return false;
  }
  if (!isNotEmpty(form.password.value)) {
    showMessage('error-list', 'Password required', 'error');
    return false;
  }
  if (form.password.value !== form.confirm_password.value) {
    showMessage('error-list', 'Passwords do not match', 'error');
    return false;
  }
  return true;
}

function validateLogin() {
  const form = document.forms['loginForm'];
  if (!isNotEmpty(form.login_id.value)) {
    showMessage('error-list', 'Username or email required', 'error');
    return false;
  }
  if (!isNotEmpty(form.login_password.value)) {
    showMessage('error-list', 'Password required', 'error');
    return false;
  }
  return true;
}
