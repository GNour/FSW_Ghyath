// Call getIndex.php to manipulate the user options

$(function () {
  var options;
  $.ajax({
    url: "php/getIndex.php",
    type: "GET",
    dataType: "json",
    succes: function (response) {},
    complete: function (response) {
      options = response.responseJSON;
      console.log(options);

      if (options.loggedIn) {
        $("#loginOption").remove();
        $("a[href='./cart.html']").attr(
          "href",
          "./cart.html?cart=" + options.cart
        );
      } else {
        $("#myCartOption").remove();
        $("#createStoreOption").remove();
        $("#manageStore").remove();
        $("#wishlistOption").remove();
      }
      if (options.store) {
        $("#createStoreOption").remove();
        $("a[href='./manageStore.html']").attr(
          "href",
          "./manageStore.html?store=" + options.store
        );
      } else {
        $("#manageStore").remove();
      }
    },
  });
});
