
CREATE TABLE IF NOT EXISTS DISCIPLINE_RECORD (
  record_identifier VARCHAR(30) NOT NULL,
  record_date DATE,
  incident_id integer,
  location_id integer,
  school_id integer,
  time_id integer,
  facilities_id integer,
  injury_id integer,
  weapon_id integer,
  reporter_id integer,
  related_alcohol integer,
  related_drug integer,
  related_hate integer,
  related_weapon integer,
  related_gang integer,
  related_bully integer,
  reported_law integer,
  cost DECIMAL,
  open_closed integer DEFAULT 1
);


CREATE TABLE IF NOT EXISTS DISCIPLINE_LOCATION_LKUP (
  location_code VARCHAR(10) NOT NULL,
  location_id integer NOT NULL,
  location_display VARCHAR(255),
  location_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_REPORTER_LKUP (
  reporter_code VARCHAR(10) NOT NULL,
  reporter_id integer NOT NULL,
  reporter_display VARCHAR(255),
  reporter_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_TIME_LKUP (
  time_code VARCHAR(10) NOT NULL,
  time_id integer NOT NULL,
  time_display VARCHAR(255),
  time_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_INCIDENT_LKUP (
  incident_code VARCHAR(10) NOT NULL,
  incident_id integer NOT NULL,
  incident_display VARCHAR(255),
  incident_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_SCHOOL_LKUP (
  school_code VARCHAR(10) NOT NULL,
  school_id integer NOT NULL,
  School_description VARCHAR(255) NOT NULL,
  District_code VARCHAR(10) NOT NULL,
  State_code VARCHAR(10) NOT NULL,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_WEAPON_LKUP (
  weapon_code VARCHAR(10) NOT NULL,
  weapon_id integer NOT NULL,
  weapon_display VARCHAR(255) NOT NULL,
  weapon_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_INJURY_LKUP (
  injury_code VARCHAR(10) NOT NULL,
  injury_id integer NOT NULL,
  injury_display VARCHAR(255) NOT NULL,
  injury_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_FACILITIES_LKUP (
  facilities_code VARCHAR(10) NOT NULL,
  facilities_id integer NOT NULL,
  facilities_display VARCHAR(255) NOT NULL,
  facilities_description TEXT,
  hidden integer NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_DISCIPLINE_LKUP (
  discipline_id NUMERIC NOT NULL,
  discipline_code VARCHAR(10),
  discipline_display VARCHAR(255),
  discipline_description TEXT,
  hidden integer DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE (
  discipline_id integer,
  incident_identifier VARCHAR(30),
  perpetrator_id integer,
  discipline_id_type integer,
  start_date DATE,
  end_date DATE,
  related_special_ed integer,
  related_zero_policy integer,
  full_year_expulsion integer,
  short_expulsion integer,
  hidden integer DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_PERPETRATOR (
  perpetrator_id NUMERIC NOT NULL,
  incident_identifier VARCHAR(30),
  perpetrator_name VARCHAR(255),
  perpetrator_user_id integer,
  perpetrator_type_id integer,
  injury_id integer,
  hidden integer DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_PERPETRATOR_LKUP (
  perpetrator_id NUMERIC NOT NULL,
  perpetrator_code VARCHAR(10),
  perpetrator_display VARCHAR(255),
  perpetrator_description TEXT,
  hidden integer DEFAULT 0
);

CREATE TABLE IF NOT EXISTS discipline_victim (
  victim_id NUMERIC NOT NULL,
  incident_identifier VARCHAR(30),
  victim_name VARCHAR(255),
  victim_type_id integer,
  injury_id integer,
  hidden integer DEFAULT 0
);

CREATE TABLE IF NOT EXISTS DISCIPLINE_VICTIM_LKUP (
  victim_id NUMERIC NOT NULL,
  victim_code VARCHAR(10),
  victim_display VARCHAR(255),
  victim_description text,
  hidden integer DEFAULT 0
);

INSERT INTO DISCIPLINE_FACILITIES_LKUP (
  facilities_code,
  facilities_id,
  facilities_description,
  facilities_display
)
VALUES
('999', 1, 'N/A', 'N/A');

INSERT INTO DISCIPLINE_SCHOOL_LKUP (
  school_code,
  school_id,
  School_description,
  District_code,
  State_code
)
VALUES
('999', 1, 'N/A', '999','999');


DELETE FROM PROFILE_EXCEPTIONS where modname='Discipline/codeEditor.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Discipline/dashboard.php';
DELETE FROM PROFILE_EXCEPTIONS where modname='Discipline/incidenteditor.php';

INSERT INTO `PROFILE_EXCEPTIONS` (`profile_id`, `modname`, `can_use`, `can_edit`) VALUES
(1, 'Discipline/codeEditor.php', 'Y', 'Y'),
(1, 'Discipline/dashboard.php', 'Y', 'Y'),
(1, 'Discipline/incidenteditor.php', 'Y', 'Y');
