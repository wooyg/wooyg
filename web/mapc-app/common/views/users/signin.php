<?php
include(LAYOUT_PATH . $layout . '/head.php');
include(LAYOUT_PATH . $layout . '/header.php');
?>

    <h1>로그인</h1>

    <form action="signup" method="post">
        <input type="hidden" name="_csrf" value="<?= $_SESSION['csrf']; ?>" />
        <input type="hidden" name="_method" value="update" /><!-- POST, PUT, PATCH, DELETE -->
        <div class="form-group">
            <input name="userid" type="text" placeholder="아이디 또는 이메일을 입력하세요." />
        </div>
        <div class="form-group">
            <input name="userpasswd" type="password" placeholder="비밀번호를 입력하세요.">
        </div>
        <div class="form-group">
            <input type="checkbox"> 아이디 저장
            <button class="button">확인</button>
        </div>
        <div class="form-group">
            <button class="button">확인</button>
        </div>
    </form>

<?php
include(LAYOUT_PATH . $layout . '/footer.php');
include(LAYOUT_PATH . $layout . '/foot.php');

// this is it
