<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}
define('NV_IS_FILE_ADMIN', true);
$allow_func = [
    'main',
    'menu',
    'orders',
    'products'
];
global $db, $db_config;

if (!function_exists('getAllProducts')) {
function getAllProducts() {
    global $db, $db_config;
    $sql = "SELECT * FROM " . $db_config['prefix'] . "_vi_quanlydonhang_products ORDER BY id DESC";
    return $db->query($sql)->fetchAll();
}
}

function getProductById($id) {
    global $db,$db_config ;
    $stmt = $db->prepare("SELECT * FROM ".$db_config['prefix'] . "_vi_quanlydonhang_products  WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}


function addProduct($name, $price, $stock, $status) {
    global $db, $db_config;
    $stmt = $db->prepare("INSERT INTO ".$db_config['prefix'] . "_vi_quanlydonhang_products  (name, price, stock, status) VALUES (:name, :price, :stock, :status)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    return $stmt->execute();
}


function updateProduct($id, $name, $price, $stock, $status)
{
    global $db, $db_config;
    $stmt = $db->prepare("UPDATE " . $db_config['prefix'] . "_vi_quanlydonhang_products SET name = :name, price = :price, stock = :stock, status = :status WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    if ($stmt->execute()) {
        nv_jsonOutput((['success' => 1]));
    } else {
        nv_jsonOutput((['error' => 2]));
    }
}


function deleteProduct($id) {
    global $db,$db_config ;
    $stmt = $db->prepare("DELETE FROM " . $db_config['prefix'] . "_vi_quanlydonhang_products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}



function formatPrice($price) {
    return number_format($price, 0, ',', '.') . " VNĐ";
}

//orders

function getAllOrders() {
    global $db, $db_config;
    $sql = "SELECT * FROM " . $db_config['prefix'] . "_vi_quanlydonhang_orders ORDER BY created_at DESC";
    $stmt = $db->query($sql);
    return $stmt->fetchAll();
}


function getOrderById($id) {
    global $db, $db_config;
    $stmt = $db->prepare("SELECT * FROM " . $db_config['prefix'] . "_vi_quanlydonhang_orders WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}


function addOrder($user_id, $status, $total_price) {
    global $db, $db_config;
    $sql = "INSERT INTO " . $db_config['prefix'] . "_vi_quanlydonhang_orders (user_id, status, total_price, created_at) 
            VALUES (:user_id, :status, :total_price, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
    return $stmt->execute();
}


function updateOrder($id, $status, $total_price) {
    global $db, $db_config;
    $sql = "UPDATE " . $db_config['prefix'] . "_vi_quanlydonhang_orders 
            SET status = :status, total_price = :total_price 
            WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
    return $stmt->execute();
}



function deleteOrder($id) {
    global $db, $db_config;
    $stmt = $db->prepare("DELETE FROM " . $db_config['prefix'] . "_vi_quanlydonhang_orders WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}



