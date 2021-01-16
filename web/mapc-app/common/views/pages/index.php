<?php
$layout = 'admin-lte';

$v['head']['extension'] = <<<EOT
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
EOT;

include(LAYOUT_PATH . $layout . '/head.php');
include(LAYOUT_PATH . $layout . '/header.php');
?>

<section class="content">

<!-- Content : B -->
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>UID</th>
            <th>제목</th>
            <th>글쓴날</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($v['pagesList'] as $var) {
        ?>
        <tr>
            <td><?= $var['page_uid']; ?></td>
            <td><?= $var['page_title']; ?></td>
            <td><?= $var['page_regdate']; ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<!-- Content : E -->

</section>

<?php

$v['footer']['extension'] = <<<EOT
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
EOT;

// include(LAYOUT_PATH . 'admin-lte/_body.html');
include(LAYOUT_PATH . $layout . '/footer.php');
include(LAYOUT_PATH . $layout . '/foot.php');

// this is it
