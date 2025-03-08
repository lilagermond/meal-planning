SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database : `dailymeal`
--

-- --------------------------------------------------------

--
-- Table `attribute`
--

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE IF NOT EXISTS `attribute` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(100) NOT NULL,
  `max_number` int NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;


-- --------------------------------------------------------

--
-- Table `cuisine`
--

DROP TABLE IF EXISTS `cuisine`;
CREATE TABLE IF NOT EXISTS `cuisine` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuisine_name` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Add default column
--

INSERT INTO `cuisine` (`id`, `cuisine_name`) VALUES
(1, 'Non définie');
COMMIT;

-- --------------------------------------------------------

--
-- Table `linked_attribute`
--

DROP TABLE IF EXISTS `linked_attribute`;
CREATE TABLE IF NOT EXISTS `linked_attribute` (
  `recipe_id` int NOT NULL,
  `attribute_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;


-- --------------------------------------------------------

--
-- Table `linked_season`
--

DROP TABLE IF EXISTS `linked_season`;
CREATE TABLE IF NOT EXISTS `linked_season` (
  `recipe_id` int NOT NULL,
  `season_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;


-- --------------------------------------------------------

--
-- Table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE IF NOT EXISTS `recipe` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `recipe_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cuisine_id` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;


-- --------------------------------------------------------

--
-- Table `season`
--

DROP TABLE IF EXISTS `season`;
CREATE TABLE IF NOT EXISTS `season` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `season_name` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Create table elements
--

INSERT INTO `season` (`id`, `season_name`) VALUES
(1, 'all'),
(2, 'winter'),
(3, 'spring'),
(4, 'summer'),
(5, 'autumn');
COMMIT;

-- --------------------------------------------------------

--
-- Table `week`
--

DROP TABLE IF EXISTS `week`;
CREATE TABLE IF NOT EXISTS `week` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `meal_number` int NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

-- --------------------------------------------------------

--
-- Table `week_historic`
--

DROP TABLE IF EXISTS `week_historic`;
CREATE TABLE IF NOT EXISTS `week_historic` (
  `week_id` int NOT NULL,
  `recipe_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

