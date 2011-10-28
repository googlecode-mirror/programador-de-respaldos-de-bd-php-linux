<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Respaldos de Base de Datos</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/typography.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>

<!--[if lte IE 6]>
<style type="text/css">
.clearfix {height: 1%;}
img {border: none;}
#resol {position:absolute;} body {overflow-x: hidden;} 
</style>
<![endif]-->
<!--[if gte IE 7.0]>
<style type="text/css">
.clearfix {display: inline-block;}
</style>
<![endif]-->

</head>
<body>
    
<script type="text/javascript">
$(document).ready(function(){
    $("#dat_fecha").datepicker();
    $("#jobs").dialog({autoOpen:false});

    $("#btn_deletejobs").click(function(){
        $.ajax({
            url:'fnc/core.php',
            type:'post',
            data:{
                f: 'delete_jobs'
            },
            dataType:'json',
            success:function(data){
                alert("Trabajos eliminados")
            }
        });
    });
    $("#btn_viewjobs").click(function(){
        $.ajax({
            url: 'fnc/core.php',
            data: {
                f: 'view_jobs'
            },
            type: 'post',
            dataType:'html',           
            success:function(data){
                $("#jobs").html("<p>" + data + "</p>");
                $("#jobs").dialog('open');
            }
        });
    });
    $("#dir_tipo").click(function(){
        if($("#dir_tipo").val()=="ftp"){
            $("#div_ftp").show();
            $("#div_win").hide();
        }
        
        if($("#dir_tipo").val()=="win"){
            $("#div_win").show();
            $("#div_ftp").hide();
        }
    });
    
    $("#save_cron").click(function(){
        var urld
        
        if($("#dir_tipo").val()=="ftp"){
            urld = $("#ftp_host").val()
            $("#dir_win").val("");
            
        }
        if($("#dir_tipo").val()=="win"){
            urld = $("#dir_win").val()
            $("#ftp_host").val("")
            $("#ftp_user").val("")
            $("#ftp_pass").val("")
            
        }
        
        
        if($("#bd_server").val()==""){
            alert("Debe introducir la ip del servidor de MySQL");
            return;
        }
        if($("#bd_user").val()==""){
            alert("Debe introducir el usuario del servidor de MySQL");
            return;
        }
        $.ajax({
            url: 'fnc/core.php',
            data:{
                f:'add_job',
                minute: $("#cron_minute").val(),
                hour: $("#cron_hour").val(),
                day: $("#cron_day").val(),
                month: $("#cron_month").val(),
                week: $("#cron_week").val(),
                db: $("#bd_name").val(),                
                host: $("#bd_server").val(),
                user: $("#bd_user").val(),
                pass: $("#bd_password").val(),
                type: $("#dir_tipo").val(),
                url: urld,
                directory: $("#resp_destino").val(),
                ftp_user: $("#ftp_user").val(),
                ftp_passwd: $("#ftp_pass").val()
            },
            type:'post',
            dataType:'json',
            success:function(data){
                alert(data)
            }
        });
    });
    
    $("#btn_consult").click(function(){
        $.ajax({
            url: 'fnc/core.php',
            data:{
                f:'show_databases',
                bd_server: $("#bd_server").val(),
                bd_user: $("#bd_user").val(),
                bd_password: $("#bd_password").val()
                
            },
            type:'post',
            dataType:'json',
            success:function(json){
                if(json.valid==0){
                    alert("No se pudo conectar");
                    return;
                }
            
                $("#bd_name").html(""); 
                $.each(json,function(i,value){
                    //console.log(value.Database)
                  //  alert(value.Database)
                  
                  $("#bd_name").append($('<option>').text(value.Database).attr('value', value.Database));   
                });
            }
        });
    });
    
    
    /*$("#btn_connect").click(function(){
           $.ajax({
               url: 'fnc/core.php',
               data: {
                   f: 'connect',
                   bd_server: $("#bd_server").val(),
                   bd_user: $("#bd_user").val(),
                   bd_password: $("#bd_password").val()
                   
               },
               type:'post',
               dataType:'json',
               success:function(data){
                   if(data.valid){
                       alert(data.msg)
                   }else{
                       alert(data.msg)
                   }
               }
           });
           
       });*/
});

</script>
<div id="mainwrap">
<!--BEGIN OF TERMS OF USE. DO NOT EDIT OR DELETE THESE LINES. IF YOU EDIT OR DELETE THESE LINES AN ALERT MESSAGE MAY APPEAR WHEN TEMPLATE WILL BE ONLINE-->
 
<!--END OF TERMS OF USE-->
<div id="jobs" name="jobs">ABC</div>
<div id="mainnav-wrap" class="wrap">
    <div id="mainnav" class="pagesize clearfix">
    	<div class="vernav">
            <ul class="clearfix">
                <li><a href="?" id="active"><span>Inicio</span></a></li>                
            </ul>
        </div>
    </div>
