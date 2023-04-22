<?php
session_start();
$logged = $_SESSION['logged'];

if(!$logged){
  echo "Ingreso no autorizado";
  die();
}

//$devices = $_SESSION['devices'];

//momento de conectarnos a db
$conn = mysqli_connect("localhost","admin_iot","75543ZIONING","admin_iot");

//$array = array();

//foreach ($devices as $device ) {
//  array_push($array,$device['devices_serie']);
//}
// Variable de declaración en segundos
//$ActualizarDespuesDe = 5;

// Envíe un encabezado Refresh al navegador preferido.
//header('Refresh: '.$ActualizarDespuesDe);

//$matches = implode(',', $array);

$consulta = "SELECT * FROM alucol ORDER BY data_id DESC LIMIT 10";
$resultado=mysqli_query($conn,$consulta);
$consultag1 = "SELECT data_date,data_kw3 FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadog1=mysqli_query($conn,$consultag1);
$valoresY1=array();
$valoresX1=array();
while ($ver1=mysqli_fetch_row($resultadog1)) {
$valoresX1[]=$ver1[0];
$valoresY1[]=$ver1[1];
}
$datosX1=json_encode($valoresX1);
$datosY1=json_encode($valoresY1);

$consultag2 = "SELECT data_date,data_ea FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadog2=mysqli_query($conn,$consultag2);
$valoresY2=array();
$valoresX2=array();
while ($ver2=mysqli_fetch_row($resultadog2)) {
$valoresX2[]=$ver2[0];
$valoresY2[]=$ver2[1];
}
$datosX2=json_encode($valoresX2);
$datosY2=json_encode($valoresY2);


$consultag5 = "SELECT data_date,data_cn FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadog5=mysqli_query($conn,$consultag5);
$valoresY5=array();
$valoresX5=array();
while ($ver5=mysqli_fetch_row($resultadog5)) {
$valoresX5[]=$ver5[0];
$valoresY5[]=$ver5[1];
}
$datosX5=json_encode($valoresX5);
$datosY5=json_encode($valoresY5);

$consultag6 = "SELECT data_date,data_fn1 FROM alucol ORDER BY data_date DESC LIMIT 30";
$resultadog6=mysqli_query($conn,$consultag6);
$valoresY6=array();
$valoresX6=array();
while ($ver6=mysqli_fetch_row($resultadog6)) {
$valoresX6[]=$ver6[0];
$valoresY6[]=$ver6[1];
}
$datosX6=json_encode($valoresX6);
$datosY6=json_encode($valoresY6);

$consultag7 = "SELECT pre_date,prereal FROM prediccioncosto ORDER BY pre_date DESC LIMIT 1";
$resultadog7=mysqli_query($conn,$consultag7);
//print_r($ver[0],$ver[1]);
//die();
//$resultado = $conn->query($consulta);
//if (!$resultado) {
  //  $mensaje  = "Consulta no válida: " . mysqli_error();
  //  $mensaje .= "Consulta completa: " . $consulta;
  //  die($mensaje);
