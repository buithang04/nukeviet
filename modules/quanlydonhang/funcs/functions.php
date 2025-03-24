<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}


global $db, $db_config;
$table_name = $db_config['prefix'] . "_vi_quanlydonhang_products";


function getAllProducts() {
    global $db, $table_name;
    $sql = "SELECT * FROM $table_name ORDER BY id DESC";
    return $db->query($sql)->fetchAll();
}


function getProductById($id) {
    global $db, $table_name;
    $stmt = $db->prepare("SELECT * FROM $table_name WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}


function addProduct($name, $price, $stock, $status) {
    global $db, $table_name;
    $stmt = $db->prepare("INSERT INTO $table_name (name, price, stock, status) VALUES (:name, :price, :stock, :status)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    return $stmt->execute();
}


function updateProduct($id, $name, $price, $stock, $status) {
    global $db, $table_name;
    $stmt = $db->prepare("UPDATE $table_name SET name = :name, price = :price, stock = :stock, status = :status WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    return $stmt->execute();
}


function deleteProduct($id) {
    global $db, $table_name;
    $stmt = $db->prepare("DELETE FROM $table_name WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}


function toggleProductStatus($id) {
    global $db, $table_name;
    $product = getProductById($id);
    if (!$product) return false;

    $new_status = ($product['status'] == 'active') ? 'hidden' : 'active';
    $stmt = $db->prepare("UPDATE $table_name SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $new_status, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}


function formatPrice($price) {
    return number_format($price, 0, ',', '.') . " VNĐ";
}
