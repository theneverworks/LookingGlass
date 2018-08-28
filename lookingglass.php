<!DOCTYPE html>
<html>
<head>
<!-- Change the content to change the refresh rate of the page and data -->
<meta http-equiv="refresh" content="60" >
<title>Looking Glass</title>
    <?php
    
    function laterandom()
    {
      $phrases = array(
        'No good can happen this late',
        'You kids get to bed',
        'Zzzzzzzzz',
        'Oh, you are still up?!'
      );

      return $phrases[array_rand($phrases)];
    }
    
    function morningrandom()
    {
      $phrases = array(
        'Top o\'the morning!',
        'Good morning',
        'Ohayou gozaimasu',
        'Gutenmorgen',
        'Look who\'s up'
      );

      return $phrases[array_rand($phrases)];
    }
    
    function afternoonrandom()
    {
      $phrases = array(
        'Good afternoon'
      );

      return $phrases[array_rand($phrases)];
    }
    
    function eveningrandom()
    {
      $phrases = array(
        'Good evening'
      );

      return $phrases[array_rand($phrases)];
    }
    
    function nightrandom()
    {
      $phrases = array(
        'Good night'
      );

      return $phrases[array_rand($phrases)];
    }
    /* Change the following line to be your PHP timezone 
       If you aren't sure, and don't know what to look up, delete the line. 
       Deleting the line defaults to the host's clock. */
    date_default_timezone_set('America/Phoenix');
    $time = date("H");
    $timezone = date("e");
    
    /* Insert you WeatherUnderground API key in the URL and set the state and city (or reference the WU API docs for your location) */
    /* https://www.wunderground.com/weather/api/ */
    $json_string = file_get_contents("http://api.wunderground.com/api/<API KEY GOES HERE>/geolookup/conditions/astronomy/q/<TWO DIGIT STATE CODE HERE>/<CITY NAME HERE>.json");
    $parsed_json = json_decode($json_string);
    $location = $parsed_json->{'location'}->{'city'};
    $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
    $curweat = $parsed_json->{'current_observation'}->{'weather'};
    $relhum = $parsed_json->{'current_observation'}->{'relative_humidity'};
    $feelslike = $parsed_json->{'current_observation'}->{'feelslike_f'};
    $moonphase = $parsed_json->{'moon_phase'}->{'phaseofMoon'};
    $sunrisehr = $parsed_json->{'sun_phase'}->{'sunrise'}->{'hour'};
    $sunrisemin = $parsed_json->{'sun_phase'}->{'sunrise'}->{'minute'};
    $sunsethr = $parsed_json->{'sun_phase'}->{'sunset'}->{'hour'};
    $sunsetmin = $parsed_json->{'sun_phase'}->{'sunset'}->{'minute'};
    if ($sunsethr >= 13) {
        $sunsethr = $sunsethr - 12;
    }
    /* Insert you OctoPrint API key in the URL and set the hostname or IP of your 3D printer */
    $url='http://<IP ADDRESS GOES HERE>/api/job?apikey=<API KEY GOES HERE>';
    
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the response. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode == 404) {
        /* Handle 404 here. */
        /* Run... you fools... */
        ini_set('display_errors','On');
        error_reporting(E_ALL);
    } else {
        /* Handle $response here. */
        $gimme=json_decode($response, true);
    }
    
    curl_close($handle);

    $hperccomp=$gimme['progress']['completion'];

    /* Insert your second OctoPrint API key in the URL and set the hostname or IP of your 3D printer */
    $url='http://<IP ADDRESS GOES HERE>/api/job?apikey=<API KEY GOES HERE>';
    
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the response. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode == 404) {
        /* Handle 404 here. */
        /* Run... you fools... */
        ini_set('display_errors','On');
        error_reporting(E_ALL);
    } else {
        /* Handle $response here. */
        $gimme=json_decode($response, true);
    }
    
    curl_close($handle);

    $dperccomp=$gimme['progress']['completion'];

    ?>
<style>
body {background-color: black;}
.grid-container {
  display: grid;
  grid-template-columns: 600px auto 600px;
  grid-template-rows: 450px 200px 200px;
  background-color: black;
  padding: 10px;

}
.grid-item {
  background-color: black;
  font-size: 30px;
  text-align: center;
  color: white;
  font-family: sans-serif;
}
.grid-mapitem {
  background-color: black;
  font-size: 30px;
  text-align: left;
  color: white;
  font-family: sans-serif;
}
.grid-rightitem {
  background-color: black;
  font-size: 30px;
  text-align: right;
  color: white;
  font-family: sans-serif;
}
.grid-leftitem {
  background-color: black;
  font-size: 30px;
  text-align: left;
  color: white;
  font-family: sans-serif;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Printer 1', <?php echo $hperccomp;?>]
        ]);

        var options = {
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('charth_div'));

        chart.draw(data, options);
      }
    </script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Printer 2', <?php echo $dperccomp;?>]
        ]);

        var options = {
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chartd_div'));

        chart.draw(data, options);
      }
    </script>
</head>
<body>
<div class="grid-container">
  <div class="grid-mapitem"><?php
    if ($time >= "4" && $time < "9") {
        /* Add the code snippet from Google Maps that shows your commute to work */
        print "<iframe src=\"https://www.google.com/maps/embed?...\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
    } else
    if ($time >= "15" && $time < "19") {
        /* Add the code snippet from Google Maps that shows your commute from work */
        print "<iframe src=\"https://www.google.com/maps/embed?...\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
    }
    ?></div>
  <div class="grid-item"><?php
    if ($time < "4") {
        echo laterandom();
    } else
    if ($time >= "4" && $time < "12") {
        echo morningrandom();
    }
    if ($time >= "12" && $time < "17") {
        echo afternoonrandom();
    } else
    if ($time >= "17" && $time < "20") {
        echo eveningrandom();
    } else
    if ($time >= "20") {
        echo nightrandom();
    }
    ?></div>
  <div class="grid-rightitem"><?php
    /* This sets the $clock to the current hour in desired format */
    $clock = date("h:i A");
      echo $clock;
      echo "</br>Moon Phase: ";
      echo $moonphase;
      echo "</br>Sun Rise: ";
      echo $sunrisehr;
      echo ":";
      echo $sunrisemin;
      echo " AM</br>Sun Set: ";
      echo $sunsethr;
      echo ":";
      echo $sunsetmin;
      echo " PM";
    ?>
  </div>  
  <!-- Extra grids for your fun stuff -->
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>  
  <div class="grid-item"><div id="charth_div" style="width: 400px; height: 200px;"></div></div>
  <div class="grid-leftitem"><?php
  
  echo "Currently ${curweat} </br>";
  echo "${temp_f} degrees </br>";
  echo "${relhum} humidity </br>";
  echo "Feels like ${feelslike} degrees";
?></div>
  <div class="grid-rightitem"><div id="chartd_div" style="width: 400px; height: 200px;"></div></div> 
</div>

</body>
</html>