<?php
session_start();
$logged = $_SESSION['logged'];

if(!$logged){
  echo "Ingreso no autorizado";
  die();
}

$devices = $_SESSION['devices'];

//momento de conectarnos a db
$conn = mysqli_connect("localhost","admin_iot","75543ZIONING","admin_iot");

// Variable de declaración en segundos
//$ActualizarDespuesDe = 25;

// Envíe un encabezado Refresh al navegador preferido.
//header('Refresh: '.$ActualizarDespuesDe);

//$array = array();

//foreach ($devices as $device ) {
  //array_push($array,$device['devices_serie']);
//}



//$matches = implode(',', $array);


//$query = "SELECT * FROM `traffic_devices` WHERE `devices_serie` IN($matches)";
//$result = $conn->query($query);
//$traffics = $result->fetch_all(MYSQLI_ASSOC);

//print_r($traffics);
//die();
$consulta = "SELECT * FROM alucol ORDER BY data_id DESC LIMIT 10";
$resultado=mysqli_query($conn,$consulta);
//$consultakw = "SELECT SUM (data_kw) AS valor FROM data ORDER BY data_date DESC LIMIT 1000";
//$resultadokw=mysqli_query($conn,$consultakw);


$consultag1 = "SELECT data_date,data_kw3,data_ea FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadog1=mysqli_query($conn,$consultag1);
$valoresY1=array();
$valoresY2=array();
$valoresX1=array();
while ($ver1=mysqli_fetch_row($resultadog1)) {
$valoresX1[]=$ver1[0];
$valoresY1[]=$ver1[1];
$valoresY2[]=$ver1[2];
}
$datosX1=json_encode($valoresX1);
$datosY1=json_encode($valoresY1);
$datosY2=json_encode($valoresY2);

$consultag2 = "SELECT pre_date,prereal FROM prediccioncosto ORDER BY pre_date DESC LIMIT 10";
$resultadog2=mysqli_query($conn,$consultag2);
$valoresY1x=array();
$valoresX1x=array();
while ($ver1x=mysqli_fetch_row($resultadog2)) {
$valoresX1x[]=$ver1x[0];
$valoresY1x[]=$ver1x[1];
}
$datosX1x=json_encode($valoresX1x);
$datosY1x=json_encode($valoresY1x);


$consultags = "SELECT data_date,data_cn FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadogs=mysqli_query($conn,$consultags);
$valoresYs=array();
$valoresXs=array();

while ($vers=mysqli_fetch_row($resultadogs)) {
$valoresXs[]=$vers[0];
$valoresYs[]=$vers[1];

}
$datosXs=json_encode($valoresXs);
$datosYs=json_encode($valoresYs);


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>ZION ING ML</title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="assets/images/logo.png">

  <!-- style -->
  <link rel="stylesheet" href="assets/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="assets/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="assets/material-design-icons/material-design-icons.css" type="text/css" />

  <link rel="stylesheet" href="assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css assets/styles/app.min.css -->
  <link rel="stylesheet" href="assets/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="assets/styles/font.css" type="text/css" />
