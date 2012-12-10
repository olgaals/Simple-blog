-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2012 at 06:12 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.15-pl0-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `simpleblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `blog_comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `email_id`, `blog_comment`, `created_at`) VALUES
(2, 5, 2, '\n&lt;p&gt;Nice!&lt;/p&gt;\n', '2012-12-10 18:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `blog_post` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `email_id`, `title`, `blog_post`, `created_at`) VALUES
(5, 2, 'Lepidoptera', '\n&lt;img src=&quot;http://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Danaus_plexippus_%26_Actias_luna.jpg/220px-Danaus_plexippus_%26_Actias_luna.jpg&quot;&gt;\r\nLepidoptera (play /&amp;Euml;&amp;#140;l&amp;Eacute;&amp;#155;p&amp;Eacute;&amp;uml;&amp;Euml;&amp;#136;d&amp;Eacute;&amp;#146;pt&amp;Eacute;&amp;#153;r&amp;Eacute;&amp;#153;/ lep-i-DOP-t&amp;Eacute;&amp;#153;r-&amp;Eacute;&amp;#153;) is a large order of insects that includes moths and butterflies (both called lepidopterans). It is one of the most widespread and widely recognizable insect orders in the world,[1] encompassing moths and the three superfamilies of butterflies, skipper butterflies, and moth-butterflies. The term was coined by Linnaeus in 1735 and is derived from Ancient Greek &amp;Icirc;&amp;raquo;&amp;Icirc;&amp;micro;&amp;Iuml;&amp;#128;&amp;Icirc;&amp;macr;&amp;Icirc;&amp;acute;&amp;Icirc;&amp;iquest;&amp;Iuml;&amp;#130; (scale) and &amp;Iuml;&amp;#128;&amp;Iuml;&amp;#132;&amp;Icirc;&amp;micro;&amp;Iuml;&amp;#129;&amp;Iuml;&amp;#140;&amp;Icirc;&amp;frac12; (wing).[2] Comprising an estimated 174,250 species,[3] in 126 families[4] and 46 superfamilies,[3] the Lepidoptera show many variations of the basic body structure that have evolved to gain advantages in lifestyle and distribution. Recent estimates suggest that the order may have more species than earlier thought,[5] and is among the four most speciose orders, along with the Hymenoptera, Diptera, and the Coleoptera.[1]\n', '2012-12-10 18:00:26'),
(6, 2, 'Proboscis', '\n&lt;img src=&quot;http://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Butterfly_portrait.jpg/220px-Butterfly_portrait.jpg&quot;&gt;\r\nA proboscis /pro&amp;Ecirc;&amp;#138;&amp;Euml;&amp;#136;b&amp;Eacute;&amp;#146;s&amp;Eacute;&amp;ordf;s/ is an elongated appendage from the head of an animal, either a vertebrate or an invertebrate. In invertebrates, the term usually refers to tubular mouthparts used for feeding and sucking. In vertebrates, the term is used to describe an elongated nose or snout.\n', '2012-12-10 18:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(2, 'example@example.com', '7783c8e559705e14365a600a5e94143c');
