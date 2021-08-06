<?php
include '../../config.php';
class MySQL{
    private $oConbd = null;

    public  function__constructor(){
        global $mysql_servidor,$mysql_usuario,$mysql_clave,$mysql_base
        $this->$mysql_servidor = $mysql_servidor;
        $this->$mysql_usuario = $mysql_usuario;
        $this->$mysql_clave = $mysql_clave;
        $this->$mysql_base = $mysql_base;
    }
// public function conBDPDO()
// {
//     try {
//         $this->$oConBD = new PDO("mysql:host=" . $this-)
//     } catch (\Throwable $th) {
//         //throw $th;
//     }
// }
// }
?>