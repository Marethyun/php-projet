CREATE TABLE user
(
    id_user INT(10) AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(12) NOT NULL,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(16) NOT NULL,
    number_disc int(10)
);

CREATE TABLE discussion
(
    id_disc INT(10) AUTO_INCREMENT PRIMARY KEY,
    id_user INT(10) NOT NULL,
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
    FOREIGN KEY (id_disc) REFERENCES discussion(id_disc)
);

-- DELIMITER //
-- CREATE TRIGGER insert_upd_email_user
-- BEFORE INSERT OR UPDATE ON user
-- FOR EACH ROW
-- BEGIN
--     DECLARE email_inter VARCHAR(30);
--     DECLARE email_find CONDITION FOR -1001;
--     DECLARE EXIT HANDLER FOR email_find SET @error = 'L\'email inserer ou
--     modifier existe déjà dans la base de donnée';
--     SELECT email INTO email_inter FROM user
--     WHERE NEW.email = user.email;
--     IF email_inter IS NOT NULL THEN
--         SIGNAL email_find;
--     END IF;
-- END;//

-- DELIMITER //
-- CREATE TRIGGER insert_upd_email_user
-- BEFORE INSERT ON user
-- FOR EACH ROW
-- BEGIN
--     DECLARE email_inter VARCHAR(30);
--     DECLARE done INT DEFAULT FALSE;
--     DECLARE cur CURSOR FOR SELECT email FROM user
--     WHERE NEW.email LIKE user.email;
--     DECLARE EXIT HANDLER FOR SQLSTATE '20001' SET @error = "L\'email inserer ou
--     modifier existe déjà dans la base de donnée";
--     DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
--     open cur;
--     read_loop: LOOP
--     	FETCH cur INTO email_inter;
--         IF done THEN
--             LEAVE read_loop;
--         END IF;
--     END LOOP;
--     SIGNAL SQLSTATE;
-- END;//

DELIMITER //
CREATE OR REPLACE TRIGGER inter_psw
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    IF OLD.password != NEW.password THEN RESIGNAL SQLSTATE '45000';
    END IF;
END;//

-- UPDATE `user` SET `password` = 'max99' WHERE `id_user` = 1

DELIMITER //
CREATE OR REPLACE FUNCTION is_exist_email(email_test VARCHAR(30)) RETURN BOOLEAN READS SQL DATA
BEGIN
    DECLARE email_inter VARCHAR(30);
    SELECT email INTO email_inter FROM user
    WHERE email_test = user.email;
    IF email_inter IS NULL THEN
        RETURN TRUE;
    END IF;
    RETURN FALSE;
END; //
