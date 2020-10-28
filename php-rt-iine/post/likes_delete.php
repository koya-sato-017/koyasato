<?php
session_start();
require('dbconnect.php');

// いいねが登録済みかチェックするため情報を取得する
if (isset($_SESSION['member_id'])) {
        $likes = $db->prepare('SELECT COUNT(like_post_id) AS li_cnt FROM likes WHERE like_post_id=? AND like_member_id=? GROUP BY like_post_id');
        $likes->execute(array(
            $_GET['member_id'],
            $_SESSION['member_id']
        ));
        $like = $likes->fetch();

        // いいねを取消しようとしている投稿が1件のみか確認する
        if ($like['li_cnt'] == 1) {
            // いいねを削除する
            $like_del = $db->prepare('DELETE FROM likes WHERE like_post_id=? AND like_member_id=?');
            $like_del->execute(array(
              $_GET['member_id'],
              $_SESSION['member_id']
            ));
          }
}

header('Location: index.php');
exit();
?>