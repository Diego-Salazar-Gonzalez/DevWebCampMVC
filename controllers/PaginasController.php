<?php

namespace Controllers;

use Classes\Email;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use Model\Usuario;
use MVC\Router;

class PaginasController {
    public static function index(Router $router) {
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

        //Obtener el total de cada bloque
        $ponentes_total = Ponente::total();
        $conferencias_total = Evento::total('categoria_id',1);
        $workshops_total = Evento::total('categoria_id',2);

        //obteniend todos los ponentes
        $ponentes = Ponente::all();

        
        $router->render('paginas/index',[
            'titulo' => 'Inicio',
            'eventos' => $eventosFormateados,
            'ponentes_total' => $ponentes_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes
        ]);
    }
    public static function evento(Router $router) {
        $router->render('paginas/devwebcamp',[
            'titulo' => 'Sobre DevWebCamp'
        ]);
    }
    public static function paquetes(Router $router) {
        $router->render('paginas/paquetes',[
            'titulo' => 'Paquetes DevWebCamp'
        ]);
    }
    public static function conferencias(Router $router) {

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

      


        $router->render('paginas/conferencias',[
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventosFormateados
        ]);
    }

    public static function error(Router $router){
           
        
        $router->render('paginas/error',[
            'titulo' =>'Error 404 Su pagina no fue encontrada :(' 
        ]);
    }
}