//}
if(isset($_POST[“export_data”])) {

if(!empty($data)) {

$filename = “tabla.xlsx”;

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");

header("Content-Disposition: attachment; filename=".$filename);

$mostrar_columnas = false;

foreach($data as $libro) {

if(!$mostrar_columnas) {

echo implode(“\t”, array_keys($libro)) . “\n”;

$mostrar_columnas = true;

}

echo implode(“\t”, array_values($libro)) . “\n”;

}


}else{

echo 'No hay datos a exportar';

}

exit;

}
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
              <a class="nav-link p-0 clear" href="https://zioning.com/" data-toggle="">
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
            &copy; Copyright <strong></strong><span class="hidden-xs-down">2022</span>
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
                            <i class="fa fa-sun-o"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Temperature 1: <b id="display_t1">--</b><span class="text-sm"> F</span></h4>
                          <small class="text-muted">Before</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded primary">
                            <i class="fa fa-cloud"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Temperature 2: <b id="display_t2">--</b><span class="text-sm"> F</span></h4>
                          <small class="text-muted">After</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded warn">
                            <i class="fa fa-cube"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Trap state: <b id="display_p0">Sin falla </b><span class="text-sm"> </span></h4>
                          <small class="text-muted">State</small>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded  accent">
                            <i class="fa fa-sun-o"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Pressure 1: <b id="display_p1">--</b><span class="text-sm"> psi</span></h4>
                          <small class="text-muted">Before</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                      <div class="box p-a">
                        <div class="pull-left m-r">
                          <span class="w-48 rounded primary">
                            <i class="fa fa-cloud"></i>
                          </span>
                        </div>
                        <div class="clear">
                          <h4 class="m-0 text-lg _300">Pressure 2: <b id="display_p2">--</b><span class="text-sm"> psi</span></h4>
                          <small class="text-muted">After</small>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- SWItCH1 y 2 -->
                  <!--div class="row">
                    <!-- SWItCH1 -->
                    <!--div class="col-xs-12 col-sm-6">
                      <div class="box p-a">
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label">Notificación</label>
                          <div class="col-sm-10">
                            <label class="ui-switch ui-switch-md info m-t-xs">
                              <input id="input_led1" onchange="process_led1()"  type="checkbox">

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

                  <div class="row">
             <div class="col text-left">
               <input type ='button' class="btn btn-fw info" value = 'Generate table last 10 days' onclick="window.open('pdf.php');"/>
               </a>
             </div>
           </div>
           <div class="row">

    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">

                          <h2>Data table</h2>

                        </div>
                        <div class="box-divider m-0"></div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Temperature 1 (C)</th>
                              <th>Temperature 2 (C)</th>
                              <th>Pressure 1 (psi)</th>
                              <th>Pressure 2 (psi) </th>
                            </tr>
                          </thead>
                          <tbody>

  <?php

   while($mostrar = mysqli_fetch_array($resultado)){
     ?>
                            <tr>
                              <td><?php echo $mostrar['data_date'] ?></td>
                              <td><?php echo $mostrar['data_kw3'] ?></td>
                              <td><?php echo $mostrar['data_ea'] ?></td>
                              <td><?php echo $mostrar['data_cn'] ?></td>
                              <td><?php echo $mostrar['data_fn1'] ?></td>
                            </tr>
                            <?php } ?>

                          </tbody>
                        </table>
                  </div>

  <!-- GRAFICAS -->
  <div class="row">
      <div class="col-sm-6">
        <div class="box">
<div id="graficaLineal1"></div>

        </div>
      </div>
      <div class="col-sm-6">
        <div class="box">

<div id="graficaLineal2"></div>
        </div>
      </div>
    </div>
      <div class="row">
          <div class="col-sm-6">
            <div class="box">
  <div id="graficaLineal5"></div>

            </div>
          </div>
          <div class="col-sm-6">
            <div class="box">

  <div id="graficaLineal6"></div>
            </div>
          </div>
        </div>




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

<!-- core -->
<script src="libs/jquery/underscore/underscore-min.js"></script>
<script src="libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="libs/jquery/PACE/pace.min.js"></script>

<script src="html/scripts/config.lazyload.js"></script>

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

<script src="html/scripts/app.js"></script>

