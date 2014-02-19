CREATE TABLE BILLING_PAYMENT_TYPE (
  type_id NUMERIC NOT NULL,
  type_desc VARCHAR(255)
);

--
-- Structure for table: 'billing_payment_type_seq'
-- used for autoincrementing after porting from PostGres
-- Do not alter unless you know what you are doing
--
CREATE TABLE billing_payment_type_seq (
    id INTEGER NOT NULL AUTO_INCREMENT KEY
);
DROP FUNCTION IF EXISTS fn_billing_payment_type_seq;
DELIMITER $$
CREATE FUNCTION fn_billing_payment_type_seq () RETURNS INT
BEGIN
    INSERT INTO billing_payment_type_seq VALUES(NULL);
    DELETE FROM billing_payment_type_seq;
    RETURN LAST_INSERT_ID();
END$$
DELIMITER ;

CREATE TABLE BILLING_FEE (
  fee_id NUMERIC NOT NULL,
  student_id NUMERIC NOT NULL,
  amount NUMERIC NOT NULL,
  module VARCHAR(255) NOT NULL,
  inserted_by VARCHAR(255) NOT NULL,
  waived_date DATE,
  waived_by VARCHAR(255),
  title VARCHAR(255) NOT NULL,
  assigned_date DATE,
  inserted_date DATE,
  due_date DATE,
  comment VARCHAR(255) NOT NULL,
  waived integer DEFAULT 0
);

--
-- Structure for table: 'billing_fee_seq'
-- used for autoincrementing after porting from PostGres
-- Do not alter unless you know what you are doing
--
CREATE TABLE billing_fee_seq (
    id INTEGER NOT NULL AUTO_INCREMENT KEY
);

DROP FUNCTION IF EXISTS fn_billing_fee_seq;
DELIMITER $$
CREATE FUNCTION fn_billing_fee_seq () RETURNS INT
BEGIN
    INSERT INTO billing_fee_seq VALUES(NULL);
    DELETE FROM billing_fee_seq;
    RETURN LAST_INSERT_ID();
END$$
DELIMITER ;

CREATE TABLE BILLING_PAYMENT (
  payment_id NUMERIC NOT NULL,
  student_id NUMERIC NOT NULL,
  amount NUMERIC NOT NULL,
  payment_type VARCHAR(255) NOT NULL,
  comment VARCHAR(255) NOT NULL,
  payment_date DATE,
  refunded integer DEFAULT 0,
  refund_date DATE
);

--
-- Structure for table: 'billing_payment_seq'
-- used for autoincrementing after porting from PostGres
-- Do not alter unless you know what you are doing
--
CREATE TABLE billing_payment_seq (
    id INTEGER NOT NULL AUTO_INCREMENT KEY
);

DROP FUNCTION IF EXISTS fn_billing_payment_seq;
DELIMITER $$
CREATE FUNCTION fn_billing_payment_seq () RETURNS INT
BEGIN
    INSERT INTO billing_payment_seq VALUES(NULL);
    DELETE FROM billing_payment_seq;
    RETURN LAST_INSERT_ID();
END$$
DELIMITER ;


DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/fees.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/reports.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/billingAdmin.php';

INSERT INTO `PROFILE_EXCEPTIONS` (`profile_id`, `modname`, `can_use`, `can_edit`) VALUES
(0, 'Billing/reports.php', 'Y', NULL),
(1, 'Billing/fees.php', 'Y', 'Y'),
(1, 'Billing/reports.php', 'Y', 'Y'),
(1, 'Billing/billingAdmin.php', 'Y', 'Y');

INSERT INTO BILLING_PAYMENT_TYPE (type_id, type_desc) VALUES
(1, 'Cash'),
(2, 'Debit/Credit Card'),
(3, 'Scholarship');
