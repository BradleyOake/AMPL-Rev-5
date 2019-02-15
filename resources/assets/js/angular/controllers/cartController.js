// Gets the cart from the session
app.factory('CartService', function ($http) {
    return {
        getCart: function () {
            return $http({
                url: base_url + '/cart/get',
                method: 'GET'
            })
        }
    }
});

app.controller('cartCtrl', function ($scope, $http, CartService) {

    $scope.cart = []; // Items in cart
    $scope.cartTax = 0; // Cart taxes
    $scope.cartNumberItems = 0; // Cart total number of items
    $scope.cartTotal = 0; // Cart total price
    //$scope.hasCart = false;

    $scope.hasHard = false; // If user has the current book in hard
    $scope.hasSoft = false; // If user has the current book in soft
    $scope.hasEbook = false; //If user has the current book in eBook
    $scope.hasMp3 = false;  // If user has the current book in MP3

    //not needed at this time

    /*
    $scope.hasEpub = false; // If user has the current book in ePUB
    $scope.hasPdf = false;  // If user has the current book in PDF
    $scope.hasTxt = false;  // If user has the current book in TXT
    */

    $scope.softButton = "Add to Cart";
    $scope.hardButton = "Add to Cart";
    $scope.ebookButton = "Add to Cart";
    $scope.mp3Button = "Add to Cart";

    //not needed at this time

    /*
    $scope.epubButton = "Add to Cart";
    $scope.pdfButton = "Add to Cart";
    $scope.txtButton = "Add to Cart";
    */

    getCart();


    // get the current cart state and calulates the totals
    function getCart() {
        //console.log("getCart");
        CartService.getCart().success(function (data) {
            //console.log(data);
            $scope.cart = data.items;
            getCartTotals();

            // Check if on a book page
            if (typeof (book_id) !== 'undefined') {
                getBookPageVariables();
            }
        });
    }

    // Checks if the current book is already in the cart
    function getBookPageVariables() {
        console.log("getBookPageVariables");

        $scope.hasHard = false;
        $scope.hasSoft = false;
        $scope.hasMp3 = false;
        $scope.hasEbook = false;

        //not needed at this time
        /*
        $scope.hasEpub = false;
        $scope.hasPdf = false;
        $scope.hasTxt = false;
        */

        $scope.ebookButton = "Add to Cart";
        $scope.softButton = "Add to Cart";
        $scope.hardButton = "Add to Cart";
        $scope.mp3Button = "Add to Cart";

        //not needed at this time
        /*
        $scope.epubButton = "Add to Cart";
        $scope.pdfButton = "Add to Cart";
        $scope.txtButton = "Add to Cart";
        */

        $scope.soft_quantity = 1;
        $scope.hard_quantity = 1;
        $scope.ebook_quantity = 1;
        $scope.mp3_quantity = 1;

        //not needed at this time
        /*
        $scope.epub_quantity = 1;
        $scope.pdf_quantity = 1;
        $scope.txt_quantity = 1;
        */

        angular.forEach($scope.cart, function (item) {

            if (item.book_id == book_id) {
                // 0 == eBook
                if (item.type_id == 0) {
                    $scope.hasEbook = true;
                    $scope.ebookButton = "In Cart";
                    $scope.txt_quantity = item.quantity;
                }
                // 4 = MP3
                if (item.type_id == 4) {
                  $scope.hasMp3 = true;
                  $scope.mp3Button = "In Cart";
                  $scope.mp3_quantity = item.quantity;
                }


                //not needed at this time

                /*
                // 1 == ePub
                if (item.type_id == 1) {
                    $scope.hasTxt = true;
                    $scope.txtButton = "Update Cart";
                    $scope.txt_quantity = item.quantity;
                }
                // 2 == E-Pub
                if (item.type_id == 2) {
                  $scope.hasEpub = true;
                  $scope.epubButton = "Update Cart";
                  $scope.epub_quantity = item.quantity;
                }
                // 3 == PDF
                if (item.type_id == 3) {
                  $scope.hasPdf = true;
                  $scope.pdfButton = "Update Cart";
                  $scope.pdf_quantity = item.quantity;
                }
                */


                // 5 == Soft Copy
                if (item.type_id == 5) {
                    $scope.hasSoft = true;
                    $scope.softButton = "Update Cart";
                    $scope.soft_quantity = item.quantity;
                }

                // 6 == Hard Copy
                if (item.type_id == 6) {
                    $scope.hasHard = true;
                    $scope.hardButton = "Update Cart";
                    $scope.hard_quantity = item.quantity;
                }
            }
        })

    }

    // Calculates the total of the cart
    function getCartTotals() {
        var priceTotal = 0;
        var itemTotal = 0;
        var taxTotal = 0;
        var physicalTypeCount = 0;

        angular.forEach($scope.cart, function (item) {
            priceTotal += (item.price * item.quantity);
            itemTotal += item.quantity;
            
            if(item.type_id == 5 || item.type_id == 6)
            {
                physicalTypeCount++;
            }
 
        });

        $scope.cartNumberItems = itemTotal;
        $scope.cartTotal = priceTotal;
        $scope.cartTax = .13 * priceTotal;
        
        if(physicalTypeCount > 0)
        {
            $scope.shipping = 10.00;
        }
        else
        {
            $scope.shipping = 0.00;
        }
        
    }

    //not needed at this time
    /*
    $scope.txtUp = function () {
        if ($scope.txt_quantity > 0) {
            $scope.txt_quantity++;
        }
    }

    $scope.txtDown = function() {
        if ($scope.txt_quantity > 1) {
            $scope.txt_quantity--;
        }
    }

    $scope.epubUp = function () {
        if ($scope.epub_quantity > 0) {
            $scope.epub_quantity++;
        }
    }

    $scope.epubDown = function() {
        if ($scope.epub_quantity > 1) {
            $scope.epub_quantity--;
        }
    }

    $scope.pdfUp = function () {
        if ($scope.pdf_quantity > 0) {
            $scope.pdf_quantity++;
        }
    }

    $scope.pdfDown = function() {
        if ($scope.pdf_quantity > 1) {
            $scope.pdf_quantity--;
        }
    }

    $scope.mp3Up = function () {
        if ($scope.mp3_quantity > 0) {
            $scope.mp3_quantity++;
        }
    }

    $scope.mp3Down = function() {
        if ($scope.mp3_quantity > 1) {
            $scope.mp3_quantity--;
        }
    }
    */
    $scope.softUp = function () {
        if ($scope.soft_quantity >= 20)
        {
            $scope.soft_quantity = 20;
        }
        else if ($scope.soft_quantity > 0)
        {
            $scope.soft_quantity++;
        }
    }

    $scope.softDown = function () {
        if ($scope.soft_quantity > 1) {
            $scope.soft_quantity--;
        }
    }

    $scope.hardUp = function () {
        if ($scope.hard_quantity >= 20)
        {
            $scope.hard_quantity = 20;
        }
        else if ($scope.hard_quantity > 0)
        {
            $scope.hard_quantity++;
        }
    }

    $scope.hardDown = function () {
        if ($scope.hard_quantity > 1) {
            $scope.hard_quantity--;
        }
    }

    /*
     *  Adds a book to the cart
     *
     * NOTE: Need to add a check for if the user is logged in here
     */
    $scope.addBook = function (book_id, type_id) {
        console.log("add book");
        //not needed at this time
        /*
        if (type_id == 1) {
            $quantity = $scope.text_quantity;
        } else if (type_id == 2) {
            $quantity = $scope.epub_quantity;
        } else if (type_id == 3) {
            $quantity = $scope.pdf_quantity;
        }*/
        
        if (type_id == 4) {
            $quantity = $scope.mp3_quantity;
        } else if(type_id == 0) {
          $quantity = $scope.ebook_quantity;
        } else if (type_id == 5) {
            $quantity = $scope.soft_quantity;
        } else if (type_id == 6) {
            $quantity = $scope.hard_quantity;
        }
        $http({
                method: 'POST',
                url: base_url + '/cart/add',
                data: {
                    book_id: book_id,
                    type_id: type_id,
                    quantity: $quantity,
                },

            })
            .success(function (data) {
                console.log(data);
                getCart();
            })
            .error(function (error) {
                console.log(error);
            });
    }


    $scope.deleteBook = function (book_id, type_id) {

        console.log("delete book");

        console.log(book_id, type_id);

        $http({
            method: 'POST',
            url: base_url + '/cart/remove',
            data: {
                book_id: book_id,
                type_id: type_id
            },

        }).
        success(function (data) {
                console.log(data);
                getCart();
            })
            .error(function (error) {
                console.log(error);

            });
    }
});
