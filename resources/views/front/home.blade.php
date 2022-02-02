<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/notification.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/> --}}
    <link rel="stylesheet" href="{{ asset('assets/front/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">
    <style>
        .comment-div{
            border: 1px solid white;
        }
        .main-container {
            width: 95%;
            margin: auto;
            margin-top: 75px
        }
        .w-95{
            width: 95%;
            margin: auto;
        }
        .cover {
            width: 100%;
            height: 350px;
            padding-bottom: 20px
        }

        .cover img {
            width: 100%;
            height: 100%;
        }

        .profile-image {
            width: 70px;
            height: 70px;
            border-radius: 50%
        }

        .navbar-nav {
            margin-left: 30px;
        }

        .nav-link {
            color: #fff;
        }

        .nav-link.active {
            background-color: transparent !important;
            border: none !important;
            color: #fff;
            border-bottom: 2px solid #fff !important;
            margin-bottom: 15px
        }

        .navbar-brand {
            padding-left: 35px !important;
        }

        .nav-link:hover {
            border: none !important;
            border-bottom: 2px solid #fff !important
        }

        .tab-content {
            /* background-color: #1b1b1b; */
            margin-bottom: 20px
        }

        .video-list {
            width: 100% !important;
            height: 180px !important;
        }

        .video-box{
            padding: 4px !important;
        }

        .video-box .video-content{
            padding: 10px !important;
        }

        .video-box a{
            color: #515151;
        }
        .show {
            background-color: transparent !important
        }

        .clickable {
            cursor: pointer;
        }

        .video video {
            width: 100%;
            height: 500px;
        }

        .dropdown-menu.show {
            background-color: #1b1b1b !important;
            right: 0
        }

        .dropdown-item {
            color: #fff !important;

        }

        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: transparent;
            text-decoration: underline
        }

        .profile-image.play {
            height: 50px;
            width: 50px;
            margin-left: 15px
        }
        .ui-autocomplete
        {
            position:absolute;
            cursor:default;
            z-index:99999 !important
        }

        #carousalTop {
            padding: 35px;
        }

        .carousel-item {
            height: 300px;
        }

        #carousalTop {
            padding-bottom: 0px;
        }

    </style>


    <script>
        window.Laravel = @php echo json_encode(['csrfToken' => csrf_token()]); @endphp
    </script>

    @if (!auth()->guest())
        <script>
            window.Laravel.userId = <?php echo auth()->user()->id; ?>
        </script>
    @endif
</head>

<body class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-light">

    <a class="navbar-brand logo" href="#">
        VID BITE
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                @auth()
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                @else

                    <a class="nav-link" href="{{ route('default') }}">Home</a>
                @endauth

            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('watchlist') }}">Watchlist</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./library.php">Live</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('library') }}">Library</a>
            </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" id="search-form" action="{{ route('home') }}" methdd="GET" autocomplete="off">
            <!-- Actual search box -->
            {{ csrf_field() }}
            <div class="form-group has-search autocomplete ui-widget">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control typeahead " id="search" placeholder="Search">
            </div>
        </form>
        @if (Route::has('login'))
            <ul class="navbar-nav mr-auto">
                @auth()
                    <li class="nav-item active">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else

                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth


            </ul>
        @endif
    </div>
</nav>
<div class="container-fluid">

    @section('content')

        <div id="carousalTop" class="carousel slide mt-5" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#carousalTop" data-slide-to="{{$key}}" class=" @if($key == 0) active @endif"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item @if ($key == 0) active @endif " >
                        <img src="{{ asset($banner->image) }}" style="width: 100% !important" class="w-100 d-block" alt="...">
                    </div>
                @endforeach


            </div>

        </div>
    @endsection



</div>

<script src="https://kit.fontawesome.com/74d240b4ae.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>


<script>

    $( function() {
        $( "#search" ).autocomplete({
            source: function( request, response ) {
                // Fetch data
                var headers = { 'X-CSRF-TOKEN': $('input[name="_token"]').val()};
                $.ajax({
                    url:"{{route('autocomplete')}}",
                    type: 'get',
                    dataType: "json",
                    headers: headers,
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#search').val(ui.item.label); // display the selected text
                return false;
            }
        });

        $(".slick-slider").slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    } );

    // var path = "{{ url('autocomplete') }}";
    // $('#search').typeahead({
    //     minLength: 2,
    //     source:  function (query, process) {
    //     return $.get(path, { query: query }, function (data) {
    //             console.log('Data',data);
    //             return process(data);
    //         });
    //     }
    // });

    $('#search-form').submit(function( event ) {
        event.preventDefault();
        let q = $('#search').val();
        var path = "{{ url('search') }}?q="+q;

        console.log("{{request()->is('search')}}");
        // return;

        if("{{request()->is('search')}}" != 1){
            document.location.href = path;
        }


    });

    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //$(".active-tab span").html(activeTab);
            //$(".previous-tab span").html(previousTab);
        });
    });

    $(".video-list").click(function() {
        window.location.href = $(this).data('href');
    });

    var dd_main = document.querySelector(".dd_main");

    dd_main.addEventListener("click", function() {
        this.classList.toggle("active");
    })
</script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@yield('jscripts')

@stack('scripts')
@push('scripts')
    <script>
        $( function() {
            $('.slick-track').addClass('float-left');
        });
    </script>
@endpush
</body>

</html>