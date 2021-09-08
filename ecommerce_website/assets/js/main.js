/*********************************************************************************

	Template Name: Belle - Multipurpose eCommerce Bootstrap4 HTML Template
	Description: A perfect template to build beautiful and unique Glasses websites. It comes with nice and clean design.
	Version: 1.0

**********************************************************************************/

/*************************************************
  1. Preloader Loading
  2. Promotional Bar Header
  3. Currency Show/Hide dropdown  
  4. Language Show/Hide dropdown
  5. Top Links Show/Hide dropdown
  6. Minicart Dropdown
  7. Sticky Header
  8. Search Trigger
  9. Mobile Menu
  10 Slick Slider
	 10.1 Homepage Slideshow 
	 10.2 Product Slider Slick
	 10.3 Product Slider Slick Style2
	 10.4 Product Slider Slick Style3
	 10.5 Product Slider Slick Fullwidth
	 10.6 Product Slider Slick Product Page
	 10.7 Collection Slider Slick
	 10.8 Collection Slider Slick 4 items
	 10.9 Logo Slider Slick
	 10.10 Testimonial Slider Slick
  11. Tabs With Accordian Responsive
  12. Sidebar Categories Level links
  13. Price Range Slider
  14. Color Swacthes
  15. Footer links for mobiles
  16. Site Animation
  17. SHOW HIDE PRODUCT TAG
  18. SHOW HIDE PRODUCT Filters
  19. Timer Count Down
  20. Scroll Top
  21. Height Product Grid Image
  22. Product details slider 2
  23. Product details slider 1
  24. Product Zoom
  25. Product Page Popup
  26. Quantity Plus Minus
  27. Visitor Fake Message
  28. Product Tabs
  29. Promotion / Notification Cookie Bar 
  30. Image to background js
  31. COLOR SWATCH ON COLLECTION PAGE
  32. Related Product Slider
  33. Infinite Scroll js
*************************************************/

