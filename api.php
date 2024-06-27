<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  header('Content-Type: application/json');
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
      $apiNameInput = $_POST['apiNameInput'];
      $Dataset = getDataset($apiUrlInput, $apiKeyInput, $apiNameInput);
      echo json_encode($Dataset);
      break;

      case 'getKolomDataset':
        $apiUrlInput = $_POST['apiUrlInput'];
        $apiKeyInput = $_POST['apiKeyInput'];
        $uuid = $_POST['uuid'];
        $KolumDataset = getKolomDataset($apiUrlInput, $apiKeyInput, $uuid);
        echo json_encode($KolumDataset);
        break;

    default:
      echo 'salah nama casenya wak';
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

function getDataset($apiUrlInput, $apiKeyInput, $apiNameInput) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $apiUrlInput.'/api/v1.1/datasets/list/?limit=10&page=0&search='.$apiNameInput,
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

  $response = json_decode(curl_exec($curl), true);
  
  curl_close($curl);
  return $response;
  }

  function getKolomDataset($apiUrlInput, $apiKeyInput, $uuid) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $apiUrlInput.'/api/v1.1/datasets/'.$uuid,
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
    $error = curl_error($curl);
    $url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

    
    curl_close($curl);
    
    if ($error) {
      error_log("CURL error: $error");
      return array('error' => 'CURL error wak', $url);
    }
    
    $responseData = json_decode($response, true);
    if (json_last_error()!== JSON_ERROR_NONE) {
      error_log("JSON decoding error: ". json_last_error_msg());
      return array('error' => 'JSON decoding yang error wak');
    }
    
    return $responseData;
  }
?>