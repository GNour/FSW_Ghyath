var confirmPasswordInput = $("#confirmPassword");
var emailInput = $("#email");
var passwordInput = $("#password");
var response = "";

$("#registerButton").click(function (submit) {
  submit.preventDefault();
  if (!validateForm()) {
    popupCustomPopup(response);
  } else {
    $("#registerForm").submit();
  }
});

function validateForm() {
  if (
    !checkIfNotEmpty(
      emailInput.val(),
      firstNameInput.val(),
      lastNameInput.val(),
      passwordInput.val(),
      confirmPasswordInput.val()
    )
  ) {
    response = "Form is not completed!";
  } else if (!validateEmail(emailInput.val())) {
    response = "Email in wrong pattern!";
  } else if (
    !confirmPassword(passwordInput.val(), confirmPasswordInput.val())
  ) {
    response = "Confirm Password is wrong!";
  } else {
    return true;
  }
  return false;
}

function validateEmail(email) {
  if (
    email.length > 5 &&
    email.lastIndexOf(".") > email.lastIndexOf("@") &&
    email.lastIndexOf("@") != -1
  ) {
    return true;
  }
  return false;
}

function confirmPassword(password, confirmPassword) {
  if (password == confirmPassword && password != "") {
    return true;
  }
  return false;
}

function checkIfNotEmpty(email, password, confirmPassword) {
  if (
    email.trim() != "" &&
    password.trim() != "" &&
    confirmPassword.trim() != ""
  ) {
    return true;
  }
  return false;
}
