<?php
/**
 *
 * View
 *
 * @version 0.1
 *
 */

$layout = 'core';

$v['header']['extension'] = <<< EOT
<!-- include libraries(jQuery, bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
<script src="<?= $v['url']['layout']; ?>path/src.js">
<script src="{ROOT_URL}/app.js"></script>
EOT;
$v['header']['extension'] = sprintf($v['header']['extension'], ROOT_URL);

include(LAYOUT_PATH . $layout . DS . 'head.php');
include(LAYOUT_PATH . $layout . DS . 'header.php');
?>

<!-- form:#formv1 -->
<form method="post" action="./" enctype="multipart/form-data">
    <input type="hidden" name="_csrf" value="<?= $_SESSION['csrf']; ?>" />
    <input type="hidden" name="_method" value="update" /><!-- POST, PUT, PATCH, DELETE -->
    <input type="hidden" name="content_type" value="<?= $ROUTES['action'] ? $ROUTES['action'] : 'intro'; ?>" />
</form>

<?php
include(LAYOUT_PATH . $layout . DS . 'footer.php');
include(LAYOUT_PATH . $layout . DS . 'foot.php');

// this is it
