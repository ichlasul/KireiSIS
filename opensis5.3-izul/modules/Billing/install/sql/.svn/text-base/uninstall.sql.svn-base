DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/fees.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/reports.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Billing/billingAdmin.php';

DROP TABLE if exists BILLING_PAYMENT_TYPE;
DROP TABLE if exists BILLING_FEE;
DROP TABLE if exists BILLING_PAYMENT;

DROP FUNCTION IF EXISTS fn_billing_payment_type_seq;
DROP FUNCTION IF EXISTS fn_billing_fee_seq;
DROP FUNCTION IF EXISTS fn_billing_payment_seq;
