<?php
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

include_once NV_ROOTDIR . '/modules/quanlydonhang/admin.functions.php';

$xtpl = new XTemplate('orders.tpl', NV_ROOTDIR . '/themes/admin_default/modules/quanlybanhang/');

if ($nv_Request->get_title('action', 'post', '') == 'save') {
    $id = $nv_Request->get_int('id', 'post', 0);
    $status = $nv_Request->get_title('status', 'post', '');
    $total_price = $nv_Request->get_title('total_price', 'post', '');

    if ($id > 0 && in_array($status, ['pending', 'processing', 'completed', 'cancelled'])) {
        updateOrder($id, $status, $total_price);
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Update Order', 'Order ID: ' . $id, $admin_info['userid']);
        Header('Location: ' . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=quanlydonhang&" . NV_OP_VARIABLE . "=orders");
        exit();
    }
}

if ($nv_Request->isset_request('delete_id', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get', 0);
    deleteOrder($id);
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=quanlydonhang&" . NV_OP_VARIABLE . "=orders");
    exit();
}

$orders = getAllOrders();
foreach ($orders as $order) {
    $order['status_text'] = ucfirst($order['status']);
    $order['total_price'] = number_format($order['total_price'], 2);
    $order['created_at'] = nv_date('H:i d/m/Y', strtotime($order['created_at']));

    $xtpl->assign('ORDER', $order);
    $xtpl->parse('main.row');
}


if ($nv_Request->get_title('action', 'get', '') == 'edit') {
    $id = $nv_Request->get_int('id', 'get', 0);
    $order = getOrderById($id); 

    if ($order) {
        $xtpl->assign('ORDER', $order);
    
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        foreach ($statuses as $status_option) {
            $xtpl->assign('SELECTED_' . strtoupper($status_option), ($order['status'] == $status_option) ? 'selected' : '');
        }
    
        $xtpl->parse('main.editform');
    }    
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
