<?php
function getData($dbobject, $where) {
    $data = $dbobject->getData($where);
    return $data;
    
}
function insertData($dbobject, $data) {
    $dbobject->insertData($data);
    
}
function updateData($dbobject, $data) {
    $dbobject->updateData($data);
    
}
function deleteData($dbobject, $data) {
    $dbobject->deleteData($data);
    
}
function alterClass($dbobject, $what) {
    $dbobject->alterClass($what);
    
}
?>