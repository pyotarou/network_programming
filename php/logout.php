<?php
    @session_start();
    // ログインしていなければ /login.html に遷移
    if (!isset($_SESSION['name'])) {
        header('Location: ../login.html');
        exit;
    }

    // セッション用のCookieの破棄
    setcookie(session_name(), '', 1);
    // セッションファイルの破棄
    session_destroy();
    // ログアウト完了後に login.html に遷移
    header('Location: ../login.html');
?>