<?php
session_start();
require('dbconnect.php');

// RTが登録済みかチェックするため情報を取得する
if (isset($_SESSION['id'])) {
        $retweets = $db->prepare('SELECT COUNT(retweet_post_id) AS rt_cnt FROM retweets WHERE retweet_post_id=? AND retweet_member_id=? GROUP BY retweet_post_id');
        $retweets->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));
        $retweet = $retweets->fetch();

        // RTを取消しようとしている投稿が1件のみか確認する
        if ($retweet['rt_cnt'] == 1) {
            // RTを削除する
            $retweet_del = $db->prepare('DELETE FROM retweets WHERE retweet_post_id=? AND retweet_member_id=?');
            $retweet_del->execute(array(
              $_REQUEST['id'],
              $_SESSION['id']
            ));
          }
}

header('Location: index.php');
exit();
?>