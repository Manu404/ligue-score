-- CREATE USER
CREATE USER 'mtg_league'@'localhost' IDENTIFIED BY 'tmp123';
GRANT ALL PRIVILEGES ON mtg_league.* TO 'mtg_league'@'localhost';
FLUSH PRIVILEGES;

-- ALLOW FULL GROUP BY
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
