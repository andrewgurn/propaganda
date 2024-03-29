SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS propaganda DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE propaganda;

CREATE TABLE propaganda (
  id int(11) NOT NULL,
  dateStart datetime NOT NULL,
  dateEnd datetime NOT NULL,
  contentType varchar(50) NOT NULL,
  contentLocation varchar(500) NOT NULL,
  displayTime int(11) NOT NULL,
  addedBy varchar(255) NOT NULL,
  isDeleted int(11) NOT NULL DEFAULT 0,
  getVariables varchar(255) NOT NULL DEFAULT '',
  channelID int(11) NOT NULL DEFAULT 1,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE propaganda
  ADD PRIMARY KEY (id);

ALTER TABLE propaganda
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

CREATE TABLE propagandaChannel (
  id int(11) NOT NULL,
  channelName varchar(50) NOT NULL,
  addedBy varchar(50) NOT NULL,
  addedDate datetime NOT NULL,
  isDisabled int(11) NOT NULL DEFAULT 0,
  disabledBy varchar(50) NOT NULL,
  disabledDate datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE propagandaChannel
  ADD PRIMARY KEY (id);

INSERT INTO propagandaChannel (id, channelName, addedBy, addedDate, isDisabled, disabledBy, disabledDate) VALUES
(1, 'All Channels', 'default', '2023-07-17 09:18:49', 0, '', '0000-00-00 00:00:00'),

ALTER TABLE propagandaChannel
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
