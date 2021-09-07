// Elements
var emailInput = $("#email");
var firstNameInput = $("#firstName");
var lastNameInput = $("#lastName");
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

function confirmPassword(password, confirmPassword) {
  if (password == confirmPassword && password != "") {
    return true;
  }
  return false;
}

function checkIfNotEmpty(
  email,
  firstName,
  lastName,
  password,
  confirmPassword
) {
  if (
    email.trim() != "" &&
    firstName.trim() != "" &&
    lastName.trim() != "" &&
    password.trim() != "" &&
    confirmPassword.trim() != "" &&
    ($("#genderMale").is(":checked") || $("#genderFemale").is(":checked"))
  ) {
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

// Public API - Genderize user based on their firstName - Event listner of firstName leave
// Visit https://genderize.io/ for more info

firstNameInput.focusout(function () {
  var name = $(this).val();

  $.ajax({
    url: "https://api.genderize.io?name=" + name,
    type: "GET",
    datatype: "json",
    success: function (response) {
      console.log(response);
      if (response.gender == "male") {
        $("#genderMale").prop("checked", true);
        popupCustomPopup(
          "Male checked based on your name with probabilty = " +
            response.probability
        );
      } else if (response.gender == "female") {
        $("#genderFemale").prop("checked", true);
        popupCustomPopup(
          "Female checked based on your name with probabilty = " +
            response.probability
        );
      }
    },
  });
});
