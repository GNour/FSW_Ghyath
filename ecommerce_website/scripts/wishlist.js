$(function () {
  var products;
  var wishlistContainer = $("#wishlistContainer");
  $.ajax({
    url: "php/getWishlist.php",
    type: "GET",
    dataType: "json",
    succes: function (response) {},
    complete: function (response) {
      products = response.responseJSON;
      for (let [key, product] of Object.entries(products)) {
        var image = product.image.replace("..", ".");
        var productHtml = `
          <tr id="product_${product.id}">
                  <td class="product-remove text-center" valign="middle">
                    <a href="javascript:void(0)" id="${product.id}" onclick="removeFromWishlist(this.id)"
                      ><i class="icon icon anm anm-times-l"></i
                    ></a>
                  </td>
                  <td class="product-thumbnail text-center">
                    <a href="#"
                      ><img
                        src="${image}"
                        alt="${image}"
                        title="${product.name}"
                    /></a>
                  </td>
                  <td class="product-name">
                    <h4 class="no-margin">
                      <a href="#">${product.name}</a>
                    </h4>
                  </td>
                  <td class="product-price text-center">
                    <span class="amount">$${product.price}</span>
                  </td>
                  <td class="product-subtotal text-center">
                    <button type="button" onclick="addToCart(${product.id})" class="btn btn-small">
                      Add To Cart
                    </button>
                  </td>
                </tr>`;

        wishlistContainer.append(productHtml);
      }
    },
  });
});

function removeFromWishlist(productId) {
  $.ajax({
    url: "php/removeFromWishlist.php?id=" + productId,
    type: "GET",
    dataType: "text",
    success: function (response) {
      $("#product_" + productId).remove();
      popupCustomPopup(response);
    },
  });
}

function addToCart(productId) {
  $.ajax({
    url: "php/addToCart.php?id=" + productId,
    type: "GET",
    dataType: "text",
    success: function (response) {
      popupCustomPopup(response);
    },
  });
}
