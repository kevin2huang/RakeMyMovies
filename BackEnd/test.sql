SET search_path = "Test";
-- 
-- CREATE TABLE MOVIES
-- (MOVIE_ID SERIAL PRIMARY KEY,
-- MOVIE_TITLE VARCHAR(20),
-- RELEASE_DATE VARCHAR(20),
-- DESCRIPTION VARCHAR(300), 
-- TG_RATING VARCHAR(7));
-- 
-- INSERT INTO MOVIES (MOVIE_TITLE, RELEASE_DATE, DESCRIPTION, TG_RATING)
-- VALUES 
-- ('Cloud Atlas', 'October 26, 2012', 'Adam Ewing, an American lawyer, has come to the Chatham Islands to conclude a business arrangement with Reverend Horrox and his father-in-law.',
-- 'Rated R');
-- 
-- INSERT INTO MOVIES (MOVIE_TITLE, RELEASE_DATE, DESCRIPTION, TG_RATING)
-- VALUES 
-- ('DeadPool', 'February 12, 2016', 'This is the origin story of former Special Forces operative turned mercenary Wade Wilson, who after being subjected to a rogue experiment that leaves him with accelerated healing powers, adopts the alter ego Deadpool. Armed with his new abilities and a dark, twisted sense of humor, Deadpool hunts down the man who nearly destroyed his life.',
-- 'Rated R');

SELECT * FROM MOVIES;

-- ALTER TABLE MOVIES
-- 	ALTER COLUMN DESCRIPTION TYPE TEXT;