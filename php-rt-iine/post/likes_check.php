<?php
// いいねが登録済みかチェックするため情報を取得する
if (isset($_SESSION['member_id'])) {
    $likes = $db->prepare('SELECT COUNT(like_post_id) AS li_cnt FROM likes WHERE like_post_id=? AND like_member_id=? GROUP BY like_post_id');
    $likes->execute(array(
        $_GET['member_id'],
        $_SESSION['member_id']
    ));
    $like = $likes->fetch();
}