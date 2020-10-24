-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2020 年 10 月 24 日 20:37
-- サーバのバージョン： 5.7.26
-- PHP のバージョン: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `mini_bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `like_post_id` int(11) NOT NULL,
  `like_member_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `like_post_id`, `like_member_id`, `created`, `modified`) VALUES
(58, 23, 1, '2020-10-17 22:13:10', '2020-10-17 13:13:10'),
(60, 20, 1, '2020-10-17 22:15:35', '2020-10-17 13:15:35'),
(61, 17, 1, '2020-10-17 22:15:42', '2020-10-17 13:15:42'),
(62, 16, 1, '2020-10-17 22:15:48', '2020-10-17 13:15:48'),
(63, 22, 1, '2020-10-18 05:37:57', '2020-10-17 20:37:57'),
(66, 22, 2, '2020-10-18 05:39:51', '2020-10-17 20:39:51'),
(67, 18, 2, '2020-10-18 05:39:58', '2020-10-17 20:39:58'),
(71, 17, 2, '2020-10-18 05:51:09', '2020-10-17 20:51:09'),
(72, 16, 2, '2020-10-18 05:51:19', '2020-10-17 20:51:19'),
(73, 22, 3, '2020-10-18 05:51:48', '2020-10-17 20:51:48'),
(74, 23, 3, '2020-10-18 05:51:51', '2020-10-17 20:51:51'),
(75, 20, 3, '2020-10-18 05:51:53', '2020-10-17 20:51:53'),
(76, 25, 2, '2020-10-18 05:52:59', '2020-10-17 20:52:59'),
(77, 24, 2, '2020-10-18 05:53:00', '2020-10-17 20:53:00'),
(78, 26, 1, '2020-10-18 06:16:34', '2020-10-17 21:16:34'),
(80, 38, 2, '2020-10-23 10:20:28', '2020-10-23 01:20:28'),
(81, 37, 2, '2020-10-23 14:58:10', '2020-10-23 05:58:10'),
(82, 55, 2, '2020-10-24 21:51:55', '2020-10-24 12:51:55'),
(83, 55, 3, '2020-10-24 21:52:15', '2020-10-24 12:52:15'),
(85, 58, 2, '2020-10-24 22:13:32', '2020-10-24 13:13:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `created`, `modified`) VALUES
(1, 'コウヤ', 'koya@sato.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '20200930225323IMG_0156.jpg', '2020-10-01 07:56:42', '2020-09-30 22:56:42'),
(2, 'ラッキーピエロ', 'caramel-pavilion.xux@ezweb.ne.jp', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '20201002195933IMG_0796.jpg', '2020-10-03 04:59:35', '2020-10-02 19:59:35'),
(3, 'N高の講師', 'N@kou.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '20201003035849about_img04_02.jpg', '2020-10-03 12:59:18', '2020-10-03 03:59:18');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `reply_post_id` int(11) NOT NULL,
  `rt_post_id` int(11) NOT NULL,
  `rt_member_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `reply_post_id`, `rt_post_id`, `rt_member_id`, `created`, `modified`) VALUES
(2, '今日は出勤なので、KAKELCODEはお休み。', 1, 0, 0, 0, '2020-10-03 04:58:51', '2020-10-02 19:58:51'),
(3, 'おはようございます', 2, 0, 0, 0, '2020-10-03 05:00:48', '2020-10-02 20:00:48'),
(4, 'お疲れさまです！\r\n\r\n@コウヤ　今日は出勤なので、KAKELCODEはお休み。', 2, 0, 0, 0, '2020-10-03 05:14:38', '2020-10-02 20:14:38'),
(6, '帰りたい。時間の無駄やな〜', 2, 0, 0, 0, '2020-10-03 12:57:03', '2020-10-03 03:57:03'),
(7, 'そんな時は、やっている作業に意味を見出すようにするといいですよ。\r\nあとは、帰りたいオーラを出す。笑\r\n\r\n@ラッキーピエロ 帰りたい。時間の無駄やな〜', 3, 0, 0, 0, '2020-10-03 13:01:10', '2020-10-03 04:01:10'),
(8, 'なるほど、ありがとうございます！！\r\n\r\n@N高の講師 そんな時は、やっている作業に意味を見出すようにするといいですよ。\r\nあとは、帰りたいオーラを出す。笑\r\n\r\n@ラッキーピエロ 帰りたい。時間の無駄やな〜', 2, 7, 0, 0, '2020-10-03 13:03:59', '2020-10-03 04:03:59'),
(9, 'よし、23時までやる！', 1, 0, 0, 0, '2020-10-03 21:54:48', '2020-10-03 12:54:48'),
(10, 'フォローよろしくです\r\nhttps://twitter.com/home?lang=ja', 1, 0, 0, 0, '2020-10-03 22:59:29', '2020-10-03 13:59:29'),
(11, 'おはようございます。\r\n寝不足ですね、ちょっと無理しすぎかもです。。', 1, 0, 0, 0, '2020-10-04 05:05:35', '2020-10-03 20:05:35'),
(12, 'コウヤさんおはようございます！\r\n無理しすぎないようにしてくださいね！\r\n今日もやっていきましょう〜\r\n\r\n@コウヤ おはようございます。\r\n寝不足ですね、ちょっと無理しすぎかもです。。', 2, 11, 0, 0, '2020-10-04 05:22:42', '2020-10-03 20:22:42'),
(13, '眠たい〜', 2, 0, 0, 0, '2020-10-04 11:54:52', '2020-10-04 02:54:52'),
(14, 'みなさん、お疲れさまです。\r\n自分のペースで学習を進めていきましょう。', 3, 0, 0, 0, '2020-10-04 12:05:14', '2020-10-04 03:05:14'),
(15, 'おはようございます。\r\ndumpファイルについて調べ中。。', 1, 0, 0, 0, '2020-10-05 06:05:56', '2020-10-04 21:05:56'),
(16, 'MAMPのルートディレクトリをgitディレクトリに変更するということを試みる。', 1, 0, 0, 0, '2020-10-05 21:56:36', '2020-10-05 12:56:36'),
(17, 'お、できた！\r\nこれでhtdocsとはおさらば！', 1, 0, 0, 0, '2020-10-05 21:58:02', '2020-10-05 12:58:02'),
(18, '課題に取りかかる前に、いろいろ知らないことやら諸々あって、課題になかなか取りかかれない', 1, 0, 0, 0, '2020-10-05 22:11:01', '2020-10-05 13:11:01'),
(19, '明日は商談なので、朝早い＆夜遅い', 2, 0, 0, 0, '2020-10-05 22:12:45', '2020-10-05 13:12:45'),
(20, '昨日は商談で一日プログラミングできず。\r\n夜も帰り遅くなってHP残りわずかだったから寝た。\r\nよし、今日はまたここから積み上げますよー！', 2, 0, 0, 0, '2020-10-07 05:12:33', '2020-10-06 20:12:33'),
(22, 'いいね！の情報がデータベースに入ったぞ！', 1, 0, 0, 0, '2020-10-12 14:47:39', '2020-10-12 05:47:39'),
(23, 'あれ、画像が表示されなくなったぞ', 2, 0, 0, 0, '2020-10-14 05:54:37', '2020-10-13 20:54:37'),
(24, 'いいね！機能、たぶんうまくいったー！！！！\r\nたぶん…', 1, 0, 0, 0, '2020-10-18 05:52:29', '2020-10-17 20:52:29'),
(25, 'さて、RT機能の実装に挑みます。', 1, 0, 0, 0, '2020-10-18 05:52:48', '2020-10-17 20:52:48'),
(26, '引き続きがんばってください。\r\n\r\n@コウヤ いいね！機能、たぶんうまくいったー！！！！\r\nたぶん…', 3, 24, 0, 0, '2020-10-18 05:53:40', '2020-10-17 20:53:40'),
(30, '引き続きがんばってください。\r\n\r\n@コウヤ いいね！機能、たぶんうまくいったー！！！！\r\nたぶん…', 1, 0, 0, 0, '2020-10-19 13:00:46', '2020-10-19 04:00:46'),
(31, 'いいね！機能、たぶんうまくいったー！！！！\r\nたぶん…', 2, 0, 0, 0, '2020-10-19 13:03:53', '2020-10-19 04:03:53'),
(37, 'リレーションやら外部結合やらが理解できてないぞー！', 1, 0, 0, 0, '2020-10-22 05:08:25', '2020-10-21 20:08:25'),
(38, 'SQL文が複雑すぎるのをどうにかしたいけど、壊れそうでいじるのこわい…', 1, 0, 0, 0, '2020-10-23 10:20:13', '2020-10-23 01:20:13'),
(55, 'ついに完成したぞ！たぶん！', 1, 0, 0, 0, '2020-10-24 21:51:41', '2020-10-24 12:51:41'),
(56, 'ついに完成したぞ！たぶん！', 2, 0, 55, 1, '2020-10-24 21:51:57', '2020-10-24 12:51:57'),
(57, 'ついに完成したぞ！たぶん！', 3, 0, 55, 1, '2020-10-24 21:52:17', '2020-10-24 12:52:17'),
(58, 'あとは、無駄なコードやらを消してなるべく整理した状態で提出したい。', 1, 0, 0, 0, '2020-10-24 22:03:03', '2020-10-24 13:03:03');

-- --------------------------------------------------------

--
-- テーブルの構造 `retweets`
--

CREATE TABLE `retweets` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `retweet_post_id` int(11) NOT NULL,
  `retweet_member_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `retweets`
--

INSERT INTO `retweets` (`id`, `message`, `retweet_post_id`, `retweet_member_id`, `created`) VALUES
(1, '引き続きがんばってください。\r\n\r\n@コウヤ いいね！機能、たぶんうまくいったー！！！！\r\nたぶん…', 26, 1, '2020-10-21 05:50:49'),
(2, '昨日は商談で一日プログラミングできず。\r\n夜も帰り遅くなってHP残りわずかだったから寝た。\r\nよし、今日はまたここから積み上げますよー！', 20, 1, '2020-10-21 05:55:39'),
(3, 'みなさん、お疲れさまです。\r\n自分のペースで学習を進めていきましょう。', 14, 1, '2020-10-21 05:55:49'),
(4, 'コウヤさんおはようございます！\r\n無理しすぎないようにしてくださいね！\r\n今日もやっていきましょう〜\r\n\r\n@コウヤ おはようございます。\r\n寝不足ですね、ちょっと無理しすぎかもです。。', 12, 1, '2020-10-21 05:56:02'),
(19, 'さて、RT機能の実装に挑みます。', 25, 2, '2020-10-23 14:57:52'),
(53, 'ついに完成したぞ！たぶん！', 55, 2, '2020-10-24 21:51:57'),
(54, 'ついに完成したぞ！たぶん！', 55, 3, '2020-10-24 21:52:17');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `retweets`
--
ALTER TABLE `retweets`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- テーブルのAUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- テーブルのAUTO_INCREMENT `retweets`
--
ALTER TABLE `retweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
