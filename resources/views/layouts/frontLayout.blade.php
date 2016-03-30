<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Bangladesh Air Pollution | Real time PM2.5 Air Quality Index(AQI) | Bangladesh University</title>

    <!-- Bootstrap core CSS -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/justified-nav.css')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oranienbaum' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('js/ie-emulation-modes-warning.js')}}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
    @yield('jsTop')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?callback=initMap">
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="logo-aqi">
                <img class="img-responsive" src="{{ asset('images/aqi-logo-t.png') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="logo-bu">
                <img class="img-responsive" src="{{ asset('images/aqi_bu_logo.png') }}">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
    <div class="masthead">
        <nav>
            <ul class="nav nav-justified">
                <li @if(isset($menu) && $menu == 'Air Quality' ) class="active" @endif><a
                            href='{{ url("/") }}'>Air Quality</a></li>

                <li @if(isset($menu) && $menu == 'Urban Regeneration' ) class="active" @endif><a
                            href='{{ url("/urban-regeneration") }}'>Urban Regeneration</a></li>

                <li @if(isset($menu) && $menu == 'Environmental Health' ) class="active" @endif><a
                            href='{{ url("/environmental-health") }}'>Environmental Health</a></li>

                <li @if(isset($menu) && $menu == 'Digital Dhaka' ) class="active" @endif><a
                            href='{{ url("/digital-dhaka") }}'>Digital Dhaka</a></li>
            </ul>
        </nav>
    </div>
    <div class="search">
        <div class="row">
            {{--<div class="homesearch" style="display:none;">
                <form class="form-inline" role="form" method="get" action='{{ url("$current->name/search") }}'>
                    <div class="col-md-3">
                        <input type="text" class="buaqif1 datepicker" id="buf1" placeholder="End Date" name="start"
                               value="@if(isset($params) && isset($params['start']) && $params['start']) {{ $params['start'] }}@else {{ date('Y-m-d') }}@endif">
                    </div>
                    <input type="hidden" name="location_id" value="{{ $current->id }}">
                    <div class="col-md-3">
                        <input type="text" class="buaqif1 datepicker" id="buf2" placeholder="Start Date" name="end"
                               value="@if(isset($params) && isset($params['end']) && $params['end']){{ $params['end'] }} @else {{ date('Y-m-d') }} @endif">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control buf3" id="sel1" name="air_type_id">
                            <option value="">Please Select a air type</option>
                            @foreach($allAirType as $airType)
                                <option @if(isset($params) && isset($params['air_type_id']) && $params['air_type_id'] && $params['air_type_id'] == $airType->id) selected
                                        @endif value="{{ $airType->id }}">{{ $airType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-default busubmit">Submit</button>
                    </div>
                </form>
            </div>--}}
        </div>
    </div>

    @yield('content')
</div>
    <footer class="footer">
        <div class="container">
            <div class="col-md-3"><img class="img-responsive" src="{{ asset('images/bu-logo-footer.png') }}"></div>
            <div class="col-md-6">
                <div class="footer-menu">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="copyright">
                    <p>&copy; 2016 <a href="http://bu.edu.bd/" target="_blank">BU</a> | All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>