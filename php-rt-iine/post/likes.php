<?php
session_start();
require('dbconnect.php');

// いいねが登録済みかチェックするため情報を取得する
require('likes_check.php');
$like = likeCheck($db);

// いいねしようとしている投稿に対して、すでにいいねをしていないかチェックする
if ($like['li_cnt'] == 0) {
    // いいねを登録する
    $like_ins = $db->prepare('INSERT INTO likes SET like_post_id=?, like_member_id=?, created=NOW()');
    $like_ins->execute(array(
      $_GET['member_id'],
      $_SESSION['member_id']
    ));
  }

header('Location: index.php');
exit();
?>