</div>
<div id="container-wrap" class="wrap">
    <div id="container" class="pagesize clearfix">
    	<div id="leftcol">
        	<div class="inner">
            	<p>Sistema de Respaldos de Bases de Datos</p>
            </div>
        </div>
        <div id="maincol">
        	
            <div id="content-wrap">
            	<div id="content" class="clearfix">
                	<h3 class="yellow f14">Respaldos</h3>
                        <p>
                            <table border="0">
                                <tr><td>
                                        <table border="1">
                                            <tr><td>Servidor</td><td>
                                                    <input type="text" id="bd_server" name="bd_server" />
                                                </td></tr>
                                            <tr><td>Usuario</td><td>
                                                    <input type="text" id="bd_user" name="bd_user" />
                                                </td></tr>
                                            <tr><td>Password</td><td>
                                                    <input type="text" id="bd_password" name="bd_password" />                                                    
                                                </td></tr>
                                            <tr><td>
                                                    <!-- <input type="button" id="btn_connect" name="btn_connect" value="Conectar"/> -->
                                                    <input type="button" id="btn_consult" name="btn_consult" value="Consultar"/>
                                                </td></tr>
                                        </table>
                                    </td></tr>
                                <tr><td>
                                            <br /><hr /><br />
                                        <table border="0">
                                            <tr><td>Base de Datos</td><td>
                                                    <select id="bd_name" name="bd_name"></select>
                                                </td></tr>
                                            <tr><td>Destino de Respaldo</td><td>
                                                    <input type="text" id="resp_destino" name="resp_destino" />
                                                </td></tr>
                                            <tr><td>Tipo</td><td>
                                                    <select id="dir_tipo" name="dir_tipo">
                                                        <option value="ftp">FTP</option>
                                                        <option value="win">Directorio Windows</option>
                                                    </select>
                                                </td></tr>
                                        </table>  
                                        <br /><hr /><br />
                                        <div id="div_ftp" name="div_ftp">
                                        <table border="0">
                                            <tr><td>Host FTP</td><td>
                                                    <input type="text" id="ftp_host" name="ftp_host" />
                                                </td></tr>
                                            <tr><td>Usuario FTP</td><td>
                                                    <input type="text" id="ftp_user" name="ftp_user" />
                                                </td></tr>
                                            <tr><td>Password FTP</td><td>
                                                    <input type="password" id="ftp_pass" name="ftp_pass" />
                                                </td></tr>
                                        </table>  
                                        </div>
                                            <br /><hr /><br />
                                            <div id="div_win" name="div_win"> 
                                                   <table border="0">
                                                        <tr><td>Directorio Windows</td><td>
                                                                <input type="text" id="dir_win" name="dir_win" />
                                                            </td></tr>

                                                    </table>  
                                           </div>
                                     <br /><hr />   
                                    </td></tr>
                                <tr><td bgcolor="black">&nbsp;</td><td bgcolor="black">&nbsp;</td></tr>
                                <tr><td>
                                        
                                        <table border="0">
                                            <tr><td>
                                                    D&iacute;a de la Semana
                                                </td><td>
                                                    <select id="cron_week" name="cron_week">
                                                        <option value="X">Cualquiera</option>
                                                        <option value="0">Domingo</option>
                                                        <option value="1">Lunes</option>
                                                        <option value="2">Martes</option>
                                                        <option value="3">Mi&eacute;rcoles</option>
                                                        <option value="4">Jueves</option>
                                                        <option value="5">Viernes</option>
                                                        <option value="6">S&aacute;bado</option>
                                                        
                                                    </select>
                                                </td></tr>
                                            <tr><td>
                                                    D&iacute;a del Mes
                                                </td><td>
                                                    <select id="cron_day" name="cron_day">
                                                        <option value="X">Cualquiera</option>
                                                        <?php
                                                            for($i=1;$i<32;$i++){
                                                                echo "<option value='".$i."'>".$i."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </td></tr>
                                            <tr><td>
                                                    Mes
                                                </td><td>
                                                    <select id="cron_month" name="cron_month">
                                                        <option value="X">Cualquiera</option>
                                                        <option value="1">Enero</option>
                                                        <option value="2">Febrero</option>
                                                        <option value="3">Marzo</option>
                                                        <option value="4">Abril</option>
                                                        <option value="5">Mayo</option>
                                                        <option value="6">Junio</option>
                                                        <option value="7">Julio</option>
                                                        <option value="8">Agosto</option>
                                                        <option value="9">Septiembre</option>
                                                        <option value="10">Octubre</option>
                                                        <option value="11">Noviembre</option>
                                                        <option value="12">Diciembre</option>                                                        
                                                    </select>
                                                </td></tr>
                                        </table>
                                        <br />
                                        <input type="button" id="save_cron" name="save_cron" value="Guardar"/> 
                                    </td><td>
                                        <table border="0">
                                            <tr><td>
                                                    Hora
                                                </td><td>
                                                    <select id="cron_hour" name="cron_hour">
                                                        <option value="X">Cualquiera</option>
                                                        <?php
                                                            for($i=0;$i<24;$i++){
                                                                echo "<option value='".$i."'>".$i."</option>";
                                                            }
                                                        ?>
                                                        
                                                    </select>
                                                </td></tr>
                                            <tr><td>
                                                    Minuto
                                                </td><td>
                                                    <select id="cron_minute" name="cron_minute">
                                                        <option value="X">Cualquiera</option>
                                                        <?php
                                                            for($i=0;$i<60;$i++){
                                                                echo "<option value='".$i."'>".$i."</option>";
                                                            }
                                                        ?>
                                                     
                                                    </select>
                                                </td></tr>
                                            <tr><td>
                                                    <br /><br />
                                                    <input type="button" id="btn_viewjobs" name="btn_viewjobs" value="Ver trabajos"/>
                                                </td><td>
                                                    <br /><br />
                                                    <input type="button" id="btn_deletejobs" name="btn_deletejobs" value="Borrar Trabajos"/>
                                                </td></tr>
                                        </table>
                                        
                                        
                                    </td></tr>
                                
                                                                
                            </table>
                            
                        </p>
                </div>
            </div>
            <div id="footer">
            	&copy; Copyright 2011. All right reserved
            </div>
        </div>
        <div id="rightcol">
        	<div class="inner">
            	<p></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
