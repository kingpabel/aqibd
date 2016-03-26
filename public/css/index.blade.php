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
<script src="{{ asset('js/ie-emulation-modes-warning.js')}}"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
@inject('contoller', 'App\Http\Controllers\HomeController')
<script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
        @foreach($airDatas as $airData)
        google.charts.setOnLoadCallback(drawChart{{ $airData->id }});
        function drawChart{{ $airData->id }}() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}],
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
                legend: {position: "none"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values{{ $airData->id }}"));
            chart.draw(view, options);
        }
        @endforeach
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
        <li class="active"><a href="#">Farmgate</a></li>
        <li><a href="#">Mohammadpur</a></li>
        <li><a href="#">Mohakhali</a></li>
        <li><a href="#">Tejgaon</a></li>
      </ul>
    </nav>
  </div>
  <div class="container">
    <div class="row">
    <div class="homesearch">
    <form class="form-inline" role="form">
      <div class="col-md-3">
      		<input type="text" class="buaqif1" id="buf1" placeholder="End Date">
      </div>
      <div class="col-md-3">
      		<input type="text" class="buaqif1" id="buf2" placeholder="Start Date">
      </div>
      <div class="col-md-3">
      		<select class="form-control buf3" id="sel1">
    			<option>PM2.5</option>
    			<option>Temp</option>
    			<option>Noise</option>
    			<option>Humidity</option>
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
          <div class="bu-chart row">
            <div class="bu-chart-10 margin-left-2"> {{ $airData->name }} </div>
            <div class="bu-chart-10"> {{ $airData->value }} </div>
            <div class="bu-chart-60">
              <div id="columnchart_values{{ $airData->id }}"></div>
            </div>
          </div>
          @endforeach </div>
      </div>
      <div class="col-md-6">
        <div class="bu-map bu-border">
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
            	<p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more" href="#">Read More</a></p>
            </div>
            <div class="newsrow">
            	<div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
            	<p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more" href="#">Read More</a></p>
            </div>
            <div class="newsrow">
            	<div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
            	<p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more" href="#">Read More</a></p>
            </div>
            <div class="newsrow">
            	<div class="date-news"><i class="fa fa-calendar"></i> 21 February, 2016</div>
            	<p><i class="fa fa-newspaper-o"></i> <a href="#">News About the Air Quality</a> <a class="read-more" href="#">Read More</a></p>
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
            <p>The pollution indices and color codes available on this web site follow the EPA graduation, as defined by <a href="http://www.airnow.gov/index.cfm?action=aqibasics.aqi" target="_blank"> AirNow </a> and explained in <a href="http://www.airnow.gov/index.cfm?action=aqibasics.aqi" target="_blank">Wikipedia.</a></p>
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
              <td class="aqiwtxt">Air quality is considered satisfactory, and air pollution poses little or no risk</td>
            </tr>
            <tr class="aqibtxt" style="background-color:#ffde33">
              <td nowrap="true" class="aqibtxt">51 -100</td>
              <td class="aqibtxt">Moderate</td>
              <td class="aqibtxt">Air quality is acceptable; however, for some pollutants there may be a moderate health concern for a very small number of people who are unusually sensitive to air pollution.</td>
            </tr>
            <tr style="background-color:#ff9933;">
              <td nowrap="true" class="aqibtxt">101-150</td>
              <td class="aqibtxt">Unhealthy for Sensitive Groups</td>
              <td class="aqibtxt">Members of sensitive groups may experience health effects. The general public is not likely to be affected.</td>
            </tr>
            <tr style="background-color:#cc0033;">
              <td nowrap="true" class="aqiwtxt">151-200</td>
              <td class="aqiwtxt">Unhealthy</td>
              <td class="aqiwtxt">Everyone may begin to experience health effects; members of sensitive groups may experience more serious health effects</td>
            </tr>
            <tr style="background-color:#660099;">
              <td nowrap="true" class="aqiwtxt">201-300</td>
              <td class="aqiwtxt">Very Unhealthy</td>
              <td class="aqiwtxt">Health warnings of emergency conditions. The entire population is more likely to be affected.</td>
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
    <div class="col-md-3"> <img class="img-responsive" src="{{ asset('images/bu-logo-footer.png') }}"> </div>
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