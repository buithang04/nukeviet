
<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=$module_name&" . NV_OP_VARIABLE . "=products");
exit();

