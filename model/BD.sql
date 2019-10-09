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

DELIMITER //
CREATE TRIGGER insert_upd_email_user
BEFORE INSERT OR UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE email_inter VARCHAR(30);
    DECLARE email_find CONDITION FOR -1001;
    DECLARE EXIT HANDLER FOR email_find SET @error = 'L\'email inserer ou
    modifier existe déjà dans la base de donnée';
    SELECT email INTO email_inter FROM user
    WHERE NEW.email = user.email;
    IF email_inter IS NOT NULL THEN
        SIGNAL email_find;
    END IF;
END;//

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
CREATE TRIGGER inter_psw
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE psw_change CONDITION FOR -1002;
    DECLARE EXIT HANDLER FOR psw_change SET @error = 'Le mot de passe ne peut
    être changer';
    IF !(OLD.user.password <=> NEW.user.password) THEN SIGNAL psw_change;
    END IF;
END;//
