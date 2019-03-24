<?php
include_once '../Models/ProdutModel.class.php';

//Recebe variaveis
$metodo = $_POST['metodo'];
$product = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_STRING);
$limit = filter_input(INPUT_POST, 'limit', FILTER_SANITIZE_STRING);
$limit = ($limit) ? $limit : 10;
$start = ($page > 1) ? (($page-1)*$limit) : 0;

//Cria objeto
$objectProduct = new ProductClass();
$objectProduct->__set('product', $product);
$objectProduct->__set('title', $title);
$objectProduct->__set('description', $description);
$objectProduct->__set('url', $url);
$objectProduct->__set('start', $start);
$objectProduct->__set('limit', $limit);

call_user_func($metodo, $objectProduct);

function FindAll($objectProduct) {
    $return = $objectProduct->FindAll();
    echo json_encode($return);
}

function FindById($objectProduct) {
    $return = $objectProduct->FindById();
    echo json_encode($return);
}
 
function Create($objectProduct) {
    $return = $objectProduct->Create();
    echo json_encode($return);
}

function Update($objectProduct) {
    $return = $objectProduct->Update();
    echo json_encode($return);
}

function Delete($objectProduct) {
    $return = $objectProduct->Delete();
    echo json_encode($return);
}

?>