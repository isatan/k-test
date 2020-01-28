CREATE TABLE `ai_analysis_log` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `image_path` varchar(255) DEFAULT NULL,
    `success` varchar(255) DEFAULT NULL,
    `message` varchar(255) DEFAULT NULL,
    `class` int(11) DEFAULT NULL,
    `confidence` decimal(5,4) DEFAULT NULL,
    `request_timestamp` int(10) unsigned DEFAULT NULL,
    `response_timestamp` int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;