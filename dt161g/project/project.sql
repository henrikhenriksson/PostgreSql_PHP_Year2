-- ##############################################
-- KURS: DT161G
-- PHP Project
-- Johan Timrén
-- Create table called member
-- Create table called member_changelog
-- Create function and trigger for member change
-- ##############################################
-- ##############################################
-- First we create the schema if it not exists
-- ##############################################
CREATE SCHEMA IF NOT EXISTS dt161G;
-- ##############################################
-- First we create the member table
-- ##############################################
DROP TABLE IF EXISTS dt161g.member CASCADE;
CREATE TABLE dt161g.member (
  id SERIAL PRIMARY KEY,
  username text NOT NULL CHECK (username <> ''),
  password text NOT NULL CHECK (password <> ''),
  CONSTRAINT unique_user UNIQUE(username)
) WITHOUT OIDS;
-- ##############################################
-- Now we insert some values
-- ##############################################
INSERT INTO dt161g.member (username, password)
VALUES
  ('m', 'm');
INSERT INTO dt161g.member (username, password)
VALUES
  ('a', 'a');
-- ##############################################
  -- Then we create the role table
  -- ##############################################
  DROP TABLE IF EXISTS dt161g.role CASCADE;
CREATE TABLE dt161g.role (
    id SERIAL PRIMARY KEY,
    role text NOT NULL CHECK (role <> ''),
    roletext text NOT NULL CHECK (roletext <> ''),
    CONSTRAINT unique_role UNIQUE(role)
  ) WITHOUT OIDS;
-- ##############################################
  -- Now we insert some values
  -- ##############################################
INSERT INTO dt161g.role (role, roletext)
VALUES
  ('member', 'Meddlem i föreningen');
INSERT INTO dt161g.role (role, roletext)
VALUES
  ('admin', 'Administratör i föreningen');
-- ##############################################
  -- Then we create the role table
  -- ##############################################
  DROP TABLE IF EXISTS dt161g.member_role;
CREATE TABLE dt161g.member_role (
    id SERIAL PRIMARY KEY,
    member_id integer REFERENCES dt161g.member (id),
    role_id integer REFERENCES dt161g.role (id),
    CONSTRAINT unique_member_role UNIQUE(member_id, role_id)
  ) WITHOUT OIDS;
-- ##############################################
  -- Now we insert some values
  -- ##############################################
INSERT INTO dt161g.member_role (member_id, role_id)
VALUES
  (1, 1);
INSERT INTO dt161g.member_role (member_id, role_id)
VALUES
  (2, 1);
INSERT INTO dt161g.member_role (member_id, role_id)
VALUES
  (2, 2);
-- ##############################################
  -- Things that follows are not part of the laboration
  -- but are put here to illustrate the power of stored procedures that
  -- PostgreSQL support. Stored procedures can be write in
  -- many different languages like PL/SQL, Python, PERL, JAVA, C etc...
  -- Feel free to test and update a password in member and see the result in member_changelog
  -- First we create a change log table for our member table
  -- ##############################################
  DROP TABLE IF EXISTS dt161g.member_changelog;
CREATE TABLE dt161g.member_changelog (
    id SERIAL PRIMARY KEY,
    member_id integer REFERENCES dt161g.member (id),
    username text,
    password text,
    time_change timestamp without time zone DEFAULT now()
  ) WITHOUT OIDS;
-- ##############################################
  -- Then we create a trigger function to use for logging of all changes
  -- made when updateing member tabel
  -- ##############################################
  -- First we have to create the language we are going to write our function.
  CREATE EXTENSION IF NOT EXISTS plpgsql;
-- When we have created required language we can create our function
  DROP FUNCTION IF EXISTS dt161g.save_member_change();
CREATE
  OR REPLACE FUNCTION dt161g.save_member_change() RETURNS trigger AS $BODY$ DECLARE BEGIN IF OLD.username != NEW.username
  OR OLD.password != NEW.password THEN
INSERT INTO dt161g.member_changelog (member_id, username, password)
VALUES
  (OLD.id, OLD.username, OLD.password);
END IF;
RETURN NEW;
END;
$BODY$ LANGUAGE 'plpgsql' VOLATILE;
-- ##############################################
-- Create TRIGGER
-- Now we create trigger so we use our function to log changes in member
-- ##############################################
DROP TRIGGER IF EXISTS member_change ON dt161g.member CASCADE;
CREATE TRIGGER member_change
AFTER
UPDATE ON dt161g.member FOR EACH ROW EXECUTE PROCEDURE dt161g.save_member_change();