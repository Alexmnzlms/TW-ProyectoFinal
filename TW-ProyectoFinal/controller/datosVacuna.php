<?php
require_once "../controller/check_login.php";
require_once '../model/bdCalCart.php';
require_once "../view/vistasComunes.php";
require_once "../view/vistasCal-Cart.php";

$titulo="Datos de la vacuna";

HTMLinicio($titulo);
HTMLheader($titulo);
HTMLnav($rol);

//si se llega de datosVacuna
if(isset($_POST['datosVacuna'])){
    
    //obtenemos los datos de la vacuna
    $nombre = obtenerNombreVacuna($_POST['idVac']);
    $acronimo = obtenerAcronimoVacuna($_POST['idVac']);
    $sexo = $_POST['sexo'];
    $tipo = $_POST['tipo'];
    $comentarios = $_POST['comment'];
    $calendario_id = $_POST['id'];
    $vienede = 'Calendario';
    $form = '../controller/calendario.php';
    $name = 'cartilla';
    $dnipaciente = '';

    /*if(isset($_SESSION['dnipaciente'])){
        $dnipaciente = $_SESSION['dnipaciente'];
    }*/
    
    //comprobamos si ha habido error
	if($nombre == 3 || $acronimo == 3){
		mensaje($titulo, "Error al conectarse a la base de datos.");
	}
	else if($nombre == 1 || $acronimo == 1){
		mensaje($titulo, "No hay datos de vacunación de la vacuna.");
	}
    else{
        //si viene de cartilla
        if(isset($_POST['cartilla']) && $_POST['cartilla'] == 'y'){
            $vienede = 'Cartilla';
            $form = '../controller/cartillaVacunacion.php';
        }
        if(isset($_POST['cartillaVacunacionPaciente']) && $rol == 'S'){
            $form = '../controller/cartillaVacunacion.php';
            $name = 'cartillaVacunacionPaciente2';
        }
        else if(isset($_POST['cartillaVacunacionPaciente2']) && $rol == 'SP'){
            $form = '../controller/cartillaVacunacion.php';
            $name = 'cartillaVacunacionPaciente2';
        }
        //procesamos los datos
        $sexo = procesarSexo($sexo);
        $tipo = procesarTipo($tipo);
        $datos = array(
            'nombre' => $nombre,
            'acronimo' => $acronimo,
            'calendario_id' => $calendario_id,
            'sexo' => $sexo,
            'tipo' => $tipo,
            'comentarios' => $comentarios,
            'form' => $form,
            'vienede' => $vienede,
            'name' => $name,
            'dnipaciente' => $dnipaciente,
        );
        datosVacunas($datos, $titulo, $rol);
    }
}
HTMLformulario($rol);
HTMLfooter();

function procesarSexo($sexo){
    if($sexo == 'T'){
        $sexo = "Para todas las personas";
    }
    else if($sexo == 'M'){
        $sexo = "Para mujeres";
    }
    else if($sexo == 'H'){
        $sexo = "Para hombres";
    }
    return $sexo;
}

function procesarTipo($tipo){

    if($tipo == 'S'){
        $tipo = "Administración Sistemática";
    }
    else if($tipo == 'N'){
        $tipo = "Administración en personas susceptibles o no vacunadas con anterioridad";
    }
    else if($tipo == 'R'){
        $tipo = "Administración en recién nacidos";
    }

    return $tipo;
}
?>
