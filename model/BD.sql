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

CREATE TRIGGER insert_upd_email_user
BEFORE INSERT OR UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE EMAIL_INTER VARCHAR(30);
    DECLARE EMAIL_FIND CONDITION FOR -1001;
    DECLARE EXIT HANDLER FOR EMAIL_FIND SET @error = 'L\'email inserer ou
    modifier existe déjà dans la base de donnée';
    SELECT email INTO EMAIL_INTER FROM user
    WHERE :NEW.email = user.email;
    IF EMAIL_INTER IS NOT NULL THEN SIGNAL EMAIL_FIND;
    END IF;
END;

CREATE TRIGGER inter_psw
BEFORE UPDATE ON user
FOR EACH ROW
BEGIN
    DECLARE PSW_CHANGE CONDITION FOR -1002;
    DECLARE EXIT HANDLER FOR EMAIL_FIND SET @error = 'Le mot de passe ne peut
    être changer';
    IF !(:OLD.user.password <=> :NEW.user.password) THEN SIGNAL PSW_CHANGE;
    END IF;
END;