</head>
<body>
  <div class="app" id="app">

    <!-- ############ LAYOUT START-->

    <!-- BARRA IZQUIERDA -->
    <!-- aside -->
    <div id="aside" class="app-aside modal nav-dropdown">
      <!-- fluid app aside -->
      <div class="left navside light dk" data-layout="column">
        <div class="navbar no-radius">
          <!-- brand -->
          <a class="navbar-brand">
            <!--div ui-include="'assets/images/logo.svg'"></div>
            <!--img src="assets/images/logo.png" alt="." class="hide"-->
            <span class="hidden-folded inline">Steam Trap Demo</span>
          </a>
          <!-- / brand -->
        </div>
        <div class="hide-scroll" data-flex>
          <nav class="scroll nav-light">

            <ul class="nav" ui-nav>
              <li class="nav-header hidden-folded">
                <small class="text-muted">Menu</small>
              </li>

              <li>
                <a href="dashboardv.php" >
                  <span class="nav-icon">
                    <i class="fa fa-building-o"></i>
                  </span>
                  <span class="nav-text">Dashboard</span>
                </a>
              </li>
              <li>
                <a href="vvapor.php" >
                  <span class="nav-icon">
                  <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Trap 1</span>
                </a>
              </li>

              <li>
                <a href="vvapor.php" >
                  <span class="nav-icon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Trap 2</span>
                </a>
              </li>
              <li>


            </ul>
          </nav>
        </div>
        <div class="b-t">
          <div class="nav-fold">
            <a href="">
              <span class="pull-left">
                <!--img src="assets/images/alucol.jpg" alt="..." class="w-40 img-circle"-->
              </span>
              <span class="clear hidden-folded p-x">
                <span class="block _500">Demo</span>
                <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>Online</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- / -->

    <!-- content -->
    <div id="content" class="app-content box-shadow-z0" role="main">
      <div class="app-header white box-shadow">
        <div class="navbar navbar-toggleable-sm flex-row align-items-center">
          <!-- Open side - Naviation on mobile -->
          <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
            <i class="material-icons">&#xe5d2;</i>
          </a>
          <!-- / -->
          <div class="">
            <b id="display_new_access">  </b>
          </div>
          <!-- Page title - Bind to $state's title -->
          <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>

          <!-- navbar collapse -->
          <div class="collapse navbar-collapse" id="collapse">
            <!-- link and dropdown -->
            <ul class="nav navbar-nav mr-auto">
              <li class="nav-item dropdown">
                <a  class="nav-link" href data-toggle="dropdown">

                </a>
                <div ui-include="'views/blocks/dropdown.new.html'"></div>
              </li>
            </ul>

            <div ui-include="'views/blocks/navbar.form.html'"></div>
            <!-- / -->
          </div>
          <!-- / navbar collapse -->

          <!-- BARRA DE LA DERECHA -->
          <ul class="nav navbar-nav ml-auto flex-row">
            <li class="nav-item dropdown pos-stc-xs">
              <!--a class="nav-link mr-2" href data-toggle="dropdown">
                <i class="material-icons">&#xe7f5;</i>
                <span class="label label-sm up warn">3</span>
              </a-->
              <div ui-include="'views/blocks/dropdown.notification.html'"></div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link p-0 clear" href="" data-toggle="">
                <span class="avatar w-32">
                  <img src="assets/images/a0.jpg" alt="...">
                  <i class="on b-white bottom"></i>
                </span>
              </a>
              <div ui-include="'views/blocks/dropdown.user.html'"></div>
            </li>
            <li class="nav-item hidden-md-up">
              <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                <i class="material-icons">&#xe5d4;</i>
              </a>
            </li>
          </ul>
          <!-- / navbar right -->
        </div>
      </div>


      <!-- PIE DE PAGINA -->
      <div class="app-footer">
        <div class="p-2 text-xs">
          <div class="pull-right text-muted py-1">
            &copy; Copyright <strong></strong> <span class="hidden-xs-down">- 2022</span>
            <a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>
          </div>
          <div class="nav">
            <a class="nav-link" href="">About</a>
          </div>
        </div>
      </div>

      <div ui-view class="app-body" id="view">


        <!-- SECCION CENTRAL -->
        <div class="padding">

                  <!-- VALORES EN TIEMPO REAL -->
                  <div class="row">
                    <div class="col-xs-12 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded  accent">
                            <i class="fa fa-cog"></i>
                          </span>
                        </div>
                        <div class="clear">

                          <h4 class="m-0 text-lg _300">Total savings: $<b id="display_ww2"><?php
                          $consultaah = "SELECT ahorro FROM prediccioncosto ORDER BY data_date DESC LIMIT 30 ";
                          $resultadoah=mysqli_query($conn,$consultaah);
                          $suma5=0;
                         while($mostrar = mysqli_fetch_array($resultadoah)) { $suma5 += $mostrar['ahorro'];}
                        echo number_format(($suma5)/20);
                          ?></b><span class="text-sm" > </span></h4>
                          <small class="text-muted">Saving by USD</small>
                        </div>

                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded primary">
                            <i class="fa fa-bolt"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Condensated save: <b id="display_ww"><?php

                          $consultapre = "SELECT prereal FROM prediccioncosto ORDER BY data_date DESC LIMIT 30 ";
                          $resultadopre=mysqli_query($conn,$consultapre);
                          $suma2=0;
                         while($mostrar = mysqli_fetch_array($resultadopre)) { $suma2 += $mostrar['prereal'];}
                        echo number_format(($suma2)/10);
                          ?></b><span class="text-sm" > Kg</span></h4>
                          <small class="text-muted">Saving in kg</small>
                        </div>

                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded primary">
                            <i class="fa fa-bolt"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Water save: <b id="display_ww"> 0</b><span class="text-sm" > L</span></h4>
                          <small class="text-muted">Saving in Liters</small>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded  accent">
                            <i class="fa fa-cube"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Trampas en falla: <b id="display_p1">0</b><span class="text-sm"></span></h4>
                          <small class="text-muted">Estado</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded warn">
                            <i class="fa fa-magnet"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">CO2 emissions: <b id="display_kg2"><?php
                          $consultakg = "SELECT data_ea FROM alucol ORDER BY data_date DESC LIMIT 1 ";
                          $resultadokg=mysqli_query($conn,$consultakg);
                          $suma3=0;
                         while($mostrar = mysqli_fetch_array($resultadokg)) { $suma3 += $mostrar['data_ea'];}
                        echo number_format(($suma3)* 0.16438);

                          ?></b><span class="text-sm"> Kg</span></h4>
                          <small class="text-muted">CO2 by energy</small>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- SWItCH1 y 2 -->
                  <!--div class="row">
                    < SWItCH1-->
                    <!--div class="col-xs-12 col-sm-6">
                      <div class="box p-a">
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Notificación </label>
                          <div class="col-sm-10">
                            <label class="ui-switch ui-switch-md info m-t-xs">
                              <input id="input_led1" onchange="process_led1()"  type="checkbox" >
                              <i></i>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- SWItCH2 -->
                      <!--div class="col-xs-12 col-sm-6">
                        <div class="box p-a">
                          <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Predicción</label>
                            <div class="col-sm-10">
                              <label class="ui-switch ui-switch-md info m-t-xs">
                                <input id="input_led2" onchange="process_led2()" type="checkbox"  >
                                <i></i>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div-->

