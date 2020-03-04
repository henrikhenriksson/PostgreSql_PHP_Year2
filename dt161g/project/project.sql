-- ##############################################
-- KURS: DT161G
-- PHP Project
-- Henrik Henriksson (hehe0601)
-- hehe0601@student.miun.se
-- ##############################################
-- Create the Schema, if it doesn't exist:
CREATE SCHEMA IF NOT EXISTS dt161G_Project;
-- Create the member table, Username has a unique check.
DROP TABLE IF EXISTS dt161G_Project.member CASCADE;
CREATE TABLE dt161G_Project.member (
  id SERIAL PRIMARY KEY,
  username text NOT NULL CHECK (username <> ''),
  password text NOT NULL CHECK (password <> ''),
  CONSTRAINT unique_user UNIQUE(username)
) WITHOUT OIDS;
-- Insert standard values to the database.
INSERT INTO dt161G_Project.member (username, password)
VALUES
  ('m', 'm');
INSERT INTO dt161G_Project.member (username, password)
VALUES
  ('a', 'a');
-- Create the Role table
  DROP TABLE IF EXISTS dt161G_Project.role CASCADE;
CREATE TABLE dt161G_Project.role (
    id SERIAL PRIMARY KEY,
    role text NOT NULL CHECK (role <> ''),
    roletext text NOT NULL CHECK (roletext <> ''),
    CONSTRAINT unique_role UNIQUE(role)
  ) WITHOUT OIDS;
-- Insert initial values.
INSERT INTO dt161G_Project.role (role, roletext)
VALUES
  ('member', 'Meddlem i föreningen');
INSERT INTO dt161G_Project.role (role, roletext)
VALUES
  ('admin', 'Administratör i föreningen');
-- Create the member role table:
  DROP TABLE IF EXISTS dt161G_Project.member_role;
CREATE TABLE dt161G_Project.member_role (
    id SERIAL PRIMARY KEY,
    member_id integer REFERENCES dt161G_Project.member (id),
    role_id integer REFERENCES dt161G_Project.role (id),
    CONSTRAINT unique_member_role UNIQUE(member_id, role_id)
  ) WITHOUT OIDS;
-- Insert initial values to the table
INSERT INTO dt161G_Project.member_role (member_id, role_id)
VALUES
  (1, 1);
INSERT INTO dt161G_Project.member_role (member_id, role_id)
VALUES
  (2, 1);
INSERT INTO dt161G_Project.member_role (member_id, role_id)
VALUES
  (2, 2);
-- Create the Categories table.
  DROP TABLE IF EXISTS dt161G_Project.category CASCADE;
CREATE TABLE dt161G_Project.category (
    id SERIAL PRIMARY KEY,
    category_name text NOT NULL CHECK (category_name <> ''),
    member_id INTEGER REFERENCES dt161G_Project.member(id),
    CONSTRAINT unique_category_member UNIQUE(category_name, member_id)
  ) WITHOUT OIDS;
-- Create the Image table:
  DROP TABLE IF EXISTS dt161G_Project.images CASCADE;
CREATE TABLE dt161G_Project.images (
    id SERIAL PRIMARY KEY,
    img_name text NOT NULL CHECK (img_Name <> ''),
    category_id INTEGER references dt161G_Project.category(id),
    CONSTRAINT unique_img_category UNIQUE(img_name, category_id)
  ) WITHOUT OIDS;