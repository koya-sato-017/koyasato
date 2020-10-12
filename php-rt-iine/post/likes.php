<?php
session_start();
require('dbconnect.php');

var_dump($_SESSION['id']);

if (isset($_SESSION['id'])) {
        $like = $db->prepare('INSERT INTO likes SET like_post_id=?, like_member_id=?, created=NOW()');
        $like->execute(array(
            $_REQUEST['id'],
            $_SESSION['id']
        ));
}

header('Location: index.php');
exit();
?>