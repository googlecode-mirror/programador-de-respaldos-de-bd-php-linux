<?php
require_once("Configuracion.php");

Class Funciones{
    
    public $conn = null;
    public $result;
    public $user;
    public $base_url;
    
     
    function __construct() {
        $this->base_url = '/srv/www/htdocs/ht/respaldosdb/';
        // Nothing to do
    }
    
    function connect($bd_server, $bd_user, $bd_pass){
        if($this->conn != null){
            mysql_close($this->conn);
        }
        $this->user = $bd_user;
        return $this->conn = mysql_connect($bd_server, $bd_user, $bd_pass);        
    }
    
    function query($string){
        return $this->result = mysql_query($string);
    }
    
    function to_array(){
        $arreglo = array();
        if(mysql_affected_rows()>0){
            while($row = mysql_fetch_assoc($this->result)){
                array_push($arreglo, $row);
            }
            return $arreglo;
        }else{
            return null;
        }
        
    }
    
    function to_row(){
        if(mysql_affected_rows($this->conn)>0){
            return mysql_fetch_assoc($this->result);
        }else{
            return null;
        }
    }
    
    function get_user(){
        return $this->user;
    }
    
    function show_databases(){
        $res = $this->query("SHOW DATABASES;");
        return $this->to_array();
    }
    function add_cron_line_dummy(){
        $p['minute'] = 28;
        $p['hour'] = "X";
        $p['day'] = "X";
        $p['month'] = "X";
        $p['week'] = "X";
        $p['command'] = "/srv/www/htdocs/ht/respaldosdb/bd_backup.sh";
        $p['db'] = "test";
        $p['host'] = "127.0.0.1";
        $p['user'] = "root";
        $p['pass'] = "empty";
        $p['type'] = "ftp";
        $p['url'] = "//148.223.203.134/Mantenimiento";
        $p['directory'] = "/";
        $p['ftp_user'] = "oalvarado";
        $p['ftp_passwd'] = "Vitriolo357";
  
        $this->add_cron_line($p);
    }
    
    function add_cron_line($p){
        $linea = $p['minute']." ".$p['hour']." ".$p['day']." ".$p['month']." ".$p['week']." ".$p['command']." ".$p['host']." ".$p['db']." ".$p['user']." ".$p['pass']." ".$p['type']." ".$p['url']." ".$p['directory']." ".$p['ftp_user']." ".$p['ftp_passwd'];
        echo $linea;
        //echo exec("whoami");
        echo exec($this->base_url."add_cron_resp.sh $linea");
        //$this->delete_cron();
    }
    
    function view_jobs(){
        return str_replace("~","<br />",system("crontab -l | tr '\n' '~'"));
            
    }
    
    function delete_jobs(){
        exec("crontab -r");
        exec("echo '#empty' > /tmp/emptycron");
        exec("crontab /tmp/emptycron");
        return true;
    }
}

?>