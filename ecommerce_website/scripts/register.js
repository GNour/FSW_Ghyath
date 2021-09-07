// Elements
var emailInput = $("#email");
var passwordInput = $("#password");
var confirmPasswordInput = $("#confirmPassword");
var responsePopup = $("#responsePopup");

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
  if (!confirmPassword(passwordInput.val(), confirmPasswordInput.val())) {
    response = "Confirm Password is wrong!";
  } else if (!validateEmail(emailInput.val())) {
    response = "Email in wrong pattern!";
  } else {
    return true;
  }
  return false;
}

function confirmPassword(password, confirmPassword) {
  if (passwordElement.value == confirmPasswordElement.value) {
    return true;
  }
  return false;
}

function validateEmail(email) {
  var emailValue = emailElement.value;
  if (
    emailValue.length > 5 &&
    emailValue.lastIndexOf(".") > emailValue.lastIndexOf("@") &&
    emailValue.lastIndexOf("@") != -1
  ) {
    return true;
  }
  return false;
}
