<?php
session_start();
require('dbconnect.php');

// いいねが登録済みかチェックするため情報を取得する
if (isset($_SESSION['id'])) {
        $likes = $db->prepare('SELECT COUNT(like_post_id) AS li_cnt FROM likes WHERE like_post_id=? AND like_member_id=? GROUP BY like_post_id');
        $likes->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));
        $like = $likes->fetch();
        // var_dump($like);

        // いいねしようとしている投稿に対して、すでにいいねをしていないかチェックする
        if ($like['li_cnt'] == 0) {
            // いいねを登録する
            $like_ins = $db->prepare('INSERT INTO likes SET like_post_id=?, like_member_id=?, created=NOW()');
            $like_ins->execute(array(
              $_REQUEST['id'],
              $_SESSION['id']
            ));
          }
          // var_dump($like['li_cnt']);
          // exit();
}

header('Location: index.php');
exit();
?>