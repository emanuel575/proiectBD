
CREATE TABLE employees (
    emp_id       TINYINT NOT NULL,
    name         VARCHAR(255),
    phone        BIGINT,
    machine_id   TINYINT NOT NULL,
    owner_id     TINYINT NOT NULL
);

ALTER TABLE employees ADD CONSTRAINT employees_pk PRIMARY KEY ( emp_id );
ALTER TABLE employees ADD CONSTRAINT employees_chk_phone_length CHECK (CHAR_LENGTH(phone) = 10);


CREATE TABLE lands (
    land_id    TINYINT NOT NULL,
    area       DECIMAL(10000, 2),
    terrain_length     DECIMAL(100, 2),
    width      DECIMAL(100, 2),
    owner_id   TINYINT NOT NULL
);

ALTER TABLE lands ADD CONSTRAINT lands_pk PRIMARY KEY ( land_id );

CREATE TABLE machines (
    machine_id   TINYINT NOT NULL,
    status       VARCHAR(255),
    owner_id     TINYINT NOT NULL,
    name         VARCHAR(255),
    emp_id       TINYINT NOT NULL
);

ALTER TABLE machines ADD CONSTRAINT machines_pk PRIMARY KEY ( machine_id );
ALTER TABLE machines ADD CONSTRAINT chk_machines_status CHECK (status in ('SERVICE', 'WORKING', 'PAUSE'));

CREATE TABLE machines2emp (
    emp_id       TINYINT NOT NULL,
    machine_id   TINYINT NOT NULL
);

ALTER TABLE machines2emp ADD CONSTRAINT relation_9_pk PRIMARY KEY ( emp_id,
                                                                    machine_id );

CREATE TABLE users (
    user_id   TINYINT NOT NULL,
    email     VARCHAR(255),
    pass      VARCHAR(255)
);

ALTER TABLE users ADD CONSTRAINT users_pk PRIMARY KEY ( user_id );
ALTER TABLE users ADD CONSTRAINT users_chk_pass_length CHECK (CHAR_LENGTH(pass) >= 6 AND CHAR_LENGTH(pass) <= 64);

CREATE TABLE users_details (
    user_id      TINYINT NOT NULL,
    phone        BIGINT,
    first_name   VARCHAR(255),
    last_name    VARCHAR(255)
);

ALTER TABLE users_details ADD CONSTRAINT users_details_pk PRIMARY KEY ( user_id );
ALTER TABLE users_details ADD CONSTRAINT users_details_chk_phone_length CHECK (CHAR_LENGTH(phone) = 10);

ALTER TABLE employees
    ADD CONSTRAINT employees_users_fk FOREIGN KEY ( owner_id )
        REFERENCES users ( user_id );

ALTER TABLE lands
    ADD CONSTRAINT lands_users_fk FOREIGN KEY ( owner_id )
        REFERENCES users ( user_id );

ALTER TABLE machines
    ADD CONSTRAINT machines_users_fk FOREIGN KEY ( owner_id )
        REFERENCES users ( user_id );

ALTER TABLE machines2emp
    ADD CONSTRAINT relation_9_employees_fk FOREIGN KEY ( emp_id )
        REFERENCES employees ( emp_id );

ALTER TABLE machines2emp
    ADD CONSTRAINT relation_9_machines_fk FOREIGN KEY ( machine_id )
        REFERENCES machines ( machine_id );

ALTER TABLE users_details
    ADD CONSTRAINT users_details_users_fk FOREIGN KEY ( user_id )
        REFERENCES users ( user_id );

CALL CreateSequence('employees_emp_id_seq', 1, 1) ORDER;

CREATE OR REPLACE TRIGGER employees_emp_id_trg BEFORE
    INSERT ON employees
    FOR EACH ROW
    WHEN ( new.emp_id IS NULL )
BEGIN
    Set :new.emp_id = employees_emp_id_seq.nextval;
END;
/

CALL CreateSequence('lands_land_id_seq', 1, 1) ORDER;

CREATE OR REPLACE TRIGGER lands_land_id_trg BEFORE
    INSERT ON lands
    FOR EACH ROW
    WHEN ( new.land_id IS NULL )
BEGIN
    Set :new.land_id = lands_land_id_seq.nextval;
END;
/

CALL CreateSequence('machines_machine_id_seq', 1, 1) ORDER;

CREATE OR REPLACE TRIGGER machines_machine_id_trg BEFORE
    INSERT ON machines
    FOR EACH ROW
    WHEN ( new.machine_id IS NULL )
BEGIN
    Set :new.machine_id = machines_machine_id_seq.nextval;
END;
/

CALL CreateSequence('users_user_id_seq', 1, 1) ORDER;

CREATE OR REPLACE TRIGGER users_user_id_trg BEFORE
    INSERT ON users
    FOR EACH ROW
    WHEN ( new.user_id IS NULL )
BEGIN
    Set :new.user_id = users_user_id_seq.nextval;
END;
/
