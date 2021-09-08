$(function () {
  var products;
  var productContainer = $("#productContainer");
  $.ajax({
    url: "php/getManageStoreProducts.php",
    type: "GET",
    dataType: "json",
    succes: function (response) {},
    complete: function (response) {
      products = response.responseJSON;
      delete products["store"];
      for (let [key, product] of Object.entries(products)) {
        var image = product.image.replace("..", ".");
        var productHtml = `
            <tr id="product_${product.id}">
                    <td class="product-remove text-center" valign="middle">
                      <a href="javascript:void(0)" id="${product.id}" onclick="removeProduct(this.id)"
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
                  </tr>`;

        productContainer.append(productHtml);
      }
    },
  });
});

function removeProduct(productId) {
  $.ajax({
    url: "php/removeProduct.php?id=" + productId,
    type: "GET",
    dataType: "text",
    success: function (response) {
      $("#product_" + productId).remove();
      popupCustomPopup(response);
    },
  });
}
