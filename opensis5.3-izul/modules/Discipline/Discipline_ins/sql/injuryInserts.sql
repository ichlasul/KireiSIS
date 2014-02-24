INSERT INTO DISCIPLINE_INJURY_LKUP
( injury_code,
  injury_id,
  injury_description,
  injury_display
)
values
('10', 1,
'At least one participant received a minor physical injury as a result of the incident. A minor injury is one that does not require professional medical attention such as a scrape on the body, knee or elbow; and/or minor bruising. Medical attention from the school nurse qualifies the injury as minor unless further medical attention is required.', 
'Minor injury');

INSERT INTO DISCIPLINE_INJURY_LKUP
( injury_code,
  injury_id,
  injury_description,
  injury_display
)
values
('20', 2,
'At least one participant received a major physical injury as a result of the incident. A major injury is one that requires professional medical attention which may include, but is not limited to, a bullet wound, a stab or puncture wound, fractured or broken bones, concussions, cuts requiring stitches, and any other injury with profuse or excessive bleeding.', 
'Major injury');

INSERT INTO DISCIPLINE_INJURY_LKUP
( injury_code,
  injury_id,
  injury_description,
  injury_display
)
values
('96', 3,
'No one was physically injured during the course of the incident.', 
'No injury');
