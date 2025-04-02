<!-- BEGIN: main -->
<h2>Quản lý Đơn hàng</h2>

<!-- Danh sách đơn hàng -->
<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Người đặt</th>
        <th>Trạng thái</th>
        <th>Tổng tiền</th>
        <th>Ngày tạo</th>
        <th>Hành động</th>
    </tr>
    <!-- BEGIN: order -->
    <tr>
        <td>{ORDER.id}</td>
        <td>{ORDER.customer_name}</td>
        <td>{ORDER.status}</td>
        <td>{ORDER.total_price}</td>
        <td>{ORDER.created_at}</td>
        <td>
            <button onclick="editOrder({ORDER.id})">✏️ Sửa</button>
            <button onclick="deleteOrder({ORDER.id})">🗑️ Xóa</button>
        </td>
    </tr>
    <!-- END: order -->
</table>

<!-- FORM thêm/sửa đơn hàng -->
<h3>Thêm/Sửa Đơn Hàng</h3>
<form method="post" id="orderForm">
    <input type="hidden" name="id" id="order_id">
    <label>Người đặt:</label>
    <input type="text" name="user_id" id="user_id" required>
    
    <label>Tổng tiền:</label>
    <input type="number" name="total_price" id="total_price" required>
    
    <label>Trạng thái:</label>
    <select name="status" id="status">
        <option value="pending">Chờ xử lý</option>
        <option value="completed">Hoàn thành</option>
        <option value="cancelled">Hủy</option>
        <option value="processing">Đang xử lý</option>
    </select>
    
    <button type="submit">Thêm mới</button>
</form>

<script>
function editOrder(id) {
    fetch("", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ get_order: 1, id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.getElementById("order_id").value = data.id;
            document.getElementById("user_id").value = data.user_id;
            document.getElementById("total_price").value = data.total_price;
            document.getElementById("status").value = data.status;
        }
    });
}

function deleteOrder(id) {
    if (!confirm("Bạn có chắc chắn muốn xóa đơn hàng này?")) return;

    fetch("", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ delete_order: 1, id: id })
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() == "OK") {
            alert("Xóa thành công!");
            location.reload();
        } else {
            alert("Lỗi khi xóa đơn hàng");
        }
    });
}
</script>
<!-- END: main -->
