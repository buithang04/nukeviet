<!-- Hiển thị danh sách -->
<!-- BEGIN: main -->

<style>
    .order-form {
        margin-bottom: 20px;
    }

    .order-form input,
    .order-form select,
    .order-form button {
        padding: 6px;
        margin-right: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .order-table th,
    .order-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .order-table th {
        background-color: #f5f5f5;
    }

    .order-table a {
        color: #007BFF;
        text-decoration: none;
    }

    .order-table a:hover {
        text-decoration: underline;
    }
</style>

<form method="post" action="" class="order-form">
    <input type="hidden" name="action" value="save" />
    <input type="hidden" name="id" value="{ORDER.id}" />

    <p><strong>Order ID:</strong> {ORDER.id}</p>
    <p><strong>User ID:</strong> {ORDER.user_id}</p>

    <label for="total_price">Tổng giá:</label>
    <input type="text" name="total_price" value="{ORDER.total_price}" required />

    <label for="status">Trạng thái:</label>
    <select name="status">
    <option value="pending" {SELECTED_PENDING}>Pending</option>
    <option value="processing" {SELECTED_PROCESSING}>Processing</option>
    <option value="completed" {SELECTED_COMPLETED}>Completed</option>
    <option value="cancelled" {SELECTED_CANCELLED}>Cancelled</option>
</select>

    <button type="submit">Lưu</button>
</form>

<table class="order-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Trạng thái</th>
            <th>Tổng giá</th>
            <th>Thời gian</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <!-- BEGIN: row -->
        <tr>
            <td>{ORDER.id}</td>
            <td>{ORDER.user_id}</td>
            <td>{ORDER.status_text}</td>
            <td>{ORDER.total_price}</td>
            <td>{ORDER.created_at}</td>
            <td><a href="{NV_BASE_ADMINURL}index.php?nv=quanlydonhang&op=orders&delete_id={ORDER.id}" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')">Xóa</a>
            <a href="{NV_BASE_ADMINURL}index.php?nv=quanlydonhang&op=orders&action=edit&id={ORDER.id}">Sửa</a>
            </td>
            
        </tr>
        <!-- END: row -->
    </tbody>
</table>

</form>
<!-- END: form -->
