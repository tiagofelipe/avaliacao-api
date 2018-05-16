<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 28/02/2018
 * Time: 21:34
 */

if (@$_GET['x'] === '2018125566') {
    echo "Clear cache...";
    apc_clear_cache();
}

?>