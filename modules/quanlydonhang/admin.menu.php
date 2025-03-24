<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}
global $lang_module;
require NV_ROOTDIR . "/modules/" . $module_name . "/language/" . NV_LANG_DATA . ".php";

$submenu['products'] = $lang_module['products'];

$submenu['orders'] = $lang_module['orders'];  



