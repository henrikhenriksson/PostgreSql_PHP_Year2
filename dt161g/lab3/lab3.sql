-- ##############################################
-- KURS: DT161G
-- Laboration 3
-- Henrik Henriksson (hehe0601)
-- Create one schema called dt161g
-- Create on table called guestbook
-- ##############################################


-- ##############################################
-- First we create the schema
-- ##############################################

DROP SCHEMA IF EXISTS dt161g CASCADE;

CREATE SCHEMA dt161g;

-- ##############################################
-- Then we create the table
-- ##############################################

DROP TABLE IF EXISTS dt161g.guestbook;

CREATE TABLE dt161g.guestbook (
  id        SERIAL PRIMARY KEY,
  name      text      NOT NULL CHECK (name <> ''),
  message   text      NOT NULL CHECK (message  <> ''),
  iplog     inet      NOT NULL CHECK (iplog <> inet '0.0.0.0'),
  timelog   timestamp DEFAULT now()
)
WITHOUT OIDS;

-- ##############################################
-- Last we insert some values
-- ##############################################

INSERT INTO dt161g.guestbook (name, message, iplog, timelog) VALUES ('test','testing','192.168.1.1', '2018-02-02 12:21:21');


