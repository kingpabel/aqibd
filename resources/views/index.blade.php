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
    @inject('contoller', 'App\Http\Controllers\HomeController')
    <script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
        @foreach($airDatas as $airData)
        google.charts.setOnLoadCallback(drawChart{{ $airData->id }});
        function drawChart{{ $airData->id }}() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}],
                    @foreach($airData->airData as $data)
                ["{{ $data->date_time }}", {{ $data->value }}, "{{ $contoller->colorChooser($data->value) }}"],
                @endforeach
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
//                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2]);

            var options = {
                title: "",
                height: 100,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values{{ $airData->id }}"));
            chart.draw(view, options);
        }
        @endforeach
    </script>
    <script>
        var locations = [
                @foreach($todayAirDatas as $todayAirData)
            ['{{ $todayAirData->location->name }}', {{ $todayAirData->location->lat }}, {{ $todayAirData->location->lng }}, '{{ $todayAirData->airType->name.' '.$todayAirData->value }}'],
                @endforeach
        ];
        function initMap() {

            var myLatLng = {lat: 23.777176, lng: 90.399452};


            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: myLatLng
            });

            setMarkers(map, locations);


            /*for (i = 0; i < locations.length; i++) {
             marker = new google.maps.Marker({
             position: new google.maps.LatLng(locations[i][1], locations[i][2]),
             map: map,
             title: locations[i][0]
             });
             }*/

            /*var marker = new google.maps.Marker({
             position: myLatLng,
             map: map,
             title: 'Hello World!'
             });*/
        }

        function setMarkers(map, locations) {

            var marker, i;

            for (i = 0; i < locations.length; i++) {

                var loan = locations[i][0];
                var lat = locations[i][1];
                var long = locations[i][2];
                var add = locations[i][3];

                latlngset = new google.maps.LatLng(lat, long);

                var marker = new google.maps.Marker({
                    position: latlngset,
                    map: map,
                    title: loan
                });
                map.setCenter(marker.getPosition());


                var content = loan + '<h3>' + add + '</h3>';

                var infowindow = new google.maps.InfoWindow();

                google.maps.event.addListener(marker, 'mouseover', (function (marker, content, infowindow) {
                    return function () {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    };
                })(marker, content, infowindow));

            }
        }
    </script>
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
                @foreach($allLocation as $location)
                <li @if($current->id == $location->id) class="active" @endif><a href='{{ url("$location->name") }}'>{{ explode(',',$location->name)[0] }}</a></li>
                    @endforeach
            </ul>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="homesearch">
                <form class="form-inline" role="form" method="get" action='{{ url("$current->name/search") }}'>
                    <div class="col-md-3">
                        <input type="text" class="buaqif1 datepicker" id="buf1" placeholder="End Date" name="start" value="@if(isset($params) && isset($params['start']) && $params['start']) {{ $params['start'] }}@else {{ date('Y-m-d') }}@endif">
                    </div>
                    <input type="hidden" name="location_id" value="{{ $current->id }}">
                    <div class="col-md-3">
                        <input type="text" class="buaqif1 datepicker" id="buf2" placeholder="Start Date" name="end" value="@if(isset($params) && isset($params['end']) && $params['end']){{ $params['end'] }} @else {{ date('Y-m-d') }} @endif">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control buf3" id="sel1" name="air_type_id">
                            <option value="">Please Select a air type</option>
                            @foreach($allAirType as $airType)
                                <option @if(isset($params) && isset($params['air_type_id']) && $params['air_type_id'] && $params['air_type_id'] == $airType->id) selected @endif value="{{ $airType->id }}">{{ $airType->name }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-default busubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="bu-border"> @foreach($airDatas as $airData)
                        <div class="row">
                            <div class="bu-chart">
                                <div class="bu-chart-10 margin-left-2"> {{ $airData->name }} </div>
                                <div class="bu-chart-10"> {{ $airData->value }} </div>
                                <div class="bu-chart-60">
                                    <div id="columnchart_values{{ $airData->id }}"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach </div>
            </div>
            <div class="col-md-6">
                <div class="bu-map bu-border" id="map" style="height: 300px">
                    <p>Map Goes Here</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row ln-bg">
        <div class="col-md-6">
            <div class="latest-news">
                <div class="newsrow">
                    <div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
                    <p><a href="#">News About the Air Quality</a> <a class="read-more" href="#">Read More</a></p>
                </div>
                <div class="newsrow">
                    <div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
                    <p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more"
                                                                                                       href="#">Read
                            More</a></p>
                </div>
                <div class="newsrow">
                    <div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
                    <p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more"
                                                                                                       href="#">Read
                            More</a></p>
                </div>
                <div class="newsrow">
                    <div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
                    <p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more"
                                                                                                       href="#">Read
                            More</a></p>
                </div>
                <div class="newsrow">
                    <div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
                    <p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more"
                                                                                                       href="#">Read
                            More</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="photo-galleery">
                <img class="img-responsive teamimg" src="{{ asset('images/slider_team.jpg') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="aqpminfo">
                <h2>About the Air Quality and Pollution Measurement:</h2>
                <p>The pollution indices and color codes available on this web site follow the EPA graduation, as
                    defined by <a href="http://www.airnow.gov/index.cfm?action=aqibasics.aqi" target="_blank">
                        AirNow </a> and explained in <a href="http://www.airnow.gov/index.cfm?action=aqibasics.aqi"
                                                        target="_blank">Wikipedia.</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="aqpm">
                <table class="infoaqitable">
                    <thead>
                    <tr>
                        <th>AQI</th>
                        <th>Air Pollution Level</th>
                        <th>Health Implications</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color:#009966;">
                        <td nowrap="true" class="aqiwtxt">0 - 50</td>
                        <td class="aqiwtxt">Good</td>
                        <td class="aqiwtxt">Air quality is considered satisfactory, and air pollution poses little or no
                            risk
                        </td>
                    </tr>
                    <tr class="aqibtxt" style="background-color:#ffde33">
                        <td nowrap="true" class="aqibtxt">51 -100</td>
                        <td class="aqibtxt">Moderate</td>
                        <td class="aqibtxt">Air quality is acceptable; however, for some pollutants there may be a
                            moderate health concern for a very small number of people who are unusually sensitive to air
                            pollution.
                        </td>
                    </tr>
                    <tr style="background-color:#ff9933;">
                        <td nowrap="true" class="aqibtxt">101-150</td>
                        <td class="aqibtxt">Unhealthy for Sensitive Groups</td>
                        <td class="aqibtxt">Members of sensitive groups may experience health effects. The general
                            public is not likely to be affected.
                        </td>
                    </tr>
                    <tr style="background-color:#cc0033;">
                        <td nowrap="true" class="aqiwtxt">151-200</td>
                        <td class="aqiwtxt">Unhealthy</td>
                        <td class="aqiwtxt">Everyone may begin to experience health effects; members of sensitive groups
                            may experience more serious health effects
                        </td>
                    </tr>
                    <tr style="background-color:#660099;">
                        <td nowrap="true" class="aqiwtxt">201-300</td>
                        <td class="aqiwtxt">Very Unhealthy</td>
                        <td class="aqiwtxt">Health warnings of emergency conditions. The entire population is more
                            likely to be affected.
                        </td>
                    </tr>
                    <tr style="background-color:#7e0023;">
                        <td nowrap="true" class="aqiwtxt">300+</td>
                        <td class="aqiwtxt">Hazardous</td>
                        <td class="aqiwtxt">Health alert: everyone may experience more serious health effects</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /container -->
<!-- Site footer -->
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