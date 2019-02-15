  function hardUp() {
      document.getElementById("hard_number").stepUp();
  }

  function hardDown() {
      document.getElementById("hard_number").stepDown();
  }

  function softUp() {
      document.getElementById("soft_number").stepUp();
  }

  function softDown() {
      document.getElementById("soft_number").stepDown();
  }

  $(document).ready(function () {
      $("#hard_add").click(function () {

          var sender = $(this);

          console.log("Book id: " + sender.data("book-id"));
          console.log("Type id: " + sender.data("type-id"));
          console.log("Quantity: " + $('#hard_number').val());

          //$("#cart_quantity").data('count', (parseInt($(like_id).data("count")) + 1));
          //$("#cart_total").data('count', (parseInt($(like_id).data("count")) + 1));

          //$('#cart_quantity').html("hard + soft");
          //$('#cart_total').html("data");

          $.ajax({
              type: "POST",
              url: base_url + "/cart/add",
              dataType: 'json', // expected returned data format.

              data: {
                  book_id: sender.data("book-id"),
                  type_id: sender.data("type-id"),
                  quantity: $("#hard_number").val(),
              },
              timeout: 5000, // timeout set to 5 seconds
              success: function (data) {
                  console.log("success");
                  $('#cart-content').load(document.URL + ' #cart-content');
                  $("#hard_message").fadeIn();
                  $("#hard_add").html("Update Cart");
              }, // server error
              error: function (xhr, status, error) {
                  console.log("error");
              },
          });



          cartFadeIn();

      });

      $("#soft_add").click(function () {

          var sender = $(this);

          console.log("Book id: " + sender.data("book-id"));
          console.log("Type id: " + sender.data("type-id"));
          console.log("Quantity: " + $('#soft_number').val());

          //$("#cart_quantity").data('count', (parseInt($(like_id).data("count")) + 1));
          //$("#cart_total").data('count', (parseInt($(like_id).data("count")) + 1));

          //$('#cart_quantity').html("hard + soft");
          //$('#cart_total').html("data");

          $.ajax({
              type: "POST",
              url: base_url + "/cart/add",
              dataType: 'json', // expected returned data format.

              data: {
                  book_id: sender.data("book-id"),
                  type_id: sender.data("type-id"),
                  quantity: $("#soft_number").val(),
              },
              timeout: 5000, // timeout set to 5 seconds
              success: function (data) {
                  console.log("success");
                  $('#cart-content').load(document.URL + ' #cart-content');
                  $("#soft_message").fadeIn();
                  $("#soft_add").html("Update Cart");

                  cartFadeIn();
              }, // server error
              error: function (xhr, status, error) {
                  console.log(error);
              }
          });


      });


      /*
       *  When a add to cart button is clicked this gets the book_id and type_id to send to
       *  the server and add the cart in the session_cache_expire Reloads the cart on success
       *
       */
      $(".book-soft-remove").click(function () {

          var sender = $(this);

          console.log("Book id: " + sender.data("book-id"));
          console.log("Type id: " + sender.data("type-id"));

          $.ajax({
              type: "POST",
              url: base_url + "/cart/remove",
              dataType: 'json', // expected returned data format.

              data: {
                  book_id: sender.data("book-id"),
                  type_id: sender.data("type-id"),
              },
              timeout: 5000, // timeout set to 5 seconds
              success: function (data) {
                  console.log("success");
                  $('#cart-content').load(document.URL + ' #cart-content');
                  $("#soft_message").fadeOut();
                  $('#soft_number').val(0);
                  $("#soft_add").html("Add to Cart");
              }, // server error
              error: function (xhr, status, error) {
                  console.log(error);
              }
          });

          cartFadeIn();

      });


      $(".book-hard-remove").click(function () {

          var sender = $(this);

          console.log("Book id: " + sender.data("book-id"));
          console.log("Type id: " + sender.data("type-id"));

          $.ajax({
              type: "POST",
              url: base_url + "/cart/remove",
              dataType: 'json', // expected returned data format.

              data: {
                  book_id: sender.data("book-id"),
                  type_id: sender.data("type-id"),
              },
              timeout: 5000, // timeout set to 5 seconds
              success: function (data) {
                  console.log("success");
                  $('#cart-content').load(document.URL + ' #cart-content');
                  $("#hard_message").fadeOut();
                  $('#hard_number').val(0);
                  $("#hard_add").html("Add to Cart");
              }, // server error
              error: function (xhr, status, error) {
                  console.log(error);
              }
          });



          cartFadeIn();

      });
  });


  function cartFadeIn() {

      $("#cart").animate({
          right: '0px',
          opacity: '0.8',
      });
  }

  function cartFadeOut() {

      $("#cart").animate({
          right: '-200px',
          opacity: '0',

      });
  }