<button class="btn btn-fw info">Download report</button>

<!--div class="row">
  <div class="col-sm-6 col-md-6">
    <div class="box">
      <div class="box-header">
        <h3>Consumo anual de energía eléctrica</h3>

      </div>
      <div class="box-body">
        <img src="assets/images/g1.jpeg"  width="550">
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-6">
    <div class="box">
      <div class="box-header">
        <h3>Kg de CO2 anual</h3>

      </div>
      <div class="box-body">
              <img src="assets/images/g2.jpeg"  width="480">
      </div>
    </div>
  </div>
</div-->

      <div class="box-header">
<div id="graficaLineal1"></div>

      </div>


      <div class="box-header">

<div id="graficaLineal2"></div>
      </div>
      <div class="box-header">

<div id="graficaLineal3"></div>
      </div>


        <!-- ############ PAGE END-->

      </div>

    </div>

    <!-- / -->



    <!-- SELECTOR DE TEMAS -->
    <div id="switcher">
      <div class="switcher box-color dark-white text-color" id="sw-theme">
        <a href ui-toggle-class="active" target="#sw-theme" class="box-color dark-white text-color sw-btn">
          <i class="fa fa-gear"></i>
        </a>
        <div class="box-header">
          <a href="https://themeforest.net/item/flatkit-app-ui-kit/13231484?ref=flatfull" class="btn btn-xs rounded danger pull-right">BUY</a>
          <h2>Theme Switcher</h2>
        </div>
        <div class="box-divider"></div>
        <div class="box-body">
          <p class="hidden-md-down">
            <label class="md-check m-y-xs"  data-target="folded">
              <input type="checkbox">
              <i class="green"></i>
              <span class="hidden-folded">Folded Aside</span>
            </label>
            <label class="md-check m-y-xs" data-target="boxed">
              <input type="checkbox">
              <i class="green"></i>
              <span class="hidden-folded">Boxed Layout</span>
            </label>
            <label class="m-y-xs pointer" ui-fullscreen>
              <span class="fa fa-expand fa-fw m-r-xs"></span>
              <span>Fullscreen Mode</span>
            </label>
          </p>
          <p>Colors:</p>
          <p data-target="themeID">
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'primary', accent:'accent', warn:'warn'}">
              <input type="radio" name="color" value="1">
              <i class="primary"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'accent', accent:'cyan', warn:'warn'}">
              <input type="radio" name="color" value="2">
              <i class="accent"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warn', accent:'light-blue', warn:'warning'}">
              <input type="radio" name="color" value="3">
              <i class="warn"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'success', accent:'teal', warn:'lime'}">
              <input type="radio" name="color" value="4">
              <i class="success"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'info', accent:'light-blue', warn:'success'}">
              <input type="radio" name="color" value="5">
              <i class="info"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'blue', accent:'indigo', warn:'primary'}">
              <input type="radio" name="color" value="6">
              <i class="blue"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warning', accent:'grey-100', warn:'success'}">
              <input type="radio" name="color" value="7">
              <i class="warning"></i>
            </label>
            <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'danger', accent:'grey-100', warn:'grey-300'}">
              <input type="radio" name="color" value="8">
              <i class="danger"></i>
            </label>
          </p>
          <p>Themes:</p>
          <div data-target="bg" class="row no-gutter text-u-c text-center _600 clearfix">
            <label class="p-a col-sm-6 light pointer m-0">
              <input type="radio" name="theme" value="" hidden>
              Light
            </label>
            <label class="p-a col-sm-6 grey pointer m-0">
              <input type="radio" name="theme" value="grey" hidden>
              Grey
            </label>
            <label class="p-a col-sm-6 dark pointer m-0">
              <input type="radio" name="theme" value="dark" hidden>
              Dark
            </label>
            <label class="p-a col-sm-6 black pointer m-0">
              <input type="radio" name="theme" value="black" hidden>
              Black
            </label>
          </div>
        </div>
      </div>

      <!--div class="switcher box-color black lt" id="sw-demo">
        <a href ui-toggle-class="active" target="#sw-demo" class="box-color black lt text-color sw-btn">
          <i class="fa fa-list text-white"></i>
        </a>
        <div class="box-header">
          <h2>Demos</h2>
        </div>
        <div class="box-divider"></div>
        <div class="box-body">
          <div class="row no-gutter text-u-c text-center _600 clearfix">
            <a href="dashboard.html"
            class="p-a col-sm-6 primary">
            <span class="text-white">Default</span>
          </a>
          <a href="dashboard.0.html"
          class="p-a col-sm-6 success">
          <span class="text-white">Zero</span>
        </a>
        <a href="dashboard.1.html"
        class="p-a col-sm-6 blue">
        <span class="text-white">One</span>
      </a>
      <a href="dashboard.2.html"
      class="p-a col-sm-6 warn">
      <span class="text-white">Two</span>
    </a>
    <a href="dashboard.3.html"
    class="p-a col-sm-6 danger">
    <span class="text-white">Three</span>
  </a>
  <a href="dashboard.4.html"
  class="p-a col-sm-6 green">
  <span class="text-white">Four</span>
