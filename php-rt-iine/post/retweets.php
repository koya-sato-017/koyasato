<?php
session_start();
require('dbconnect.php');

// RTが登録済みかチェックするため情報を取得する
if (isset($_SESSION['member_id'])) {
        $retweets = $db->prepare
        ('SELECT COUNT(rt_post_id) AS rt_cnt FROM posts WHERE rt_post_id=? AND rt_member_id=? GROUP BY rt_post_id');
        $retweets->execute(array(
            $_GET['member_id'],
            $_SESSION['member_id']
        ));
        $retweet = $retweets->fetch();

        // RTしようとしている投稿に対して、すでにRTをしていないかチェックする
        if ($retweet['rt_cnt'] == 0) {
        // RTを登録する
        $retweet = $db->prepare
        ('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
        $retweet->execute(array($_GET['member_id']));
        $rt_table = $retweet->fetch();
        
        $posts_ins = $db->prepare
        ('INSERT INTO posts SET message=?, member_id=?, rt_post_id=?, rt_member_id=?, created=NOW()');
        $posts_ins->execute(array(
            $rt_table['message'], 
            $_SESSION['member_id'], 
            $_GET['member_id'],
            $rt_table['member_id']
        ));
    }
}

header('Location: index.php');
exit();
?>