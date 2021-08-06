#include <SPI.h>
#include <Ethernet.h>

//Ponemos la dirección MAC e IP que queremos que use nuestro Arduino para conectarse al Router
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress ip(192,168,1, 177); //Verificar direccion en

//Definimos que el puerto HTTP sera el 80
EthernetServer server(82);
EthernetClient client;

int estado;

void setup() {
//Iniciar la conexión de red y serie
Ethernet.begin(mac, ip);
server.begin();
Serial.begin(9600);

  // put your setup code here, to run once:
  pinMode(1, INPUT);  //EN MARCHA
  pinMode(2, INPUT);  //FALLA 1
  pinMode(3, INPUT);  //FALLA 2
  pinMode(4, INPUT);  //FALLA 3 
}

void loop() {
  if (digitalRead(1) == HIGH){
    estado = 0;
  }
  if (digitalRead(2) == HIGH){
    estado = 1;
  }
  if (digitalRead(3) == HIGH){
    estado = 2;
  }
  if (digitalRead(4) == HIGH){
    estado = 3;
  }
    Serial.print("GET /testcode/test-site2/BD.php?estado=");
    client.print("GET /testcode/test-site2/BD.php?estado=");     //YOUR URL
    Serial.println(estado);
    client.print(estado);
}