</a>
<a href="dashboard.5.html"
class="p-a col-sm-6 info">
<span class="text-white">Five</span>
</a>
<div
class="p-a col-sm-6 lter">
<span class="text">...</span>
</div>
</div>
</div>
</div>
</div>
<!-- / -->

<!-- ############ LAYOUT END-->

</div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
<script src="libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
<script src="libs/jquery/tether/dist/js/tether.min.js"></script>
<script src="libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!--script src="libs/jquery/bootstrap/dist/js/bootstrap-modal.js"></script-->
<!-- core -->
<script src="libs/jquery/underscore/underscore-min.js"></script>
<script src="libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="libs/jquery/PACE/pace.min.js"></script>

<script src="html/scripts/config.lazyload.js"></script>
<script src="../libs/jquery/flot/jquery.flot.js"></script>
<script src="html/scripts/palette.js"></script>
<script src="html/scripts/ui-load.js"></script>
<script src="html/scripts/ui-jp.js"></script>
<script src="html/scripts/ui-include.js"></script>
<script src="html/scripts/ui-device.js"></script>
<script src="html/scripts/ui-form.js"></script>
<script src="html/scripts/ui-nav.js"></script>
<script src="html/scripts/ui-screenfull.js"></script>
<script src="html/scripts/ui-scroll-to.js"></script>
<script src="html/scripts/ui-toggle-class.js"></script>
<!--script src="https://github.com/flot/flot/blob/master/source/jquery.flot.axislabels.js"></script-->

<script src="html/scripts/app.js"></script>

