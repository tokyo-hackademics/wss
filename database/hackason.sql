-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1
-- 生成日時: 2015 年 5 月 17 日 09:15
-- サーバのバージョン: 5.5.27
-- PHP のバージョン: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `hackason`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- テーブルのデータのダンプ `question`
--

INSERT INTO `question` (`question_id`, `user_id`, `content`, `photo`) VALUES
(1, 5, 'adfasfjakj', '20150516211256'),
(2, 6, 'dsfjsdlkfja\nsldkjflsjflsj\n', '20150516211724'),
(3, 7, 'sakdjkljklsjdfljsj\nslkdjflsjkfs\n', '20150516211823'),
(4, 8, 'dsflksjfdlkjsljflksjl', '20150516213820'),
(5, 9, 'コメント', '20150516214227'),
(6, 10, '将棋についていろいろ知りたいです。', '20150516220225'),
(7, 10, '将棋についていろいろ知りたいです。', '20150516220253'),
(8, 10, '将棋についていろいろ知りたいです。', '20150516220334'),
(9, 10, '将棋についていろいろ知りたいです。', '20150516220356'),
(10, 10, '将棋についていろいろ知りたいです。', '20150516220451'),
(11, 10, '将棋についていろいろ知りたいです。', '20150516220726'),
(12, 11, 'Yeah', '20150516222416'),
(13, 11, 'Yeah', '20150516222559'),
(14, 12, '質問！', '20150516222908'),
(15, 15, 'test', '20150516223443'),
(16, 15, 'test', '20150516223532'),
(17, 15, 'test', '20150516223623'),
(18, 16, 'イケメン', '20150516223805');

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `photo` text,
  `date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `photo`, `date`) VALUES
(1, '', 'rmurai@pro-seeds.co.jp', NULL, '2015-05-16'),
(2, '', 'rmurai@pro-seeds.co.jp', NULL, '2015-05-16'),
(3, '', 'murai', NULL, '2015-05-16'),
(4, '', '', NULL, '2015-05-16'),
(5, '', 'rmurai@pro-seeds.co.jp', NULL, '2015-05-16'),
(6, '', 'r0317k0226@gmail.com', NULL, '2015-05-16'),
(7, '', 'email', NULL, '2015-05-16'),
(8, '', 'murai', NULL, '2015-05-16'),
(9, '', 'knakamoto@pro-seeds.co.jp', NULL, '2015-05-16'),
(10, '', 'r0317k0226@gmail.com', NULL, '2015-05-16'),
(11, '', 'youkay.et@gmail.com', NULL, '2015-05-16'),
(12, '', 'youkay.et@gmail.com', NULL, '2015-05-16'),
(13, '', 'youkay.et@gmail.com', NULL, '2015-05-16'),
(14, '', 'r0317k0226@gmail.com', NULL, '2015-05-16'),
(15, '', 'r0317k0226@gmail.com', NULL, '2015-05-16'),
(16, '', 'r0317k0226@gmail.com', NULL, '2015-05-16'),
(17, '', '', NULL, '2015-05-17');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
