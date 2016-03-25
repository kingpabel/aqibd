<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Justified Nav Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/justified-nav.css')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">

    <script src="{{ asset('js/ie-emulation-modes-warning.js')}}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @inject('contoller', 'App\Http\Controllers\HomeController')
    <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});
        @foreach($airDatas as $airData)
        google.charts.setOnLoadCallback(drawChart{{ $airData->id }});
        function drawChart{{ $airData->id }}() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", { role: "style" } ],
                    @foreach($airData->airData()->groupBy(\DB::raw('DATE(date_time)'))->get() as $data)
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
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values{{ $airData->id }}"));
            chart.draw(view, options);
        }
        @endforeach
    </script>

</head>

<body>

<div class="container">
    <!-- The justified navigation menu is meant for single line per list item.
         Multiple lines will require custom code not provided by Bootstrap. -->
    <div class="masthead">
        <h3 class="text-muted">Project name</h3>
        <nav>
            <ul class="nav nav-justified">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Downloads</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>

    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>Marketing stuff!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus
            commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="bu-border">
                    @foreach($airDatas as $airData)
                        <div class="bu-chart row">
                            <div class="bu-chart-10 margin-left-2">
                                {{ $airData->name }}
                            </div>
                            <div class="bu-chart-10">
                                {{ $airData->value }}
                            </div>
                            <div class="bu-chart-60">
                                <div id="columnchart_values{{ $airData->id }}"></div>
                            </div>
                            <div class="bu-chart-10">
                                25
                            </div>
                            <div class="bu-chart-10">
                                399
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <div class="bu-map bu-border">
                    <p>Map Goes Here</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-lg-4">
            <h2>Safari bug warning!</h2>
            <p class="text-danger">As of v8.0, Safari exhibits a bug in which resizing your browser horizontally causes
                rendering errors in the justified nav that are cleared upon refreshing.</p>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
                condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
                euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
                condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
                euismod. Donec sed odio dui. </p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula
                porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                fermentum massa.</p>
            <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
        </div>
    </div>

    <!-- Site footer -->
    <footer class="footer">
        <p>&copy; 2015 Company, Inc.</p>
    </footer>

</div> <!-- /container -->


</body>
</html>