<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action'];

  switch ($action) {
    case 'getSubcategories':
      $apiUrlInput = $_POST['apiUrlInput'];
      $apiKeyInput = $_POST['apiKeyInput'];
      $subcategories = getSubcategories($apiUrlInput, $apiKeyInput);
      echo json_encode($subcategories);
      break;

    case 'getSubjects':
      $subcatId = $_POST['subcatId'];
      $apiUrlInput = $_POST['apiUrlInput'];
      $apiKeyInput = $_POST['apiKeyInput'];
      $subjects = getSubjects($subcatId, $apiUrlInput, $apiKeyInput);
      echo json_encode($subjects);
      break;

    case 'getVariables':
      $subId = $_POST['subId'];
      $apiUrlInput = $_POST['apiUrlInput'];
      $apiKeyInput = $_POST['apiKeyInput'];
      $Variables = getVariables($subId, $apiUrlInput, $apiKeyInput);
      echo json_encode($Variables);
      break;
      
    case 'getTableData':
      $varId = $_POST['varId'];
      $apiUrlInput = $_POST['apiUrlInput'];
      $apiKeyInput = $_POST['apiKeyInput'];
      $TableData = getTableData($varId, $apiUrlInput, $apiKeyInput);
      echo json_encode($TableData);
      break;

    case 'getDataset':
      $apiUrlInput = $_POST['apiUrlInput'];
      $apiKeyInput = $_POST['apiKeyInput'];
      $Dataset = getDataset($apiUrlInput, $apiKeyInput);
      echo json_encode($Dataset);
      break;

    default:
      echo 'Invalid action';
      break;
  }

  exit;
}

function getSubcategories($apiUrlInput, $apiKeyInput) {
  $ch = curl_init($apiUrlInput. '/v1/api/list/model/subcat/lang/ind/domain/1100/key/'. $apiKeyInput. '/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true);
  curl_close($ch);
  return $response;
}

function getSubjects($subcatId, $apiUrlInput, $apiKeyInput) {
  $ch = curl_init($apiUrlInput. '/v1/api/list/model/subject/lang/ind/domain/1100/subcat/'. $subcatId. '/key/'. $apiKeyInput. '/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true);
  curl_close($ch);
  return $response;
}

function getVariables($subId, $apiUrlInput, $apiKeyInput) {
  $ch = curl_init($apiUrlInput. '/v1/api/list/model/var/lang/ind/domain/1100/subject/'. $subId. '/key/'. $apiKeyInput. '/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true);
  curl_close($ch);
  return $response;
  }
function getTableData($varId, $apiUrlInput, $apiKeyInput) {
  $ch = curl_init($apiUrlInput. '/v1/api/list/model/data/lang/ind/domain/1100/var/'. $varId. '/key/'. $apiKeyInput. '/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = json_decode(curl_exec($ch), true);
  curl_close($ch);
  return $response;
  }

function getDataset($apiUrlInput, $apiKeyInput) {
  header('Content-Type: application/json');
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $apiUrlInput.'/api/v1.1/datasets/list',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'APIKEY: '.$apiKeyInput
    ),
  ));

  $response = curl_exec($curl);
  
  curl_close($curl);
  echo $response;
  }

?>