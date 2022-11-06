<?php


namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventosRegistro;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
use Model\Regalo;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController
{
    public static function crear(Router $router)
    {

        if (!is_auth()) {
            header('Location: /');
        }
        //Verificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        
       

        if (isset($registro) && ($registro->paquete_id === '3' || $registro->paquete_id === '2')) {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if(isset($registro) && $registro->paquete_id  === "1"){
            header('Location: /finalizar-registro/conferencias');
            return;
        }
         
        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'

        ]);
        
    }
    public static function gratis(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /login');
                return;
            }
            //Verificar si el usuario ya esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if (isset($registro) && $registro->paquete_id === '3') {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }
            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if ($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }
        }
    }

    public static function boleto(Router $router)
    {
        
        if (!is_auth()) {
            header('Location: /');
        }
        
        //Validar la URL
        $id = $_GET['id'];
        if (!$id || !strlen($id) === 8) {
            header('Location: /');
            return;
        }
       

        
        //buscar en la DB

        $registro = Registro::where('token', $id);
        
        if (!$registro) {
            header('Location: /');
            return;
        }
        
        
        
        
        //Llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);


        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro

        ]);
    }

    public static function pagar(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /login');
                return;
            }
            //Validar que no venga vacio post
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }
            //Crear el registro
          
            

            $datos = $_POST;
           
            $datos['token'] =  substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];
          
           

            try {
                $registro = new Registro($datos);
                
                $resultado = $registro->guardar();
               
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }
    public static function conferencias(Router $router)
    {
        if(!is_auth()){
            header('Location: /');
            return;
        } 

        //Validando que el usuario tenga el plan presencias
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id',$usuario_id);

        
        if(isset($registro) && $registro->paquete_id === "2") {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }
        
        if($registro->paquete_id !== "1") { 
            header('Location: /');
            return;
        }

        if( isset($registro->regalo_id) && $registro->paquete_id === "1") {
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
             }
       


        $eventos = Evento::ordenar('hora_id','ASC');
        $eventosFormateados= [];
        foreach($eventos as $evento){

            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
               
            
            if($evento->dia_id === "1" && $evento->categoria_id=== "1"){
                $eventosFormateados['conferencias_v'][] = $evento;
            }
            if($evento->dia_id === "2" && $evento->categoria_id=== "1"){
                $eventosFormateados['conferencias_s'][] = $evento;
            }
            if($evento->dia_id === "1" && $evento->categoria_id=== "2"){
                $eventosFormateados['workshops_v'][] = $evento;
            }
            if($evento->dia_id === "2" && $evento->categoria_id=== "2"){
                $eventosFormateados['workshops_s'][] = $evento;
            }
        }

        //objeto de form data
        
        
        $regalos = Regalo::all('ASC');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Revisar que el usuario este autenticado
            if(!is_auth()){
                header('Location: /login');
                return;
            }
            $eventos = explode(',', $_POST['eventos']);
           

            if(empty($eventos)){
                echo json_encode(['resultado'=> false] );
                return;
            }

           
            

            
            //Obtener registro de usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== "1"){
                echo json_encode(['resultado'=> false] );
                return;
            }
            $eventos_array = [];

            //Verificar vacantes
            foreach($eventos as $evento_id){
                $evento = Evento::find($evento_id);
                
                //comprobanding que el evento exista o que no este vacio
                if(!isset($evento) || $evento->disponibles === "0"){
                    echo json_encode(['resultado' => false]);
                    return;
                }

                $eventos_array[] = $evento;
                
                

               

            }

           

            foreach($eventos_array as $evento){
                $evento->disponibles -= 1;
                $evento->guardar();

                //almacenando el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_usuario = new EventosRegistro($datos);
                $registro_usuario->guardar();
            }
            
            //almacenar id regalo
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();
            if($resultado){
                echo json_encode([
                    'resultado' => $resultado,
                    'token' => $registro->token]);
            }else{
                echo json_encode(['resultado' => false]);
            }

            return;
        }


        $router->render('registro/conferencias', [
            'titulo' => 'Asistencia a DevWebCamp',
            'eventos' => $eventosFormateados,
            'regalos' => $regalos
            

        ]);
    }

}
