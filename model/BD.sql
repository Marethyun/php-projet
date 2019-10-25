CREATE TABLE users
(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    pseudonym VARCHAR(12) NOT NULL UNIQUE,
    email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(16) NOT NULL,
);

CREATE TABLE threads
(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    creator_id INT(10) NOT NULL,
    creation_date date DEFAULT CURRENT_TIMESTAMP(),
    number_msg INT(10) DEFAULT 0,
    opened BOOLEAN DEFAULT 1,
    FOREIGN KEY (`creator_id`) REFERENCES `users`(`id`)
);

CREATE TABLE messages
(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    thread_id INT(10) NOT NULL,
    opened BOOLEAN DEFAULT 1,
    creation_date date DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (thread_id) REFERENCES threads(id) ON DELETE CASCADE
);

CREATE TABLE messagefragments
(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(10) NOT NULL,
    thread_id INT(10) NOT NULL,
    msg_id INT(10) NOT NULL,
    msg VARCHAR(255) NOT NULL,
    creation_date date DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (thread_id) REFERENCES threads(id),
    FOREIGN KEY (msg_id) REFERENCES messages(id) ON DELETE CASCADE
);

CREATE TABLE parametre
(
    etat INT(1) DEFAULT 1
);

INSERT INTO parametre VALUES()
-- UPDATE `parametre` SET `etat` = 0 WHERE 1
-- UPDATE `parametre` SET `etat` = 1 WHERE 1

-- Drop table messagefragments;
-- Drop table messages;
-- Drop table threads;


DELIMITER //
CREATE OR REPLACE TRIGGER inter_psw
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE para INT;
    SELECT etat INTO para FROM parametre;
    IF para = 1 THEN
        IF OLD.password != NEW.password THEN RESIGNAL SQLSTATE '45000';
        END IF;
    END IF;
END;//

-- UPDATE `user` SET `password` = 'max99' WHERE `id_user` = 1

DELIMITER //
CREATE OR REPLACE TRIGGER insert_threads
AFTER INSERT ON threads
FOR EACH ROW
BEGIN
    INSERT INTO `messages` (`thread_id`) VALUES (NEW.id);
END;//

-- INSERT INTO `threads`(`creator_id`) VALUES (1);

DELIMITER //
CREATE OR REPLACE TRIGGER insert_msg
AFTER INSERT ON messages
FOR EACH ROW
BEGIN
    UPDATE threads SET `number_msg` = `number_msg` + 1 WHERE NEW.thread_id = threads.id;
END;//

DELIMITER //
CREATE OR REPLACE TRIGGER del_disc
AFTER DELETE ON messages
FOR EACH ROW
BEGIN
    UPDATE threads SET `number_msg` = `number_msg` - 1 WHERE OLD.thread_id = threads.thread_id;
END;//

DELIMITER //
CREATE OR REPLACE TRIGGER insert_msgfrag
BEFORE INSERT ON messagefragments
FOR EACH ROW
BEGIN
    DECLARE test INT;
    SELECT COUNT(user_id) INTO test FROM messagefragments
    WHERE NEW.user_id = messagefragments.user_id AND NEW.thread_id = messagefragments.thread_id;
    IF test >= 1 THEN RESIGNAL;
    END IF;
END;//

-- INSERT INTO `messagefragments`(`user_id`, `thread_id`, `msg_id`, `msg`) VALUES (1,6,1, 'flflflo')

-- DELIMITER //
-- CREATE OR REPLACE FUNCTION is_exist_email(email_test VARCHAR(30)) RETURN BOOLEAN
-- BEGIN
--     DECLARE email_inter INT;
--     SELECT COUNT(email) INTO email_inter FROM user
--     WHERE email_test = user.email;
--     IF email_inter > 0 THEN
--         RETURN TRUE;
--     END IF;
--     RETURN FALSE;
-- END; //

-- DELIMITER $$
-- CREATE OR REPLACE FUNCTION is_exist_email(email_test VARCHAR(30)) RETURN VARCHAR(30) DETERMINISTIC
-- BEGIN
--     DECLARE email_inter INT(1);
--     SELECT COUNT(email) INTO email_inter FROM user
--     WHERE email_test = user.email;
--     IF email_inter > 0 THEN
--         RETURN "SALUT";
--     END IF;
--     RETURN "AURAVOIr";
-- END $$
--
-- DELIMITER ;
