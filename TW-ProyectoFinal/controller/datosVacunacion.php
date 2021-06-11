<?php
require_once "../controller/check_login.php";
require_once '../model/bdCalCart.php';
require_once "../view/vistasComunes.php";
require_once "../view/vistasCal-Cart.php";

$titulo="Datos de la vacunación";

if($rol == 'P' || $rol == 'S' || $rol == 'A'){
	HTMLinicio($titulo);
	HTMLheader($titulo);
	HTMLnav($rol);

	//si se llega de datosVacuna
	if(isset($_POST['datosCartilla'])){

	    //obtenemos los datos necesarios
	    $nombre = obtenerNombreVacuna($_POST['idVac']);
	    $acronimo = obtenerAcronimoVacuna($_POST['idVac']);
		$dnipaciente = $_POST['dnipaciente'];
		$idcalendario = $_POST['id'];
		$idvacunacion = $_POST['idvacunacion'];
	    $datosVac = obtenerDatosVacunacion($dnipaciente, $_POST['id']);

		//comprobamos si ha habido error
		if($nombre == 3 || $acronimo == 3 || $datosVac == 3){
			mensaje($titulo, "Error al conectarse a la base de datos.");
		}
		else if($nombre == 1 || $acronimo == 1){
			mensaje($titulo, "No hay datos de vacunación de la vacuna.");
		}
		else if(!is_array($datosVac)){
			if($datosVac == 1){
				mensaje($titulo, "No existe el usuario.");
			}
			else if($datosVac == 2){
				mensaje($titulo, "No está registrada la vacuna para el usuario.");
			}
		}
		else{
			$form = '../controller/cartillaVacunacion.php';
			$name = 'cartillaVacunacion';

			if(isset($_POST['cartillaVacunacionPaciente']) && $rol == 'S'){
				
				$form = '../controller/cartillaVacunacion.php';
				$name = 'cartillaVacunacionPaciente2';
			}

	    	$datos = array(
	    	    'nombre' => $nombre,
	    	    'acronimo' => $acronimo,
				'idcalendario' => $idcalendario,
				'idvacunacion' => $idvacunacion,
	    	    'fecha' => $datosVac['fecha'],
	    	    'fabricante' => $datosVac['fabricante'],
	    	    'comentarios' => $datosVac['comentarios'],
	    	    'form' => $form,
	    	    'vienede' => 'Cartilla',
				'name' => $name,
				'dnipaciente' => $dnipaciente,
	    	);

	    	datosCartilla($datos, $titulo, $rol);
		}
	}

	HTMLformulario($rol);
	HTMLfooter();
}
else{
	header('Location: ../view/inicio.php');
}
?>