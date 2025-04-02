<?php
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$xtpl = new XTemplate('orders.tpl', NV_ROOTDIR . '/themes/admin_default/modules/quanlybanhang/');

$sql = "SELECT o.id, u.username AS customer_name, o.status, o.total_price, o.created_at 
        FROM " . NV_PREFIXLANG . "_quanlydonhang_orders o 
        LEFT JOIN " . NV_USERS_GLOBALTABLE . " u ON o.user_id = u.userid
        ORDER BY o.created_at DESC";

$result = $db->query($sql);

while ($row = $result->fetch()) {
    $xtpl->assign('ORDER', $row);
    $xtpl->parse('main.order');
}


if ($nv_Request->isset_request('get_order', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $sql = "SELECT id, user_id, status, total_price FROM " . NV_PREFIXLANG . "_quanlydonhang_orders WHERE id = " . $id;
    $order = $db->query($sql)->fetch();
    if (!$order) {
        echo json_encode(['error' => 'Không tìm thấy đơn hàng']);
    } else {
        echo json_encode($order);
    }
    exit;
}


if ($nv_Request->isset_request('id', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $user_id = $nv_Request->get_int('user_id', 'post', 0);
    $total_price = $nv_Request->get_float('total_price', 'post', 0);
    $status = $nv_Request->get_title('status', 'post', '');
    
    if ($id > 0) {
       
        $sql = "UPDATE " . NV_PREFIXLANG . "_quanlybanhang_orders SET user_id=?, total_price=?, status=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id, $total_price, $status, $id]);
    } else {
        
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_quanlydonhang_orders (user_id, total_price, status, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id, $total_price, $status]);
    }
    echo json_encode(['success' => 'Cập nhật thành công']);
    exit;
}


if ($nv_Request->isset_request('delete_order', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $db->query("DELETE FROM " . NV_PREFIXLANG . "_quanlydonhang_orders WHERE id=" . $id);
    echo "OK";
    exit;
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
