<?php
	require_once 'vendor/autoload.php';
	
	$app = new \Slim\Slim();
	
	$app->get("/hola/:nombre", function($nombre) use($app){
		echo "Hola ".$nombre;
		var_dump($app->request->params("hola"));
	});
	
	function pruebaMiddleware(){
		echo "Soy un Middleware";
	}
	
	function pruebaTwo(){
		echo "Soy un Middleware 2";
	}
	
	$app->get("/pruebas(/:uno(/:dos))", 'pruebaMiddleware','pruebaTwo',function($uno=NULL, $dos=NULL){
		echo $uno."<br/>";
		echo $dos."<br/>";
		
	})->conditions(array(
		"uno" => "[a-zA-Z]*",
		"dos" => "[0-9]*"
		));
		
	$uri = "/slim/index.php/api/ejemplo";
	$app->group("/api", function() use ($app, $uri){
		$app->group("/ejemplo", function() use ($app, $uri){
			$app->get("/hola/:nombre", function($nombre){
				echo "Hola ".$nombre;
			})->name("hola");
			
			$app->get("/dime-tu-aoellido/:apellido", function($apellido){
				echo "tu apellido es : ".$apellido;
			});
			
			$app->get("/mandame-a-hola", function() use ($app, $uri){
				//$app->redirect($uri."/hola/Ubaldo");
				//echo $app->urlFor("hola", array("nombre" => "Ubaldo Cruz"));
				$app->redirect($app->urlFor("hola", array("nombre" => "Ubaldo Cruz")));
			});
		
		});
	});
	
	$app->run();