@extends('layouts.frontLayout')
@section('jsTop')
    @inject('controller', 'App\Http\Controllers\HomeController')
    <script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
        <?php
        $pmGraph = $airDatas->filter(function ($value, $key) {
            return $value->id == 1;
        })->first();

        $airDatas = $airDatas->reject(function ($value, $key) {
            return $value->id == 1;
        });
        ?>

        @if($pmGraph && !empty($pmGraph))
        google.charts.setOnLoadCallback(drawChart{{ $pmGraph->id }});
        function drawChart{{ $pmGraph->id }}() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}],
                    @foreach($pmGraph->airData as $airData)
                ["{{ $airData->date_time }}", {{ $airData->value }}, "{{ $controller->colorChooser($airData->value)[0] }}"],
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
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values{{ $pmGraph->id }}"));
            chart.draw(view, options);
        }
        @endif

        @foreach($airDatas as $airData)
        google.charts.setOnLoadCallback(drawChart{{ $airData->id }});
        function drawChart{{ $airData->id }}() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}],
                    @foreach($airData->airData as $data)
                ["{{ $data->date_time }}", {{ $data->value }}, "{{ $controller->colorChooser($data->value)[0] }}"],
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
            ['{{ $todayAirData->location->name }}', {{ $todayAirData->location->lat }}, {{ $todayAirData->location->lng }}, '{{ $todayAirData->airType->name }}', '{{ $todayAirData->value }}'],
            @endforeach
        ];
        function initMap() {

            var myLatLng = {lat: 23.777176, lng: 90.399452};


            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: myLatLng
            });

            setMarkers(map, locations);
        }

        function setMarkers(map, locations) {

            var marker, i;

            for (i = 0; i < locations.length; i++) {

                var loan = locations[i][0];
                var lat = locations[i][1];
                var long = locations[i][2];
                var add = locations[i][3];
                var value = locations[i][4];

                latlngset = new google.maps.LatLng(lat, long);

                var marker = new google.maps.Marker({
                    position: latlngset,
                    map: map,
                    title: loan
                });
                map.setCenter(marker.getPosition());


                var content = loan + '<h3>' + add + '<span style="margin-left: 10%">' + value + '</span></span>';

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

@endsection
@section('content')

    <div class="row-border-x">
        <div class="row">
            <div class="col-md-6">
                <div class="bu-border">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="part1">
                                <div class="pm2avg">
                                    <p>Current day's PM 2.5:</p>
                                    <div class="avgsingle">
                                        <?php
                                        $pmData = $todayAirDatas->filter(function ($value, $key) use ($current) {
                                            return $value->location_id == $current->id;
                                        })->first();
                                        ?>
                                        <span class="avssingleleft"
                                              @if($pmData && isset($pmData->value)) style="background:{{ $controller->colorChooser($pmData->value)[0] }}" @endif>

                                            @if($pmData && isset($pmData->value))
                                                {{ $pmData->value }}
                                            @endif
                                </span>
                            	<span class="avssingleright"
                                      @if($pmData && isset($pmData->value)) style="color:{{ $controller->colorChooser($pmData->value)[0] }}" @endif>
                                @if($pmData && isset($pmData->value))
                                    {{ $controller->colorChooser($pmData->value)[1] }}
                                    @endif
                                </span>
                                    </div>
                                    <div class="chartpmaqi">
                                        <div class="pmaqi1">PM 2.5 AQI</div>
                                        <div class="pmaqi2"> @if($pmData && isset($pmData->value))
                                                {{ $pmData->value }}
                                            @endif</div>
                                        <div class="pmaqi3">
                                            @if($pmGraph && !empty($pmGraph))
                                                <div id="columnchart_values{{ $pmGraph->id }}"></div>
                                            @endif
                                        </div>
                                        <div class="pmaqi4"> @if($pmData && isset($pmData->min))
                                                {{ $pmData->min }}
                                            @endif</div>
                                        <div class="pmaqi5"> @if($pmData && isset($pmData->max))
                                                {{ $pmData->max }}
                                            @endif</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($airDatas as $airData)
                        <?php
                        $currentType = $airDatasAllType->filter(function ($value, $key) use ($airData) {
                            return $value->air_type_id == $airData->id;
                        })->first();
                        ?>
                            <div class="chartpmaqi">
                                <div class="pmaqi1">{{ $airData->name }}</div>
                                <div class="pmaqi2"> @if($currentType) {{ $currentType->value }} @endif</div>
                                <div class="pmaqi3">
                                    <div id="columnchart_values{{ $airData->id }}"></div>
                                </div>
                                <div class="pmaqi4"> @if($currentType) {{ $currentType->min }} @endif</div>
                                <div class="pmaqi5"> @if($currentType) {{ $currentType->max }} @endif</div>
                            </div>
                    @endforeach </div>
            </div>
            <div class="col-md-6">
                <div class="bu-map bu-border" id="map" style="height: 600px">
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
@endsection
<!-- /container -->
<!-- Site footer -->
