$(function () {
  var products;
  var cartContainer = $("#cartContainer");
  var total = 0.0;
  $.ajax({
    url: "php/getCart.php",
    type: "GET",
    dataType: "json",
    succes: function (response) {},
    complete: function (response) {
      products = response.responseJSON;
      if (products != null) {
        for (let [key, product] of Object.entries(products)) {
          total += parseFloat(product.price);
          var image = product.image.replace("..", ".");
          var productHtml = `
      <tr id="product_${product.id}"
                    class="cart__row border-bottom line1 cart-flex border-top"
                  >
                    <td class="cart__image-wrapper cart-flex-item">
                      <a href="#"
                        ><img
                          class="cart__image"
                          src="${image}"
                          alt="${product.name}"
                      /></a>
                    </td>
                    <td class="cart__meta small--text-left cart-flex-item">
                      <div class="list-view-item__title">
                        <a href="#">${product.name} </a>
                      </div>
    
                      <div class="cart__meta-text">${product.description}</div>
                    </td>
                    <td class="cart__price-wrapper text-center cart-flex-item">
                      <span class="money">$${product.price}</span>
                    </td>
                    <td class="text-center small--hide">
                      <a
                        href="javascript:void(0)"
                        class="btn btn--secondary cart__remove"
                        title="Remove Item"
                        onclick="removeFromCart(${product.id},${product.price})"
                        ><i class="icon icon anm anm-times-l"></i
                      ></a>
                    </td>
                  </tr>`;

          cartContainer.append(productHtml);
        }
      }

      $("#total").text("$" + total);
    },
  });
});

function removeFromCart(productId, productPrice) {
  popupCustomPopup("Removing Item From Cart...");
  $.ajax({
    url: "php/removeFromCart.php?id=" + productId,
    type: "GET",
    dataType: "text",
    success: function (response) {
      $("#product_" + productId).remove();
      popupCustomPopup(response);
      var oldTotal = $("#total").text().slice(1);
      var newTotal = parseFloat(oldTotal) - parseFloat(productPrice);
      $("#total").text("$" + newTotal);
    },
  });
}

function checkout() {
  popupCustomPopup("Checking Out Please wait...");
  $.ajax({
    url: "php/checkout.php",
    type: "POST",
    data: { total: parseFloat($("#total").text().slice(1)) },
    dataType: "json",
    success: function (response) {
      console.log(response.code);
      if (response.code === 200) {
        popupCustomPopup(response.message);
      } else if (response.code === 500) {
        popupCustomPopup(response.message);
      }
      setTimeout(() => {
        location.href = "./index.html";
      }, 2000);
    },
  });
}
