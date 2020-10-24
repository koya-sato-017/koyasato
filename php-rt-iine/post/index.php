<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログインしている
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
} else {
    // ログインしていない
    header('Location: login.php');
    exit();
}

// 投稿を記録する
if (!empty($_POST)) {
    if ($_POST['message'] != '') {
        $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_post_id=?, created=NOW()');
        $message->execute(array(
            $member['id'],
            $_POST['message'],
            $_POST['reply_post_id']
        ));

        header('Location: index.php');
        exit();
    }
}

// 投稿を取得する
$page = $_REQUEST['page'];
if ($page == '') {
    $page = 1;
}
$page = max($page, 1);

// 最終ページを取得する
$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxPage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxPage);

$start = ($page - 1) * 5;

$posts = $db->prepare
    ('SELECT m.name, m.picture, p.* 
    FROM members m, retweets r, 
        (SELECT posts.*, li_cnt, rt.retweet_post_id, rt.retweet_member_id, rt_cnt FROM posts 
        LEFT JOIN 
            (SELECT like_post_id, COUNT(like_post_id) AS li_cnt FROM likes GROUP BY like_post_id) AS li 
        ON posts.id=li.like_post_id 
        LEFT JOIN
            (SELECT retweet_post_id, retweet_member_id, COUNT(retweet_post_id) AS rt_cnt FROM retweets r GROUP BY retweet_post_id) AS rt
        ON posts.id=rt.retweet_post_id
        ) p 
    WHERE m.id=p.member_id AND m.id=r.retweet_member_id 
    GROUP BY p.id 
    ORDER BY p.created DESC LIMIT ?, 5');
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();

// 返信の場合
if (isset($_REQUEST['res'])) {
    $response = $db->prepare
    ('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
    $response->execute(array($_REQUEST['res']));

    $table = $response->fetch();
    $message = '@' . $table['name'] . ' ' . $table['message'];
}

// リツイート元のメンバーの情報を取り出す
$rtMemberId = $db->prepare
('SELECT p.*, m.id, m.name, m.picture FROM posts p LEFT JOIN members m ON p.rt_member_id=m.id');
$rtMemberId->execute(array());
$rtMbrId = $rtMemberId->fetch();

$rtMessageId = $db->prepare
('SELECT p.id, p.message, r.retweet_post_id FROM posts p, retweets r WHERE p.id=r.retweet_post_id ORDER BY p.created DESC');
$rtMessageId->execute(array());
$rtMsgId = $rtMessageId->fetch();

('SELECT p.*, m.id, m.name, m.picture FROM posts p LEFT JOIN members m ON p.rt_member_id=m.id');

// $rtMessages = $db->prepare
// ('SELECT m.name, m.picture, r.* FROM members m, retweets r WHERE m.id=r.retweet_member_id ORDER BY r.created DESC');
// $rtMessages->execute(array());
// $rtMessage = $rtMessages->fetch();

// htmlspecialcharsのショートカット
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}

// 本文内のURLにリンクを設定する
function makeLink($value) {
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%.!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>' , $value);
}

// 自身がいいねしたメッセージIDの一覧情報を作り出す
$likeMessages = $db->prepare('SELECT like_post_id FROM likes WHERE like_member_id=?');
$likeMessages->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
$likeMessages->execute();
$likeMsg = array();
foreach ($likeMessages as $liMsg) {
  $likeMsg[] = $liMsg;
}

// 自身がRTしたメッセージIDの一覧情報を作り出す
$rtMessages = $db->prepare('SELECT retweet_post_id FROM retweets WHERE retweet_member_id=?');
$rtMessages->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
$rtMessages->execute();
$rtMsg = array();
foreach ($rtMessages as $rtMsg) {
  $rtMsg[] = $rtMsg;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ひとこと掲示板</title>

<link rel="stylesheet" href="style.css" />
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
<div id="wrap">
    <div id="head">
        <h1>ひとこと掲示板</h1>
    </div>
    <div id="content">
        <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
        <form action="" method="post">
            <dl>
                <dt><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん、メッセージをどうぞ</dt>
                <dd>
                    <textarea name="message" cols="50" rows="5"><?php echo h($message); ?></textarea>
                    <input type="hidden" name="reply_post_id" value="<?php echo h($_REQUEST['res']); ?>" />
                </dd>
            </dl>
            <div>
                <input type="submit" value="投稿する" />
            </div>
        </form>

        <?php
        foreach ($posts as $post):
            $liExist = 0;
            for ($i=0; $i<count($likeMsg); $i++) {
                if ($likeMsg[$i]['like_post_id'] == $post['id']) {
                    $liExist = $post['id'];
                    break;
                }
            }
            $rtExist = 0;
            for ($i=0; $i<count($rtMsg); $i++) {
                if ($rtMsg[$i]['retweet_post_id'] == $post['id']) {
                    $rtExist = $post['id'];
                    break;
                }
            }

        ?>
        
        <div class="msg">
            <p>
            <?php if ($post['rt_post_id'] > 0): ?>
                <p><?php echo h($post['name']); ?>さんがリツイート</p>
                <img src="member_picture/<?php echo h($rtMbrId['picture']); ?>" width="48" height="48" alt="<?php echo h($post['name']); ?>" />
                <p><?php echo makeLink(h($post['message'])); ?><span class="name">（<?php echo h($rtMbrId['name']); ?>）</span>
                [<a href="index.php?res=<?php echo h($post['id']); ?>">Re</a>]</p>
                <p class="day"><a href="view.php?id=<?php echo h($post['id']); ?>"><?php echo h($post['created']); ?></a>
                    <?php if ($post['reply_post_id'] > 0): ?>
                        <a href="view.php?id=<?php echo h($post['reply_post_id']); ?>">返信元のメッセージ</a>
                    <?php endif; ?>
            <?php else: ?>
                <img src="member_picture/<?php echo h($post['picture']); ?>" width="48" height="48" alt="<?php echo h($post['name']); ?>" />
                <p><?php echo makeLink(h($post['message'])); ?><span class="name">（<?php echo h($post['name']); ?>）</span>
                [<a href="index.php?res=<?php echo h($post['id']); ?>">Re</a>]</p>
                <p class="day"><a href="view.php?id=<?php echo h($post['id']); ?>"><?php echo h($post['created']); ?></a>
                    <?php if ($post['reply_post_id'] > 0): ?>
                        <a href="view.php?id=<?php echo h($post['reply_post_id']); ?>">返信元のメッセージ</a>
                    <?php endif; ?>
            <?php endif; ?>
            
            <!-- いいね！ボタン -->
            <?php if ($liExist > 0): ?>
                <a href="likes_delete.php?id=<?php echo h($post['id']); ?>" style=""><i class="fas fa-heart"></i></a><span><?php echo h($post['li_cnt']); ?></span>
            <?php else: ?>
                <a href="likes.php?id=<?php echo h($post['id']); ?>" style=""><i class="far fa-heart"></i></a><span><?php echo h($post['li_cnt']); ?></span>
            <?php endif; ?>
            <!-- RTボタン -->
            <?php if ($rtExist > 0): ?>
                <i class="fas fa-retweet"></i><a href="retweets_delete.php?id=<?php echo h($post['id']); ?>">取消</a><span><?php echo h($post['rt_cnt']); ?></span>
            <?php else: ?>
                <a href="retweets.php?id=<?php echo h($post['id']); ?>"><i class="fas fa-retweet"></i></a><span><?php echo h($post['rt_cnt']); ?></span>
            <?php endif; ?>

            <?php
            if ($_SESSION['id'] == $post['member_id']):
            ?>
            [<a href="delete.php?id=<?php echo h($post['id']); ?>" style="color: #F33;">削除</a>]
            <?php
            endif;
            ?>

            </p>
        </div>
        <?php
        endforeach;
        ?>

        <ul class="paging">
        <?php
        if ($page > 1) {
        ?>
        <li><a href="index.php?page=<?php print($page - 1); ?>">前のページへ</a></li>
        <?php
        } else {
        ?>
        <li>前のページへ</li>
        <?php
        }
        ?>
        <?php
        if ($page < $maxPage) {
        ?>
        <li><a href="index.php?page=<?php print($page + 1); ?>">次のページへ</a></li>
        <?php
        } else {
        ?>
        <li>次のページへ</li>
        <?php
        }
        ?>
        </ul>
    </div>
</div>
</body>
</html>