<!-- ajax -->
<script src="libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="html/scripts/ajax.js"></script>
<script src="libs/jquery/jquery/dist/jquery.min.js"></script>
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

	var trace1 = {
		x: datosX1,
		y: datosY1,
		type: 'scatter'
	};

	var data = [trace1];
  var layout = {
    title: 'Temperature 1 (F)',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: false,
    xaxis: {
    title: 'Time'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal1', data, layout);
</script>
<script type="text/javascript">

	datosX2=crearCadenaLineal('<?php echo $datosX2 ?>');
	datosY2=crearCadenaLineal('<?php echo $datosY2 ?>');

	var trace1 = {
		x: datosX2,
		y: datosY2,
		type: 'scatter'
	};

	var data = [trace1];
  var layout = {
    title: 'Temperature 2 (F)',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: false,
    xaxis: {
    title: 'Time'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal2', data, layout);
</script>

<script type="text/javascript">

	datosX5=crearCadenaLineal('<?php echo $datosX5 ?>');
	datosY5=crearCadenaLineal('<?php echo $datosY5 ?>');

	var trace1 = {
		x: datosX5,
		y: datosY5,
		type: 'scatter'
	};

	var data = [trace1];
  var layout = {
    title: 'Pressure 1 (psi)',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: false,
    xaxis: {
    title: 'Time'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal5', data, layout);
</script>

<script type="text/javascript">

	datosX6=crearCadenaLineal('<?php echo $datosX6 ?>');
	datosY6=crearCadenaLineal('<?php echo $datosY6 ?>');

	var trace1 = {
		x: datosX6,
		y: datosY6,
		type: 'scatter'
	};
	var data = [trace1];
  var layout = {
    title: 'Pressure 2 (psi)',
    plot_bgcolor:"FFFFFF",
      paper_bgcolor:"#FFFFFF",
    showlegend: false,
    xaxis: {
    title: 'Time'},
    font: {
    color: '#000000'
  }}

	Plotly.newPlot('graficaLineal6', data, layout);
</script>


<script type="text/javascript">
function process_led1(){
if ($('#input_led1').is(":checked")){
<?php echo include ("sendemail.php") ?>
  }
  }
</script>
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script type="text/javascript">


/*
******************************
****** PROCESOS  *************
******************************
*/


function update_values(t1,t2,p1,p2){

  $("#display_t1").html(t1);
  $("#display_t2").html(t2);
  $("#display_p1").html(p1);
  $("#display_p2").html(p2);
}


function process_msg(topic, message){

  if (topic == "values"){
    var msg = message.toString();
    var sp = msg.split(" ");
      var t1 = Math.round(((sp[0]*9)/5)+32,2);
      var t2 = Math.round(((sp[1]*9)/5)+32,2);
      var p1 = 80+ Math.round(Math.random() * (0- 15) * -1);
    //if (sp[2]>=1.45) {var p2 = 0;}
    //else if (sp[2]>1.44) {var p2 = 10;}
    //else if (sp[2]>1.43) {var p2 = 20;}
    //else if (sp[2]>1.42) {var p2 = 30;}
    //else if (sp[2]>1.41) {var p2 = 40;}
    //else if (sp[2]>1.4) {var p2 = 50;}
    //else if (sp[2]>1.39) {var p2 = 60;}
    //else if (sp[2]>1.38) {var p2 = 70;}
    //else if (sp[2]>1.37) {var p2 = 80;}
    //else if (sp[2]>1.36) {var p2 = 90;}
    //else if (sp[2]>1.35) {var p2 = 100;}
    //else if (sp[2]>1.34) {var p2 = 110;}
    //else if (sp[2]>1.33) {var p2 = 120;}
    //else if (sp[2]>1.32) {var p2 = 130;}
    //else if (sp[2]>1.31) {var p2 = 140;}
    //else if (sp[2]>1.3) {var p2 = 150;}
    //else {var p2 = 0;}
      //p1=p1.toFixed(2);
      var p2 = 10 + Math.round(Math.random() * (30 - 100) * -1);
      //p2=p2.toFixed(2);
      //if (sp[3]>=1.45) {var p2 = 0;}
      //else if (sp[3]>1.44) {var p2 = 10;}
      //else if (sp[3]>1.43) {var p2 = 20;}
      //else if (sp[3]>1.42) {var p2 = 30;}
      //else if (sp[3]>1.41) {var p2 = 40;}
      //else if (sp[3]>1.4)  {var p2 = 50;}
      //else if (sp[3]>1.39) {var p2 = 60;}
      //else if (sp[3]>1.38) {var p2 = 70;}
      //else if (sp[3]>1.37) {var p2 = 80;}
      //else if (sp[3]>1.36) {var p2 = 90;}
      //else if (sp[3]>1.35) {var p2 = 100;}
      //else if (sp[3]>1.34) {var p2 = 110;}
      //else if (sp[3]>1.33) {var p2 = 120;}
      //else if (sp[3]>1.32) {var p2 = 130;}
      //else if (sp[3]>1.31) {var p2 = 140;}
      //else if (sp[3]>1.3) {var p2 = 150;}
      //else {var p2 = 0;}
    update_values(t1,t2,p1,p2);
  }
}


function process_led1(){
  if ($('#input_led1').is(":checked")){
 console.log("Encendido");


    client.publish('led1', 'on', (error) => {
      console.log(error || 'Mensaje enviado!!!')
    })
  }else{
    console.log("Apagado");
    client.publish('led1', 'off', (error) => {
      console.log(error || 'Mensaje enviado!!!')
    })
  }
}

function process_led2(){
  if ($('#input_led2').is(":checked")){
    console.log("Encendido");

    client.publish('led2', 'on', (error) => {
      console.log(error || 'Mensaje enviado!!!')
    })
  }else{
    console.log("Apagado");
    client.publish('led2', 'off', (error) => {
      console.log(error || 'Mensaje enviado!!!')
    })
  }
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
      clientId: 'iotmc1',
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
  //  client.publish('fabrica', 'esto es un verdadero éxito', (error) => {
  //   console.log(error || 'Mensaje de prueba enviado!!!')
    //})
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
