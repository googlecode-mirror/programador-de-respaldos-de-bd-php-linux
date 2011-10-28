<?php
include('Funciones.php');
include('Configuracion.php');
session_start();

if($_POST['f']=="connect"){
    $func = new Funciones();    
    $res = $func->connect($_POST['bd_server'],$_POST['bd_user'],$_POST['bd_password']);
    
    $_SESSION['func'] = serialize($func);
    if(!$res){
        $data['valid'] = 0;
        $data['msg'] = "No se pudo conectar a la base de datos.";
    }else{
        $data['valid'] = 1;
        $data['msg'] = "Conexión realizada con éxito.";
    }
    
    echo json_encode($data);
    
    
    
}else{
    if(isset($_POST['f'])){
        //$func = unserialize($_SESSION['func']);    
        switch ($_POST['f']){
            case 'show_databases':
                $func = new Funciones();
                $res = $func->connect($_POST['bd_server'],$_POST['bd_user'],$_POST['bd_password']);
                 if(!$res){
                    $data['valid'] = 0;
                    $data['msg'] = "No se pudo conectar a la base de datos.";
                }else{
                    //$data['valid'] = 1;
                    //$data['msg'] = "Conexión realizada con éxito.";
                    echo json_encode($func->show_databases());
                }           
                
                break;
            case 'add_dummy':
                echo json_encode($func->add_cron_line_dummy());
                break;
            case 'view_jobs':
                echo $func->view_jobs();
                break;
            case 'delete_jobs':
                echo $func->delete_jobs();
            case 'add_job':
                $_POST['command'] = $func->base_url."bd_backup.sh";
                echo $_POST['command'];
                foreach($_POST as $key => $value){
                    if($value == "") $_POST[$key] = "empty";
                }
                    
                echo $func->add_cron_line($_POST);
                break;
            default:
                echo "invalido";
        }
    }
}



?>
