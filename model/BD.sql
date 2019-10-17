CREATE TABLE user
(
    id_user INT(10) AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(12) NOT NULL UNIQUE,
    email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(16) NOT NULL,
    number_disc int(10) DEFAULT 0
);

CREATE TABLE discussion
(
    id_disc INT(10) AUTO_INCREMENT PRIMARY KEY,
    id_user INT(10) NOT NULL,
    text VARCHAR(255) NOT NULL,
    creation_date date DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

CREATE TABLE message
(
    id_msg INT(10) AUTO_INCREMENT PRIMARY KEY,
    id_user INT(10) NOT NULL,
    id_disc INT(10) NOT NULL,
    msg VARCHAR(255) NOT NULL,
    creation_date date DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_disc) REFERENCES discussion(id_disc) ON DELETE CASCADE
);

CREATE TABLE parametre
(
    etat INT(1) DEFAULT 1
);

INSERT INTO parametre VALUES()
-- UPDATE `parametre` SET `etat` = 0 WHERE 1
-- UPDATE `parametre` SET `etat` = 1 WHERE 1

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
CREATE OR REPLACE TRIGGER insert_msg
BEFORE INSERT ON message
FOR EACH ROW
BEGIN
    DECLARE test INT;
    SELECT COUNT(id_user) INTO test FROM message
    WHERE NEW.id_user = message.id_user AND NEW.id_disc = message.id_disc;
    IF test = 0 THEN
        UPDATE discussion SET `text` = CONCAT(`text` , ' ' , NEW.msg)
        WHERE NEW.id_disc = discussion.id_disc;
    ELSE
        RESIGNAL;
    END IF;
END;//

-- INSERT INTO `message`(`id_user`, `id_disc`, `msg`) VALUES (1,1,'MAX')

DELIMITER //
CREATE OR REPLACE TRIGGER insert_disc
AFTER INSERT ON discussion
FOR EACH ROW
BEGIN
    DECLARE test INT;
    SELECT number_disc INTO test FROM user WHERE NEW.id_user = user.id_user;
    IF test < 3 THEN
        UPDATE user SET `number_disc` = `number_disc` + 1
        WHERE NEW.id_user = user.id_user;
    ELSE
        RESIGNAL;
    END IF;
END;//

-- INSERT INTO `discussion`(`id_user`, `text`) VALUES (1,'lol')

DELIMITER //
CREATE OR REPLACE TRIGGER del_disc
AFTER DELETE ON discussion
FOR EACH ROW
BEGIN
    UPDATE user SET `number_disc` = `number_disc` - 1
    WHERE OLD.id_user = user.id_user;
END;//

DELIMITER //
CREATE OR REPLACE FUNCTION is_exist_email(email_test VARCHAR(30)) RETURN BOOLEAN
BEGIN
    DECLARE email_inter INT;
    SELECT COUNT(email) INTO email_inter FROM user
    WHERE email_test = user.email;
    IF email_inter > 0 THEN
        RETURN TRUE;
    END IF;
    RETURN FALSE;
END; //
