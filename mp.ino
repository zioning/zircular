#include <SoftwareSerial.h>
#include <ModbusMaster.h>
#include <WiFi.h>
#include <PubSubClient.h>
//***** define section *****/
#define MAX485_DE1 32
#define MAX485_RE1 33
#define RX_PIN1 26  // connect to converter's RO wire
#define TX_PIN1 25  // connect to converter's DI wire
const uint8_t MODBUS_DEVICE_ID1 = 1;
const int led = 2;
const uint8_t FLOW_REGISTER1A = 33;
const uint8_t FLOW_DATA_SIZE = 4;
int ledState = LOW;
SoftwareSerial swSerial1(RX_PIN1, TX_PIN1);
ModbusMaster sensor1;
void preTransmission() {
  digitalWrite(MAX485_DE1, HIGH);
  digitalWrite(MAX485_RE1, HIGH);
  delay(10);
}

void postTransmission() {
  digitalWrite(MAX485_DE1, LOW);
  digitalWrite(MAX485_RE1, LOW);

  delay(10);
}
void initSoftwareSerial() {
  pinMode(MAX485_DE1, OUTPUT);
  pinMode(MAX485_RE1, OUTPUT);

  Serial.println("Welcome");
  swSerial1.begin(9600);
  sensor1.begin(MODBUS_DEVICE_ID1, swSerial1);
  sensor1.preTransmission(preTransmission);
  sensor1.postTransmission(postTransmission);
}
/*********************************************************************
 * Configuración y conexion a la red wifi
 */
const char* ssid     = "juan14paz";
const char* password = "DavidSan";

const long interval = 5000;
// unsigned long tiempo;
unsigned long start_time;
const int MQ_PIN = 13;      // Pin del sensor
const int RL_VALUE = 5;      // Resistencia RL del modulo en Kilo ohms
const int R0 = 10;          // Resistencia R0 del sensor en Kilo ohms

// Datos para lectura multiple
const int READ_SAMPLE_INTERVAL = 100;    // Tiempo entre muestras
const int READ_SAMPLE_TIMES = 5;       // Numero muestras

// Ajustar estos valores para vuestro sensor según el Datasheet
// (opcionalmente, según la calibración que hayáis realizado)
const float X0 = 200;
const float Y0 = 1.7;
const float X1 = 10000;
const float Y1 = 0.28;

// Puntos de la curva de concentración {X, Y}
const float punto0[] = { log10(X0), log10(Y0) };
const float punto1[] = { log10(X1), log10(Y1) };

// Calcular pendiente y coordenada abscisas
const float scope = (punto1[1] - punto0[1]) / (punto1[0] - punto0[0]);
const float coord = punto0[1] - punto0[0] * scope;

void setup()
{
   Serial.begin(9600);
   delay(500);
  // se inician las variables de tiempo
  tiempo = millis();
  start_time = millis();
  tiempoReconnect = millis();
   setup_wifi();
  initSoftwareSerial();
   client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
}