<!-- ajax -->
<script src="libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="html/scripts/ajax.js"></script>
<script src="libs/jquery/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script type="text/javascript">
	function crearCadenaLineal(json){
		var parsed = JSON.parse(json);
		var arr = [];
		for(var x in parsed){
			arr.push(parsed[x]);
		}
		return arr;
	}
</script>
<script type="text/javascript">

	datosX1=crearCadenaLineal('<?php echo $datosX1 ?>');
	datosY1=crearCadenaLineal('<?php echo $datosY1 ?>');
  datosY2=crearCadenaLineal('<?php echo $datosY2 ?>');

	var trace1 = {
		x: datosX1,
		y: datosY1,
		type: 'scatter',
    mode: 'markers',
    name: 'In'
	};
  var trace2 = {
    x: datosX1,
    y: datosY2,
    type: 'scatter',
    mode: 'markers',
    name: 'Out'
  };
var data = [trace1, trace2];
  var layout = {
    title: 'Temperature',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: true,
    xaxis: {
    title: 'Time'},
    yaxis: {
    title: 'Temperature (C)'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal2', data, layout);
</script>
<script type="text/javascript">

	datosX1x=crearCadenaLineal('<?php echo $datosX1x ?>');
	datosY1x=crearCadenaLineal('<?php echo $datosY1x ?>');


	var trace1 = {
		x: datosX1x,
		y: datosY1x,
		type: 'scatter',
    mode: 'markers',
    name: 'Steam'
	};

var data = [trace1];
  var layout = {
    title: 'Steam loss',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: true,
    xaxis: {
    title: 'Time'},
    yaxis: {
    title: 'Steam (g)'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal1', data, layout);
</script>
<script type="text/javascript">

datosXs=crearCadenaLineal('<?php echo $datosXs ?>');
datosYs=crearCadenaLineal('<?php echo $datosYs ?>');


var trace1 = {
  x: datosXs,
  y: datosYs,
  type: 'scatter',
  mode: 'markers',
  name: 'Baseline'
};

var data = [trace1];
  var layout = {
    title: 'Pressure out',
    showlegend: true,
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: true,
    xaxis: {
    title: 'Time'},
    yaxis: {
    title: 'Pressure (psi)'},
    legend: {
    x: 1,
    xanchor: 'right',
    y: 1
  },
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal3', data, layout);
</script>
<script type="text/javascript">


/*
******************************
****** PROCESOS  *************
******************************
*/


function update_values(kw,kg,pre){
  $("#display_kw").html(kw);
  $("#display_kg").html(kg);
    $("#display_kwc").html(pre);
}

function process_msg(topic, message){
  // ej: "10,11,12"
  if (topic == "values"){
    var msg = message.toString();
    var sp = msg.split(" ");
    var kw = sp[6];
    var kg = sp[7];
    var pre = sp[8];
    update_values(kw,kg,pre);
  }
}

function ejemplo() {

  $('tr').each(function() {
      var suma = 0;
     $(this).find(".sumar").each(function() {
         suma += Number($(this).attr("dato"));
      });
      $(this).find(".total").first().text(suma);
  });

}
/*
******************************
****** CONEXION  *************
******************************
*/

// connect options
const options = {
      connectTimeout: 4000,

      // Authentication
      clientId: 'iotmc',
      username: 'web_client',
      password: '121212',

      keepalive: 60,
      clean: true,
}

var connected = false;

// WebSocket connect url
const WebSocket_URL = 'wss://zioning.ml:8094/mqtt'


const client = mqtt.connect(WebSocket_URL, options)


client.on('connect', () => {
    console.log('Mqtt conectado')

    client.subscribe('values', { qos: 0 }, (error) => {
      if (!error) {
        console.log('Suscripción exitosa!')
      }else{
        console.log('Suscripción fallida!')
      }
    })

    // publish(topic, payload, options/callback)
    client.publish('fabrica', 'esto es un verdadero éxito', (error) => {
      console.log(error || 'Mensaje de prueba enviado!!!')
    })
})


client.on('message', function (topic, message) {
 console.log('Mensaje recibido bajo tópico: ', topic, ' -> ', message.toString())
process_msg (topic, message)
 })

client.on('reconnect', (error) => {
    console.log('Error al reconectar', error)
})

client.on('error', (error) => {
    console.log('Error de conexión:', error)
})

</script>
<!-- endbuild -->
</body>
</html>
