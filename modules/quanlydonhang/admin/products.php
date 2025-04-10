<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}



$xtpl = new XTemplate('products.tpl', NV_ROOTDIR . '/themes/admin_default/modules/quanlybanhang/');
$page_title = "Quản lý Sản phẩm";


$id = $nv_Request->get_int('id', 'get,post', 0);
$name = $nv_Request->get_title('name', 'post', '', 1);
$price = $nv_Request->get_float('price', 'post', 0);
$stock = $nv_Request->get_int('stock', 'post', 0);
$status = $nv_Request->get_title('status', 'post', 'active');


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($name)) {
    if ($id > 0) {
       
        updateProduct($id, $name, $price, $stock, $status);
        
    } else {
        addProduct($name, $price, $stock, $status);
    }
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=$module_name&" . NV_OP_VARIABLE . "=products");
    exit();
}
if ($id > 0) {
    $product = getProductById($id);
    if (!$product) {
        die('Lỗi: Không tìm thấy sản phẩm!');
    }
    $xtpl->assign('ID', $product['id']);
    $xtpl->assign('NAME', $product['name']);
    $xtpl->assign('PRICE', $product['price']);
    $xtpl->assign('STOCK', $product['stock']);
    $xtpl->assign('SELECTED_ACTIVE', $product['status'] == 'active' ? 'selected' : '');
    $xtpl->assign('SELECTED_HIDDEN', $product['status'] == 'hidden' ? 'selected' : '');
}

if ($nv_Request->isset_request('delete_product', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
   
    if (deleteProduct($id)) {
       exit('OK');
    }
}


$products = getAllProducts();


foreach ($products as $product) {
    $product['price'] = formatPrice($product['price']);
    $product['status'] = ($product['status'] == 'active') ? '✔️ Hiển thị' : '❌ Ẩn';
    $xtpl->assign('PRODUCT', $product);
    $xtpl->parse('main.product');
}

if ($id > 0) {
    $product = getProductById($id);
    if ($product) {
        $xtpl->assign('ID', $product['id']);
        $xtpl->assign('NAME', $product['name']);
        $xtpl->assign('PRICE', $product['price']);
        $xtpl->assign('STOCK', $product['stock']);
        $xtpl->assign('SELECTED_ACTIVE', $product['status'] == 'active' ? 'selected' : '');
        $xtpl->assign('SELECTED_HIDDEN', $product['status'] == 'hidden' ? 'selected' : '');
        $xtpl->assign('TITLE', 'Sửa sản phẩm');

        $xtpl->parse('main.add.edit');
    }
} else {
    $xtpl->assign('TITLE', 'Thêm sản phẩm');
    $xtpl->parse('main.add.addbutton'); 
}

$xtpl->parse('main.add'); 



if ($nv_Request->isset_request('get_product', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $product = getProductById($id);
    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(["error" => "Không tìm thấy sản phẩm"]);
    }
    exit();
}





// Xuất nội dung
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