void loop()
{
   if (!client.connected()){
    reconnect();
  }
  client.loop();

  if (millis() - tiempo >= interval) {
    sensors.requestTemperatures();  //Se envía el comando para leer la temperatura
    postTransmission();             //recibo de la transmision del rs485 al esp32 para que configure la salida de transmision
   float rs_med = readMQ(MQ_PIN);      // Obtener la Rs promedio
   float concentration = getConcentration(rs_med/R0);   // Obtener la concentración
   
   // Mostrar el valor de la concentración por serial
   Serial.println("Concentración: ");
   Serial.println(concentration);
    Serial.println("Reading registers");
    
    uint8_t readRegister1 = sensor1.readHoldingRegisters(FLOW_REGISTER1A, FLOW_DATA_SIZE);
    float flow1 = steamFlow(readRegister1);
   

    muestreoADC();
    String variables[] = { String(concentration, 2), String(flow1, 2), nombre };
    int numberVariables = sizeof(variables) / sizeof(String);
    
    dataString(variables, numberVariables);
    Serial.println(mensaje);
    PublishData(mensaje);
    tiempo = millis();

}

// Obtener la resistencia promedio en N muestras
float readMQ(int mq_pin)
{
   float rs = 0;
   for (int i = 0;i<READ_SAMPLE_TIMES;i++) {
      rs += getMQResistance(analogRead(mq_pin));
      delay(READ_SAMPLE_INTERVAL);
   }
   return rs / READ_SAMPLE_TIMES;
}

// Obtener resistencia a partir de la lectura analogica
float getMQResistance(int raw_adc)
{
   return (((float)RL_VALUE / 1000.0*(1023 - raw_adc) / raw_adc));
}

// Obtener concentracion 10^(coord + scope * log (rs/r0)
float getConcentration(float rs_ro_ratio)
{
   return pow(10, coord + scope * log(rs_ro_ratio));
}
float steamFlow(uint8_t result) {
  uint8_t j;
  uint16_t buf[FLOW_DATA_SIZE];
  uint16_t temp;
  float flow;

  if (result == sensor1.ku8MBSuccess) {
    Serial.println("Correcto! Procesando...");
    for (j = 0; j < FLOW_DATA_SIZE; j++) {
      buf[j] = sensor1.getResponseBuffer(j);
      Serial.print(buf[j]);
      Serial.print(" ");
    }
    Serial.println("<- Bytes");
    // swap bytes because the data comes in Big Endian!
    temp = buf[1];
    buf[1] = buf[0];
    buf[0] = temp;
    // hand-assemble a single-precision float from the bytestream
    memcpy(&flow, &buf, sizeof(float));
    Serial.print("steam flow is ");
    Serial.println(flow, 6);
    delay(1500);
  } 
  else {
    Serial.print("Failuree. Code: ");
    Serial.println(result, HEX);
  }
  return flow;
  delay(10);
}

void setup_wifi() 
{
  delay(10);
  pinMode(led, OUTPUT);
  // Nos conectamos a nuestra red Wifi
  Serial.print("Conectando a ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) 
  {
    Serial.print(".");
    ledState = not(ledState);
    digitalWrite(led, ledState);
    delay(500);
  }

  Serial.println("");
  Serial.println("Conectado a red WiFi!");
  Serial.println("Direccion IP: ");
  Serial.println(WiFi.localIP());
}


/********************************************************************
 *  Funcion para volver a conectarse al servidor mqtt 
 */

const char *mqtt_server = "zioning.ml";
const int mqtt_port = 1883;
const char *mqtt_user = "web_client";
const char *mqtt_pass = "121212";

unsigned long tiempo;
unsigned long tiempoReconnect;

WiFiClient espClient;
PubSubClient client(espClient);

void reconnect() 
{
  while (!client.connected()) 
  {
    Serial.print("Intentando conexion Mqtt...");
    // Creamos un cliente ID
    String clientId = "esp32_";
    clientId += String(random(0xffff), HEX);
    // Intentamos conectar
    if (client.connect(clientId.c_str(), mqtt_user, mqtt_pass)) 
    {
      Serial.println("Conectado!");
      // Nos suscribimos
      client.subscribe("led1");
      client.subscribe("led2");
    }
    else 
    {
      if (tiempo > tiempoReconnect + 5000) 
      {
        Serial.print("fallo :( con error -> ");
        Serial.print(client.state());
        Serial.println(" Intentamos de nuevo en 5 segundos");
        tiempoReconnect = millis();
      }
    }
  }
}


/********************************************************************/
void callback(char* topic, byte* payload, unsigned int length) 
{
  String incoming = "";
  Serial.print("Mensaje recibido desde -> ");
  Serial.print(topic);
  Serial.println("");
  //for (int i = 0; i < length; i++) {
  //incoming += (char)payload[i];
  //}
  incoming.trim();
  Serial.println("Mensaje -> " + incoming);
}
