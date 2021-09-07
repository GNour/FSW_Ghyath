var response = "";

$("#createStoreButton").click(function (event) {
  event.preventDefault();
  if (!validateForm()) {
    popupCustomPopup(response);
  } else {
    console.log("Good");
    $("#createStoreForm").submit();
  }
});

function validateForm() {
  if (!checkEmpty()) {
    response = "Please complete the form!";
  } else if (!validateEmail($("#email").val())) {
    response = "Input a correct email Address!";
  } else if (!validatePhone($("#phone").val())) {
    response = "Input a correct phone number!";
  } else {
    return true;
  }
}

function checkEmpty() {
  return (
    $("input").filter(function () {
      return $.trim($(this).val()).length == 0;
    }).length == 0
  );
}

function validatePhone(phone) {
  var regexPhone = new RegExp(
    /^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm
  );

  if (regexPhone.test(phone)) {
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
