<!-- BEGIN: main -->
<h2>Quản lý Sản phẩm</h2>

<!-- Danh sách sản phẩm -->
<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Tồn kho</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <!-- BEGIN: product -->
    <tr>
        <td>{PRODUCT.id}</td>
        <td>{PRODUCT.name}</td>
        <td>{PRODUCT.price}</td>
        <td>{PRODUCT.stock}</td>
        <td>{PRODUCT.status}</td>
        <td>
            <button onclick="editProduct({PRODUCT.id})">✏️ Sửa</button>
            <button onclick="deleteProduct({PRODUCT.id})">🗑️ Xóa</button>
        </td>
    </tr>
    <!-- END: product -->
</table>

<!-- BEGIN: add -->
<h3>Thêm Sản Phẩm</h3>
<form method="post">
    <input type="hidden" name="id" value="{ID}">
    <label>Tên sản phẩm:</label>
    <input type="text" name="name" value="{NAME}" required>

    <label>Giá:</label>
    <input type="number" name="price" value="{PRICE}" required>

    <label>Tồn kho:</label>
    <input type="number" name="stock" value="{STOCK}" required>

    <label>Trạng thái:</label>
    <select name="status">
        <option value="active" {SELECTED_ACTIVE}>✔️ Hiển thị</option>
        <option value="hidden" {SELECTED_HIDDEN}>❌ Ẩn</option>
    </select>

    <!-- BEGIN: edit -->
    <button type="submit">Cập nhật</button>
    <!-- END: edit -->

    <!-- BEGIN: addbutton -->
    <button type="submit">Thêm mới</button>
    <!-- END: addbutton -->
</form>
<!-- END: add -->

<!-- Modal sửa sản phẩm -->
<div id="editModal" style="display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
    <h3>Sửa Sản Phẩm</h3>
    <form id="editForm">
        <input type="hidden" id="edit_id" name="id">

        <label>Tên sản phẩm:</label>
        <input type="text" id="edit_name" name="name" required>

        <label>Giá:</label>
        <input type="number" id="edit_price" name="price" required>

        <label>Tồn kho:</label>
        <input type="number" id="edit_stock" name="stock" required>

        <label>Trạng thái:</label>
        <select id="edit_status" name="status">
            <option value="active">✔️ Hiển thị</option>
            <option value="hidden">❌ Ẩn</option>
        </select>

        <button type="button" onclick="saveProduct()">💾 Lưu</button>
        <button type="button" onclick="closeModal()">❌ Hủy</button>
    </form>
</div>

<!-- Overlay để làm nền tối khi hiện Modal -->
<div id="overlay" style="display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;" onclick="closeModal()"></div>

<script>
function editProduct(id) {
    fetch("", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ get_product: 1, id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.getElementById("edit_id").value = data.id;
            document.getElementById("edit_name").value = data.name;
            document.getElementById("edit_price").value = data.price;
            document.getElementById("edit_stock").value = data.stock;
            document.getElementById("edit_status").value = data.status;
            openModal();
        }
    });
}

function saveProduct() {
    let formData = new FormData(document.getElementById("editForm"));

    fetch("index.php?nv=quanlydonhang&op=products", { 
        method: "POST",
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.success) {
            alert(data.success);
            closeModal();
            location.reload();
        } else {
            alert("Lỗi: " + data.error);
        }
    })
    .catch(error => alert("Lỗi kết nối!"));
}



function deleteProduct(id) {
    if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) return;

    fetch("", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ delete_product: 1, id: id })
    })
    .then(response => response.text())
    .then(data => {
        if (data === "OK") {
            alert("Xóa thành công!");
            location.reload();
        } else {
            alert("Lỗi khi xóa sản phẩm!");
        }
    });
}

function openModal() {
    document.getElementById("editModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}
</script>
<!-- END: main -->
    