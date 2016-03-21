SET search_path = "Test";
-- 
-- CREATE TABLE MOVIES
-- (MOVIE_ID SERIAL PRIMARY KEY,
-- MOVIE_TITLE VARCHAR(20),
-- RELEASE_DATE VARCHAR(20),
-- DESCRIPTION VARCHAR(300), 
-- TG_RATING VARCHAR(7));
-- 
-- CREATE TABLE RAKEUSER
-- (USER_ID SERIAL PRIMARY KEY,
-- USER_NAME VARCHAR(35),
-- EMAIL TEXT,
-- PASSWORD TEXT, 
-- GENDER CHAR(1),
-- AGE INTEGER,
-- COUNTRY TEXT,
-- PICTURE BYTEA);

-- CREATE TABLE GENRE
-- (GENRE_ID SERIAL PRIMARY KEY,
-- GENRE VARCHAR(20));

-- CREATE TABLE DIRECTOR
-- (DIR_ID SERIAL PRIMARY KEY,
-- DIR_NAME TEXT,
-- DIR_COUNTRY TEXT);

-- CREATE TABLE ACTOR
-- (ACTOR_ID SERIAL PRIMARY KEY,
-- ACTOR_NAME TEXT,
-- ACTOR_DOB DATE);

-- CREATE TABLE STUDIO
-- (STUDIO_ID SERIAL PRIMARY KEY,
-- STUDIO_NAME TEXT,
-- STUDIO_COUNTRY TEXT);

-- ***************STUDIO INSERT**************
INSERT INTO STUDIO (STUDIO_NAME, STUDIO_COUNTRY)
VALUES
('Pixar', 'USA')

-- ***************ACTOR INSERT***************
-- INSERT INTO ACTOR (ACTOR_NAME, ACTOR_DOB)
-- VALUES
-- ('Brad Pitt', 'March 3 1970')
-- *****************************************

-- ***************DIRECTOR INSERT************
-- INSERT INTO DIRECTOR (DIR_NAME, DIR_COUNTRY)
-- VALUES
-- ('Frank Darabont', 'USA')
-- 
-- *****************************************

-- ***************GENRE INSERTS**************
-- INSERT INTO GENRE (GENRE)
-- VALUES
-- ('Action');
-- ******************************************

-- **************MOVIE INSERTS***************

-- INSERT INTO MOVIES (MOVIE_TITLE, RELEASE_DATE, DESCRIPTION, TG_RATING)
-- VALUES 
-- ('Cloud Atlas', 'October 26, 2012', 'Adam Ewing, an American lawyer, has come to the Chatham Islands to conclude a business arrangement with Reverend Horrox and his father-in-law.',
-- 'Rated R');
-- 
-- INSERT INTO MOVIES (MOVIE_TITLE, RELEASE_DATE, DESCRIPTION, TG_RATING)
-- VALUES 
-- ('DeadPool', 'February 12, 2016', 'This is the origin story of former Special Forces operative turned mercenary Wade Wilson, who after being subjected to a rogue experiment that leaves him with accelerated healing powers, adopts the alter ego Deadpool. Armed with his new abilities and a dark, twisted sense of humor, Deadpool hunts down the man who nearly destroyed his life.',
-- 'Rated R');

-- SELECT * FROM MOVIES;

-- INSERT INTO MOVIES (MOVIE_TITLE, RELEASE_DATE, DESCRIPTION, TG_RATING)
-- VALUES 
-- ('Avengers', 'May 4, 2012', 'The Asgardian Loki encounters the Other, the leader of an extraterrestrial race known as the Chitauri. In exchange for retrieving the Tesseract,2 a powerful energy source of unknown potential, the Other promises Loki an army with which he can subjugate Earth. Nick Fury, director of the espionage agency S.H.I.E.L.D., and his lieutenant Agent Maria Hill arrive at a remote research facility during an evacuation, where physicist Dr. Erik Selvig is leading a research team experimenting on the Tesseract. Agent Phil Coulson explains that the object has begun radiating an unusual form of energy. The Tesseract suddenly activates and opens a wormhole, allowing Loki to reach Earth. Loki takes the Tesseract and uses his scepter to enslave Selvig and a couple of agents, including Clint Barton, to aid him in his getaway.',
-- 'PG-13');

-- ALTER TABLE MOVIES
-- 	ALTER COLUMN DESCRIPTION TYPE TEXT;

-- ********************************************

