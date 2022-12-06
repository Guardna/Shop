<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="images/film.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="flower shop">
    <meta name="keywords" content="flowers" />
    <meta name="author" content="Stefan Popovic">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Flower Shop | @yield('title') </title>

    @section('appendCss')
    <link href="{{ asset('/') }}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    @show
<style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    footer {
        margin-top: auto;
    }
</style>
<script src="{{ asset('/') }}vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="{{ asset('/') }}js/Popup/dist/magnific-popup.css">
<script src="{{ asset('/') }}js/provera.js"></script>
<script src="{{ asset('/') }}js/Popup/dist/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$('.image-popup-vertical-fit').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-img-mobile',
			image: {
				verticalFit: true
			}

		});

		$('.image-popup-fit-width').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			image: {
				verticalFit: false
			}
		});

		$('.image-popup-no-margins').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom',
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300
		}
	});

	});


</script>

  </head>
  <body>

    @include('components.nav')

    <div class="container">

      <div class="row">
        <div class="col-lg-12"></div>
        <div class="col-lg-12">
            <div id="poruke"></div>
          @empty(!session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endempty

          @empty(!session('success'))
            <div class="alert alert-success">{{ session('success') }} </div>
          @endempty
        </div>

        @yield('content')

        @include('components.sidebar')

      </div>

    </div>


    @include('components.footer')


    @section('appendJavascript')

        <script>
            $(document).ready(function() {
                correctTotalPrice()
            })
            function changeQuantity(input, price, postId) {
                if(!input.value || input.value < 1) {
                    $('#poruke').html('Not allowed quantity.').removeClass().addClass("alert alert-danger");
                    input.value = 1;
                } {
                    $("#span_price_" + postId).html((input.value * price).toFixed(2))
                    correctTotalPrice()

                    $.ajax({
                        method: "POST",
                        url: "/cart/adjustQuantity",
                        data: {
                            trackId : postId,
                            quantity : input.value
                        },
                        success: function() {
                            console.log(data);
                        },
                        error: function(xhr, status, error) {
                            console.log(data);
                        }
                    })
                }
            }
            function correctTotalPrice() {
                var allPrices = document.querySelectorAll(".product_price")

                var totalPrice = 0;

                for(let priceSpan of allPrices) {
                    totalPrice += Number(priceSpan.innerHTML)
                }

                $("#totalPrice").html(totalPrice.toFixed(2))
            }
            function addToCart(id) {
                $.ajax({
                    method: "POST",
                    url: "/cart",
                    data: {
                        id : id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#poruke').html('Product successfully added to cart.').removeClass().addClass("alert alert-success");
                    },
                    error: function(data) {
                        console.log(data);
                        $('#poruke').html('There was an error processing your request.').removeClass().addClass("alert alert-danger");
                    }
                })
            }

            function removeFromCart(postId) {
                $.ajax({
                    method: "DELETE",
                    url: "/cart/" + postId,
                    success: function() {
                        $('#poruke').html('Product successfully removed from the cart.').removeClass().addClass("alert alert-success");

                        let cartItemDiv = $("#cart_item_" + postId)

                        cartItemDiv.remove()
                        correctTotalPrice()
                    },
                    error: function(xhr, status, error) {
                        $('#poruke').html('There was an error processing your request.').removeClass().addClass("alert alert-danger");
                    }
                })
            }
            function checkout(btn) {
                $.ajax({
                    method: "POST",
                    url: "/checkout",
                    success: function() {
                        $('#poruke').html('Your order has been submitted.').removeClass().addClass("alert alert-success");
                        $(btn).attr("disabled", "disabled")
                    },
                    error: function(xhr, status, error) {
                        $('#poruke').html('There was an error processing your order.').removeClass().addClass("alert alert-danger");
                    }
                })
            }
        </script>
    <script src="{{ asset('/') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset("js/ajax.js") }}"></script>
    @show

  </body>

</html>

