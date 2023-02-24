<?php
$weather = "";
$error = "";
if (array_key_exists( 'city', $_GET)){
    $city = str_replace(' ' ,'',$_GET['city']);
    $file_headers =@get_headers('https://www.weather-forecast.com/locations/'.
                                  $city .'/forecasts/latest');
    if($file_headers[0] == "HTTP/1.1 404 Not Found"){
        $error = "This city could not be found";
    }
    else{
  $forecastPage = file_get_contents('https://www.weather-forecast.com/locations/'.
                                      $city. '/forecasts/latest');

  $pageArray =
         explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',
             $forecastPage);


        if (sizeof($pageArray) > 1){
     $secondPageArray = explode('</span></p></td>',$pageArray[1]);

     if (sizeof($secondPageArray) >1){
         $weather =$secondPageArray[0];
     }
     else{
         $error = "This city could not be found";
     }
  }

     else{
          $error = "This city could not be found";
      }
  }

    }//end file headers are not empty!

else{
    $error = "That city could not be found";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Scraper</title>
<!-- Favicon -->
  <link rel="shortcut icon"
        href="img/favicon.png"
        type="image/x-icon">
    <link rel="stylesheet"
          href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
          crossorigin="anonymous">
    <!--    Jquery Cdn-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="container">
    <h1>Whats the Weather?</h1>
        <form method="get">
        <fieldset class="form-group">
            <label for="city">Enter the name of a city</label>
            <input type="text"
                   class="form-control"
                   name="city"
                   id="city"
                   placeholder="E.g.,London ,Tokyo"
                   value = "<?php
                          if(array_key_exists('city', $_GET)){
                           echo $_GET['city'];
                          }
                         ?>">
        </fieldset>
        <button type="submit" class="btn btn-warning">Find</button>
        </form>

<div id="weather">
   <?php
   if ($weather){
       echo '<div class="alert alert-success" role="alert">' .$weather. '</div>';

   }
   elseif ($error){
       echo '<div class="alert alert-danger" role="alert">' .$error. '</div>';
   }

   ?>


</div>

</div><!--end of the container-->




</head>


<body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous">
</script>
</body>
</html>