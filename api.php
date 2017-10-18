<?php
	require_once 'vendor/autoload.php';
	
	$app = new \Slim\Slim();
	
	$db = new mysqli("localhost", "root", "five022","pruebas");
	
	$app->get("/productos", function() use($db, $app){
		$query = $db->query("SELECT *FROM productos;");
		$productos = array();
		while($fila = $query -> fetch_assoc()){
			$productos[]=$fila;
		}
		
		echo json_encode($productos);
	});
	
	$app->post("/productos", function()  use($db, $app) {
				
		$query = "INSERT INTO productos VALUES(NULL,"
					."'{$app -> request -> post("name")}',"
					."'{$app -> request -> post("description")}',"
					."'{$app -> request -> post("price")}'"
		.")";
		
		
		$insert = $db -> query($query);
		
		if($insert){
			$result = array("STATUS" => "true", "message" => "Producto creado correctamente");
		} else{
			$result = array("STATUS" => "false", "message" => "Producto no se ha podido crear");
		}
		echo json_encode($result);
	});
	
	$app->put("/productos/:id", function($id) use ($db, $app) {
		
		$query = "UPDATE productos SET "
					."name = '{$app -> request -> post("name")}',"
					."description = '{$app -> request -> post("description")}',"
					."price = '{$app -> request -> post("price")} '"
					."WHERE id = {$id}";
					
		$update = $db -> query($query);
		if($update){
			$result = array("STATUS" => "true", "message" => "Producto actualizado correctamente");
		} else{
			$result = array("STATUS" => "false", "message" => "El producto no se ha podido actualizar");
		}
		
		echo json_encode($result);
	});
	
	$app->delete("/productos/:id", function($id) use ($db, $app) {
		
		$query = "DELETE FROM productos WHERE id = {$id}";
					
		$delete = $db -> query($query);
		if($delete){
			$result = array("STATUS" => "true", "message" => "Producto borrado correctamente");
		} else{
			$result = array("STATUS" => "false", "message" => "El producto no se ha podido barrar");
		}
		
		echo json_encode($result);
	});
	
	$app->run();