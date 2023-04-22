var mysql = require('mysql');
var mqtt = require('mqtt');
//CREDENCIALES MYSQL
var con = mysql.createConnection({
  host: "****.com",
  user: "admin_iot",
  password: "******",
  database: "admin_iot"
});
//CREDENCIALES MQTT
var options = {
  port: 1883,
  host: '*****.com',
  clientId: 'acces_control_server_' + Math.round(Math.random() * (0- 10000) * -1) ,
  username: 'web_client',
  password: '121212',
  keepalive: 60,
  reconnectPeriod: 10000,
  protocolId: 'MQIsdp',
  protocolVersion: 3,
  clean: true,
  encoding: 'utf8'
};

var client = mqtt.connect("mqtt://*****.com", options);

//SE REALIZA LA CONEXION
client.on('connect', function () {
  console.log("Conexión  MQTT Exitosa!");
  client.subscribe('+/#', function (err) {
    console.log("Subscripción exitosa!")
  });
})

//CUANDO SE RECIBE MENSAJE
client.on('message', function (topic, message) {
  console.log("Mensaje recibido desde -> " + topic + " Mensaje -> " + message.toString());
  if (topic == "values"){
    var msg = message.toString();
    var sp = msg.split(" ");
    //var temp1 = sp[0];
    //var temp2 = sp[1];
    var volts1 = 120.01+ Math.round(Math.random() * (0- 10) * -1);
    var corriente1 =  13.01+ Math.round(Math.random() * (0- 2) * -1);
    var frecuencia = 60.01+ Math.round(Math.random() * (0- 1) * -1);
    var fc1 =  0.98;
    var kg = 20.01+ Math.round(Math.random() * (0- 10) * -1);
    var pre = 40.01+ Math.round(Math.random() * (0- 10) * -1);
    var prekg = 42.71+ Math.round(Math.random() * (0- 10) * -1);
    var volts2 = 124.01+ Math.round(Math.random() * (0- 10) * -1);
    var corriente2 = 40.22+ Math.round(Math.random() * (0- 5) * -1);
    var fc2 =  0.99;
    var volts3 = 126.55+ Math.round(Math.random() * (0- 10) * -1);
    var corriente3 = 44.82 + Math.round(Math.random() * (0 - 8) * -1);
    var fc3 =  0.97;
    var potencia = 32.2;
    var fpt = 0.98;
    var eri = 3+ Math.round(Math.random() * (0- 10) * -1);
    var ea = 2;
    var erc = 2+ Math.round(Math.random() * (0- 10) * -1);
    var cn = 85 + Math.round(Math.random() * (0 - 10) * -1);
    var thdv1 = 1.2+ Math.round(Math.random() * (0- 10) * -1);
    var thdv2 = 1.4+ Math.round(Math.random() * (0- 7) * -1);
    var thdv3 = 1.8+ Math.round(Math.random() * (0- 5) * -1);
    var thdi1 = 1.1+ Math.round(Math.random() * (0- 11) * -1);
    var thdi2 = 1.5+ Math.round(Math.random() * (0- 13) * -1);
    var thdi3 = 1.9+ Math.round(Math.random() * (0- 9) * -1);
    var fn1 = 10 + Math.round(Math.random() * (30 - 100) * -1);
    var a31 = 1;
    //  if (sp[2]>=1.45) {var cn = 0;}
    //else if (sp[2]>1.44) {var cn = 10;}
    //else if (sp[2]>1.43) {var cn = 20;}
    //else if (sp[2]>1.42) {var cn = 30;}
    //else if (sp[2]>1.41) {var cn = 40;}
    //else if (sp[2]>1.4) {var cn = 50;}
    //else if (sp[2]>1.39) {var cn = 60;}
    //else if (sp[2]>1.38) {var cn = 70;}
    //else if (sp[2]>1.37) {var cn = 80;}
    //else if (sp[2]>1.36) {var cn = 90;}
    //else if (sp[2]>1.35) {var cn = 100;}
    //else if (sp[2]>1.34) {var cn = 110;}
    //else if (sp[2]>1.33) {var cn = 120;}
    //else if (sp[2]>1.32) {var cn = 130;}
    //else if (sp[2]>1.31) {var cn = 140;}
    //else if (sp[2]>1.3) {var cn = 150;}
    //else {var cn = 0;}
    //if (sp[2]>=1)     {var fn1 = 0;}
    //else if (sp[2]>0.95) {var fn1 = 30;}
    //else if (sp[2]>0.90) {var fn1 = 35;}
    //else if (sp[2]>0.85) {var fn1 = 40;}
    //else if (sp[2]>0.80) {var fn1 = 45;}
    //else if (sp[2]>0.75)  {var fn1 = 50;}
    //else if (sp[2]>0.70) {var fn1 = 55;}
    //else if (sp[2]>0.65) {var fn1 = 60;}
    //else if (sp[2]>0.60) {var fn1 = 75;}
    //else if (sp[2]>0.55) {var fn1 = 90;}
    //else if (sp[2]>0.50) {var fn1 = 100;}
    //else if (sp[2]>0.45) {var fn1 = 110;}
    //else if (sp[2]>0.40) {var fn1 = 120;}
    //else if (sp[2]>0.35) {var fn1 = 130;}
    //else if (sp[2]>0.30) {var fn1 = 140;}
    //else if (sp[2]>0.25)  {var fn1 = 150;}
    //else {var fn1 = 0;}
  //  var a51 = sp[27];
//   var fn2 = sp[28];
  //  var a32 = sp[29];
  //  var a52 = 1;
  //  var fn3 = sp[31];
  //  var a33 = sp[32];
  //  var a53 = sp[33];
//    var a31i = 1;
//    var a51i = 1;
//    var a32i = sp[36];
//    var a52i = 1;
//    var a33i = 1;
//    var a53i = sp[39];
    //  var maxv1 = [29];
      //var maxv2 = [30];
      //var maxv3 = [31];
      //var minv1 = [32];
      //var minv2 = [33];
      //var minv3 = [34];
      //var maxi1 = [35];
      //var maxi2 = [36];
      //var maxi3 = [37];
      //var mini1 = [38];
      //var mini2 = [39];
      //var mini3 = [40];

    //hacemos la consulta para insertar....
       var query = "INSERT INTO `admin_iot`.`alucol` (`data_volts1`, `data_corriente1`, `data_frecuencia`, `data_factor1`, `data_kg`, `data_pre`, `data_prekg`, `data_volts2`, `data_corriente2`, `data_factor2`, `data_volts3`, `data_corriente3`, `data_factor3`, `data_kw3`, `data_fpt`, `data_eri`, `data_ea`, `data_erc`, `data_cn`, `data_thdv1`, `data_thdv2`, `data_thdv3`, `data_thdi1`, `data_thdi2`, `data_thdi3`, `data_fn1`, `data_a31`) VALUES (" + volts1 +", " + corriente1 +", " + frecuencia +", " + fc1 +", " + kg +", " + pre +", " + prekg + ", " + volts2 +", " + corriente2 +", " + fc2 +", " + volts3 +", " + corriente3 +", " + fc3 +", " + potencia +", " + fpt +", " + eri +", " + ea +", " + erc +", " + cn +", " + thdv1 +", " + thdv2 +", " + thdv3 +", " + thdi1 +", " + thdi2 +", " + thdi3 +"," + fn1 +"," + a31 +");";
       con.query(query, function (err, result, fields) {
         if (err) throw err;
         console.log("Fila insertada correctamente");
       });
     }
   });
   // var query = "INSERT INTO `admin_iot`.`alucol` (`data_temp1`, `data_temp2`, `data_volts1`, `data_corriente1`, `data_frecuencia`, `data_factor1`, `data_kw1`, `data_kg`, `data_pre`, `data_prekg`, `data_volts2`, `data_corriente2`, `data_factor2`, `data_kw2`, `data_volts3`, `data_corriente3`, `data_factor3`, `data_kw3`, `data_fpt`, `data_eri`, `data_ea`, `data_erc`, `data_cn`, `data_thdv1`, `data_thdv2`, `data_thdv3`, `data_thdi1`, `data_thdi2`, `data_thdi3`, `data_maxv1`, `data_maxv2`, `data_maxv3`, `data_maxi1`, `data_maxi2`, `data_maxi3`, `data_minv1`, `data_minv2`, `data_minv3`, `data_mini1`, `data_mini2`, `data_mini3`, `data_fn1`, `data_a31`, `data_a51`, `data_a71`, `data_a91`, `data_fn2`, `data_a32`, `data_a52`, `data_a72`, `data_a92`, `data_fn3`, `data_a33`, `data_a53`, `data_a73`, `data_a93`) VALUES (" + temp1 + ", " + temp2 + ", " + volts1 +", " + corriente1 +", " + frecuencia +", " + fc1 +", " + potencia1 +", " + kg +", " + pre +", " + prekg + ", " + volts2 +", " + corriente2 +", " + fc2 +", " + potencia2 +", " + volts3 +", " + corriente3 +", " + fc3 +", " + potencia3 +", " + fpt +", " + eri +", " + ea +", " + erc +", " + cn +", " + thdv1 +", " + thdv2 +", " + thdv3 +", " + thdi1 +", " + thdi2 +", " + thdi3 +"," + maxv1 +"," + maxv2 +"," + maxv3 +"," + maxi1 +"," + maxi2 +"," + maxi3 +"," + minv1 +"," + minv2 +"," + minv3 +"," + mini1 +"," + mini2 +"," + mini3 +"," + fn1 +"," + a31 +"," + a51 +"," + a71 +"," + a91 +"," + fn2 +"," + a32 +"," + a52 +"," + a72 +"," + a92 +"," + fn3 +"," + a33 +"," + a53 +"," + a73 +"," + a93 +");";

//nos conectamos
con.connect(function(err){
  if (err) throw err;

  //una vez conectados, podemos hacer consultas.
  console.log("Conexión a MYSQL exitosa!!!")

  //hacemos la consulta
  var query = "SELECT * FROM devices WHERE 1";
  con.query(query, function (err, result, fields) {
    if (err) throw err;
    if(result.length>0){
      console.log(result);
    }
  });

});


  //para mantener la sesión con mysql abierta
  setInterval(function () {
    var query ='SELECT 1 + 1 as result';

    con.query(query, function (err, result, fields) {
      if (err) throw err;
    });

  }, 5000);
