#include <ESP8266WiFi.h>
#include <WiFiClient.h> 

//-------------------VARIABLES GLOBALES--------------------------
int contconexion = 0;

const char* ssid = "miguelangel";
const char* password = "jesus1778"; 

unsigned long previousMillis = 0;

char host[48];
String strhost = "192.168.0.13";
String strurl = "/testcode/test-site2/BD.php";
String chipid = "";

String estado_normal = "0";
String estado_falla_1 = "1";
String estado_falla_2 = "2";
String estado_falla_3 = "3";


//entradas
static const uint8_t pin_pieza_faltantes = 16;
static const uint8_t pin_pieza_fallida = 5;
static const uint8_t pin_pieza_tiempo = 4;
static const uint8_t pin_marcha = 14;


//salidas
int pin_falla_1 = 12;
int pin_falla_2 = 13;
int pin_falla_3 = 0;
int pin_normal = 15;


boolean bool_equipoParado = false;


//-------Función para Enviar Datos a la Base de Datos SQL--------
String enviardatos(String datos) {
  String linea = "error";
  WiFiClient client;
  strhost.toCharArray(host, 49);
  if (!client.connect(host, 8080)) {            //CAMBIAR SEGUN XAMPP PUERTO
    Serial.println("Fallo de conexion");
    return linea;
  }

      Serial.println("Conectado con Base de Datos");      
        
client.print(String("POST ") + strurl + " HTTP/1.1" + "\r\n" + 
               "Host: " + strhost + "\r\n" +
               "Accept: */*" + "*\r\n" +
               "Content-Length: " + datos.length() + "\r\n" +
               "Content-Type: application/x-www-form-urlencoded" + "\r\n" +
               "\r\n" + datos);           
  delay(10); 
  
  Serial.print("Enviando datos a SQL...");
  
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println("Cliente fuera de tiempo!");
      client.stop();
      return linea;
    }
  }
  // Lee todas las lineas que recibe del servidro y las imprime por la terminal serial
  while(client.available()){
    linea = client.readStringUntil('\r');
  }  
  Serial.println(linea);
  return linea;
}

//-------------------------------------------------------------------------

void setup() {

  // Inicia Serial
  Serial.begin(115200);
  Serial.println("");

  Serial.print("chipId: "); 
  chipid = String(ESP.getChipId());
  Serial.println(chipid); 

  // Conexión WIFI
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion <50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
  if (contconexion <50) {
      //para usar con ip fija
      IPAddress ip(192,168,0,156); 
      IPAddress gateway(192,168,0,1); 
      IPAddress subnet(255,255,255,0); 
      WiFi.config(ip, gateway, subnet); 
      
      Serial.println("");
      Serial.println("WiFi conectado");
      Serial.println(WiFi.localIP());
  }
  else { 
      Serial.println("");
      Serial.println("Error de conexion");
  }


  pinMode(pin_falla_1,OUTPUT);
  pinMode(pin_falla_2,OUTPUT);
  pinMode(pin_falla_3,OUTPUT);
  pinMode(pin_normal,OUTPUT);

  digitalWrite(pin_normal,LOW);
  digitalWrite(pin_falla_1,LOW);
  digitalWrite(pin_falla_2,LOW);
  digitalWrite(pin_falla_3,LOW);

  pinMode(2, OUTPUT);  //SALIDA HACIA CONTACTOR DE LINEA
}

//--------------------------LOOP--------------------------------
void loop() {

   if(digitalRead(pin_pieza_faltantes)&&bool_equipoParado==false){
      Serial.println("FALLA 1 ACTIVA");
      bool_equipoParado = true;
      digitalWrite(2, LOW);
      digitalWrite(pin_falla_1,HIGH);    
      digitalWrite(pin_normal,LOW);  
      enviardatos("estado=" + estado_falla_1);      
    } else if(digitalRead(pin_pieza_fallida)&&bool_equipoParado==false){
         Serial.println("FALLA 2 ACTIVA");
      bool_equipoParado = true;
      digitalWrite(2, LOW);
      digitalWrite(pin_falla_2,HIGH);
      digitalWrite(pin_normal,LOW);
      enviardatos("estado=" + estado_falla_2);
    } else if(digitalRead(pin_pieza_tiempo)&&bool_equipoParado==false){
         Serial.println("FALLA 3 ACTIVA");
      bool_equipoParado = true;
      digitalWrite(2, LOW);
      digitalWrite(pin_falla_3,HIGH);
      digitalWrite(pin_normal,LOW);
      enviardatos("estado=" + estado_falla_3);
    } else if(digitalRead(pin_marcha)){
      bool_equipoParado = false;
      
         Serial.println("EQUIPO NORMAL");
      digitalWrite(pin_normal,HIGH);
      digitalWrite(pin_falla_1,LOW);
      digitalWrite(pin_falla_2,LOW);
      digitalWrite(pin_falla_3,LOW);
      enviardatos("estado=" + estado_normal);
       digitalWrite(2, HIGH);
    } 
    
    
    
   
    
}
