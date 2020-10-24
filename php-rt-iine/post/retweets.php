<?php
session_start();
require('dbconnect.php');

// RTが登録済みかチェックするため情報を取得する
if (isset($_SESSION['id'])) {
        $retweets = $db->prepare
        ('SELECT COUNT(retweet_post_id) AS rt_cnt FROM retweets WHERE retweet_post_id=? AND retweet_member_id=? GROUP BY retweet_post_id');
        $retweets->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));
        $retweet = $retweets->fetch();

        // RTしようとしている投稿に対して、すでにRTをしていないかチェックする
        if ($retweet['rt_cnt'] == 0) {
        // RTを登録する
        $retweet = $db->prepare
        ('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
        $retweet->execute(array($_REQUEST['id']));
        $rt_table = $retweet->fetch();

        $rt_ins = $db->prepare
        ('INSERT INTO retweets SET message=?, retweet_post_id=?, retweet_member_id=?, created=NOW()');
        $rt_ins->execute(array(
            $rt_table['message'], 
            $_REQUEST['id'], 
            $_SESSION['id']
        ));
        }
        $posts_ins = $db->prepare
        ('INSERT INTO posts SET message=?, member_id=?, rt_post_id=?, rt_member_id=?, created=NOW()');
        $posts_ins->execute(array(
            $rt_table['message'], 
            $_SESSION['id'], 
            $_REQUEST['id'],
            $rt_table['member_id']
        ));
}

header('Location: index.php');
exit();
?>