// DOM Elements
var emailElement = document.getElementById("email");
var phoneElement = document.getElementById("phone");
var passwordElement = document.getElementById("password");
var confirmPasswordElement = document.getElementById("confirmPassword");
var submitElement = document.getElementById("submitButton");
var dateElement = document.getElementById("birthday");
var formElement = document.getElementById("signupForm");

var emailValid;
var confirmPass;
var phoneValid;
var ageValid;
// Listeners

submitElement.addEventListener("click", function () {
  validateEmail();
  confirmPassword();
  validatePhone();
  validateAge();

  if (emailValid && confirmPass && phoneValid && ageValid) {
    formElement.submit();
  }
});

function validateEmail() {
  var emailValue = emailElement.value;
  emailValid = false;
  if (
    emailValue.length > 5 &&
    emailValue.lastIndexOf(".") > emailValue.lastIndexOf("@") &&
    emailValue.lastIndexOf("@") != -1
  ) {
    emailValid = true;
  }
}

function confirmPassword() {
  confirmPass = false;
  if (passwordElement.value == confirmPasswordElement.value) {
    confirmPass = true;
  }
}

function validatePhone() {
  phoneValid = false;
  var phoneValue = phoneElement.value.split(" ").join("");
  if (
    (phoneValue.length == 12 || phoneValue.length == 11) &&
    phoneValue.indexOf("+961") == 0
  ) {
    phoneValid = true;
  }
}

function validateAge() {
  ageValid = false;
  var date = new Date(dateElement.value);

  var diff_ms = Date.now() - date.getTime();
  var age_dt = new Date(diff_ms);
  if (Math.abs(age_dt.getUTCFullYear() - 1970) >= 18) {
    ageValid = true;
  }
}