(function ($) {
  // Start of use strict
  "use strict";

  /*-----------------------------------------
	  1. Preloader Loading ----------------------- 
	  -----------------------------------------*/
  function pre_loader() {
    $("#load").fadeOut();
    $("#pre-loader").delay(0).fadeOut("slow");
  }
  pre_loader();

  /*-----------------------------------------
	  5. Top Links Show/Hide dropdown ---------
	  -----------------------------------------*/
  function userlink_dropdown() {
    $(".top-header .user-menu").on("click", function () {
      if ($(window).width() < 990) {
        $(this).next().slideToggle(300);
        $(this).parent().toggleClass("active");
      }
    });
  }
  userlink_dropdown();

  /*-----------------------------------------
	  7. Sticky Header ------------------------
	  -----------------------------------------*/
  // window.onscroll = function () {
  //   myFunction();
  // };
  // function myFunction() {
  //   if ($(window).width() > 1199) {
  //     if ($(window).scrollTop() > 300) {
  //       $(".header-wrap").addClass("stickyNav animated fadeInDown");
  //     } else {
  //       $(".header-wrap").removeClass("stickyNav fadeInDown");
  //     }
  //   }
  // }
  /*-----------------------------------------
	  9. Mobile Menu --------------------------
	  -----------------------------------------*/
  var selectors = {
    body: "body",
    sitenav: "#siteNav",
    navLinks: "#siteNav .lvl1 > a",
    menuToggle: ".js-mobile-nav-toggle",
    mobilenav: ".mobile-nav-wrapper",
    menuLinks: "#MobileNav .anm",
    closemenu: ".closemobileMenu",
  };

  $(selectors.navLinks).each(function () {
    if ($(this).attr("href") == window.location.pathname)
      $(this).addClass("active");
  });

  $(selectors.menuToggle).on("click", function () {
    body: "body", $(selectors.mobilenav).toggleClass("active");
    $(selectors.body).toggleClass("menuOn");
    $(selectors.menuToggle).toggleClass("mobile-nav--open mobile-nav--close");
  });

  $(selectors.closemenu).on("click", function () {
    body: "body", $(selectors.mobilenav).toggleClass("active");
    $(selectors.body).toggleClass("menuOn");
    $(selectors.menuToggle).toggleClass("mobile-nav--open mobile-nav--close");
  });
  $("body").on("click", function (event) {
    var $target = $(event.target);
    if (
      !$target.parents().is(selectors.mobilenav) &&
      !$target.parents().is(selectors.menuToggle) &&
      !$target.is(selectors.menuToggle)
    ) {
      $(selectors.mobilenav).removeClass("active");
      $(selectors.body).removeClass("menuOn");
      $(selectors.menuToggle)
        .removeClass("mobile-nav--close")
        .addClass("mobile-nav--open");
    }
  });
  $(selectors.menuLinks).on("click", function (e) {
    e.preventDefault();
    $(this).toggleClass("anm-plus-l anm-minus-l");
    $(this).parent().next().slideToggle();
  });

  /*-------------------------------
	  16. Site Animation
	----------------------------------*/
  if ($(window).width() < 771) {
    $(".wow").removeClass("wow");
  }
  var wow = new WOW({
    boxClass: "wow", // animated element css class (default is wow)
    animateClass: "animated", // animation css class (default is animated)
    offset: 0, // distance to the element when triggering the animation (default is 0)
    mobile: false, // trigger animations on mobile devices (default is true)
    live: true, // act on asynchronously loaded content (default is true)
    callback: function (box) {
      // the callback is fired every time an animation is started
      // the argument that is passed in is the DOM node being animated
    },
    scrollContainer: null, // optional scroll container selector, otherwise use window
  });
  wow.init();

  /*-------------------------------
	 20.Scroll Top ------------------
	---------------------------------*/
  function scroll_top() {
    $("#site-scroll").on("click", function () {
      $("html, body").animate({ scrollTop: 0 }, 1000);
      return false;
    });
  }
  scroll_top();

  $(window).scroll(function () {
    if ($(this).scrollTop() > 119) {
      $("#site-scroll").fadeIn();
    } else {
      $("#site-scroll").fadeOut();
    }
  });

  /*-------------------------------
	  21. Height Product Grid Image
	----------------------------------*/
  function productGridView() {
    var gridRows = [];
    var tempRow = [];
    productGridElements = $(".grid-products .item");
    productGridElements.each(function (index) {
      if ($(this).css("clear") != "none" && index != 0) {
        gridRows.push(tempRow);
        tempRow = [];
      }
      tempRow.push(this);

      if (productGridElements.length == index + 1) {
        gridRows.push(tempRow);
      }
    });

    $.each(gridRows, function () {
      var tallestHeight = 0;
      var tallestHeight1 = 0;
      $.each(this, function () {
        $(this).find(".product-image > a").css("height", "");
        elHeight = parseInt($(this).find(".product-image").css("height"));
        if (elHeight > tallestHeight) {
          tallestHeight = elHeight;
        }
      });

      $.each(this, function () {
        if ($(window).width() > 768) {
          $(this).find(".product-image > a").css("height", tallestHeight);
        }
      });
    });
  }

  /*----------------------------------
	  26. Quantity Plus Minus
	------------------------------------*/
  function qnt_incre() {
    $(".qtyBtn").on("click", function () {
      var qtyField = $(this).parent(".qtyField"),
        oldValue = $(qtyField).find(".qty").val(),
        newVal = 1;

      if ($(this).is(".plus")) {
        newVal = parseInt(oldValue) + 1;
      } else if (oldValue > 1) {
        newVal = parseInt(oldValue) - 1;
      }
      $(qtyField).find(".qty").val(newVal);
    });
  }
  qnt_incre();

  /* --------------------------------------
	 	30. Image to background js
	 -------------------------------------- */
  $(".bg-top").parent().addClass("b-top");
  $(".bg-bottom").parent().addClass("b-bottom");
  $(".bg-center").parent().addClass("b-center");
  $(".bg-left").parent().addClass("b-left");
  $(".bg-right").parent().addClass("b-right");
  $(".bg_size_content").parent().addClass("b_size_content");
  $(".bg-img").parent().addClass("bg-size");
  $(".bg-img.blur-up").parent().addClass("");
  jQuery(".bg-img").each(function () {
    var el = $(this),
      src = el.attr("src"),
      parent = el.parent();

    parent.css({
      "background-image": "url(" + src + ")",
      "background-size": "cover",
      "background-position": "center",
      "background-repeat": "no-repeat",
    });

    el.hide();
  });
  /* --------------------------------------
	 	End Image to background js
	 -------------------------------------- */

  /*-----------------------------------
	  33. Infinite Scroll js
	  -------------------------------------*/
  function load_more() {
    $(".product-load-more .item").slice(0, 16).show();
    $(".loadMore").on("click", function (e) {
      e.preventDefault();
      $(".product-load-more .item:hidden").slice(0, 4).slideDown();
      if ($(".product-load-more .item:hidden").length == 0) {
        $(".infinitpagin").html(
          '<div class="btn loadMore">no more products</div>'
        );
      }
    });
  }
  load_more();

  function load_more_post() {
    $(".blog--grid-load-more .article").slice(0, 3).show();
    $(".loadMorepost").on("click", function (e) {
      e.preventDefault();
      $(".blog--grid-load-more .article:hidden").slice(0, 1).slideDown();
      if ($(".blog--grid-load-more .article:hidden").length == 0) {
        $(".loadmore-post").html(
          '<div class="btn loadMorepost">No more Blog Post</div>'
        );
      }
    });
  }
  load_more_post();
  /*-----------------------------------
	  End Infinite Scroll js
	  -------------------------------------*/
})(jQuery);
