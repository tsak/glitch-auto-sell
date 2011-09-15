--
-- Table structure for table 'items'
--

CREATE TABLE items (
  id varchar(64) NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  class_tsid varchar(255) NOT NULL,
  name_single varchar(255) NOT NULL,
  name_plural varchar(255) NOT NULL,
  category varchar(32) NOT NULL,
  max_stack int(11) NOT NULL default '1',
  `desc` text,
  base_cost decimal(6,2) NOT NULL,
  swf_url varchar(255) NOT NULL,
  iconic_url varchar(255) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'listings'
--

CREATE TABLE listings (
  id varchar(64) NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  expires datetime NOT NULL,
  item_id varchar(64) NOT NULL,
  count int(11) NOT NULL,
  cost int(11) NOT NULL,
  url varchar(255) NOT NULL,
  player_tsid varchar(32) NOT NULL,
  player_name varchar(255) NOT NULL,
  PRIMARY KEY  (id),
  KEY item_id (item_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
