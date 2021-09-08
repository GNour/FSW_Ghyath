$(function () {
  var products;

  var container = $("#viewProducts");
  $.ajax({
    url: "php/getStoreProducts.php?" + window.location.href.split("?")[1],
    type: "GET",
    dataType: "json",
    succes: function (response) {},
    complete: function (response) {
      products = response.responseJSON;
      var store = products["store"];
      var count = 0;
      var storeImage = store.header.replace("..", ".");

      // Change Contact Info and Site Title
      $("#storeCountry").text(store.country);
      $("#title").html("GCom &ndash; " + store.name);
      $("#storeCity").text(store.city + ",");
      $("#storestreet").text(store.street);
      $("#storeEmail").text(store.email);
      $("#storePhone").text(store.phone);
      $("#storeName").text(store.name);
      $("#imageHeader").attr("src", storeImage);
      $("#imageHeader").attr("data-src", storeImage);
      $("#storeCountry").text(store.country);

      // Delete Store object from response after Filling the information
      delete products["store"];

      // Add Store Products
      for (let [key, value] of Object.entries(products)) {
        console.log(value.image);
        var image = value.image.replace("..", ".");
        var imageHover = value.hoverImage.replace("..", ".");
        var product = `<div class="col-6 col-sm-6 col-md-4 col-lg-3 item">
                <!-- start product image -->
                <div class="product-image">
                  <!-- start product image -->
                  <a
                    href="javascript:void(0)"
                    data-toggle="modal"
                    data-target="#content_quickview"
                  >
                    <!-- image -->
                    <img
                      class="primary blur-up lazyload"
                      data-src="${image}"
                      src="${image}"
                      alt="image"
                      id="productImagePrimary"
                      title="product"
                    />
                    <!-- End image -->
                    <!-- Hover image -->
                    <img
                      class="hover blur-up lazyload"
                      data-src="${imageHover}"
                      src="${imageHover}"
                      alt="image"
                      id="productImageHover"
                      title="product"
                    />
                    <!-- End hover image -->
                  </a>
                  <!-- end product image -->

                  <!-- Start product button -->
                  <form
                    class="variants add"
                    action="#"
                    method="post"
                  >
                    <button
                      class="btn btn-addto-cart"
                      type="button"
                      id="addToCartButton"
                      onclick="addToCart(${value.id})"
                    >
                      Add to cart
                    </button>
                  </form>
                  <div class="button-set">
                    <div class="wishlist-btn">
                      <a
                        class="wishlist add-to-wishlist"
                        href="javascript:void(0)"
                        onclick="addToWishlist(this.id)"
                        title="Add to Wishlist"
                        id="${value.id}"
                      >
                        <i class="icon anm anm-heart-l"></i>
                      </a>
                    </div>
                  </div>
                  <!-- end product button -->
                </div>
                <!-- end product image -->

                <!--start product details -->
                <div class="product-details text-center">
                  <!-- product name -->
                  <div class="product-name">
                    <a
                      href="javascript:void(0)"
                      data-toggle="modal"
                      data-target="#content_quickview"
                      >${value.name}</a
                    >
                  </div>
                  <!-- End product name -->
                  <!-- product price -->
                  <div class="product-price">
                    <span class="price" id="productPrice">$${value.price}</span>
                  </div>
                  <!-- End product price -->
                </div>
                <!-- End product details -->
              </div>`;

        container.append(product);
        count++;
      }
      $("#showing").text("Showing: " + count);
    },
  });
});

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

function addToWishlist(productId) {
  $.ajax({
    url: "php/addToWishlist.php?id=" + productId,
    type: "GET",
    dataType: "text",
    success: function (response) {
      popupCustomPopup(response);
    },
  });
}
