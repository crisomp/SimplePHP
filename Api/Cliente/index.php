<?php
header("Content-Type: application/json");

include '../../DataAccess/ClienteDataAccess.php';
include '../../DataAccess/Conexion.php';
include '../../Model/Cliente.php';


$ClienteController = new ClienteDataAccess();
$ClienteModel = new Cliente();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $ClienteModel->IdCliente = filter_input(INPUT_GET, 'Id', FILTER_SANITIZE_NUMBER_INT) ?? 0;
  
    // $Cliente->_set('Nombre', filter_input(INPUT_GET, 'Nombre', FILTER_SANITIZE_STRING)) ;
    // $Cliente->_set('Ruta',filter_input(INPUT_GET, 'Ruta', FILTER_SANITIZE_STRING));
  
      // // Lógica para el método GET
      // $data = array(
      //     'message' => 'Hola desde la API!'
      // );
  
    if ($ClienteModel->IdCliente === 0) {

      echo json_encode($ClienteController->Buscar($Cliente));

    }elseif($ClienteModel->IdCliente > 0){

      echo json_encode($ClienteController->BuscarPorId($ClienteModel->IdCliente));
      
    }
    


  
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Lógica para el método POST
    } else {
      // Otros métodos no admitidos
    }


    // Verificar si es una solicitud POST o PUT (o cualquier otra solicitud que pueda contener un body)
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
  // Obtener el contenido del cuerpo de la solicitud
  $postData = file_get_contents('php://input');

  // Puedes realizar alguna lógica adicional con los datos del body, por ejemplo, decodificarlo si está en formato JSON:
  $decodedData = json_decode($postData, true);

  // Hacer algo con los datos decodificados
  echo json_encode($decodedData);
}


?>