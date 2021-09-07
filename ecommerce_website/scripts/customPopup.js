function popupCustomPopup(response) {
  responsePopup.children("p").text(response);
  responsePopup.removeClass("hide");
  setTimeout(function () {
    responsePopup.addClass("hide");
  }, 3000);
}
