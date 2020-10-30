<?php
session_start();
require('dbconnect.php');

// RTが登録済みかチェックするため情報を取得する
if (isset($_SESSION['member_id'])) {
        $retweets = $db->prepare('SELECT COUNT(rt_post_id) AS rt_cnt FROM posts WHERE rt_post_id=? AND member_id=? GROUP BY rt_post_id');
        $retweets->execute(array(
            $_GET['member_id'],
            $_SESSION['member_id']
        ));
        $retweet = $retweets->fetch();

        // RTを取消しようとしている投稿が1件のみか確認する
        if ($retweet['rt_cnt'] == 1) {
            // RTを削除する
            $retweets_del = $db->prepare('DELETE FROM posts WHERE rt_post_id=? AND member_id=?');
            $retweets_del->execute(array(
              $_GET['member_id'],
              $_SESSION['member_id']
            ));
          }
}

header('Location: index.php');
exit();
?>