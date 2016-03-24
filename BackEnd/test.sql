SET search_path = "Test";
-- 
-- DROP TABLE DIRECTOR;
-- DROP TABLE GENRE;
-- DROP TABLE MOVIES;
-- DROP TABLE PROFILE;
-- DROP TABLE RAKEUSER;
-- DROP TABLE REVIEW;
-- DROP TABLE STUDIO;
-- DROP TABLE ACTOR;
-- DROP TABLE MOVREV;


-- CREATE TABLE MOVIES
-- (MOVIE_ID SERIAL PRIMARY KEY,
-- MOVIE_TITLE VARCHAR(20),
-- MOVIE_RELEASE_DATE VARCHAR(20),
-- MOVIE_DESCRIPTION VARCHAR(300), 
-- MOVIE_DURATION INTEGER,
-- MOVIE_TG_RATING VARCHAR(7),
-- CONSTRAINT C_MID UNIQUE (MOVIE_ID));
-- 
-- CREATE TABLE RAKEUSER
-- (USER_ID SERIAL PRIMARY KEY,
-- USER_NAME VARCHAR(35) NOT NULL,
-- USER_EMAIL TEXT NOT NULL,
-- USER_PASSWORD TEXT NOT NULL, 
-- USER_GENDER CHAR(1),
-- USER_AGE INTEGER,
-- USER_PICTURE BYTEA
-- CONSTRAINT C_ID_EMAIL UNIQUE (USER_ID, USER_EMAIL));
-- 
-- CREATE TABLE GENRE
-- (GENRE_ID SERIAL PRIMARY KEY,
-- GENRE_NAME VARCHAR(20));
-- 
-- CREATE TABLE DIRECTOR
-- (DIR_ID SERIAL PRIMARY KEY,
-- DIR_NAME TEXT,
-- DIR_COUNTRY TEXT);
-- 
-- CREATE TABLE ACTOR
-- (ACTOR_ID SERIAL PRIMARY KEY,
-- ACTOR_NAME TEXT);
-- 
-- CREATE TABLE STUDIO
-- (STUDIO_ID SERIAL PRIMARY KEY,
-- STUDIO_NAME TEXT,
-- STUDIO_COUNTRY TEXT);
-- 
-- CREATE TABLE PROFILE 
-- (PROFILE_ID SERIAL PRIMARY KEY,
-- FOREIGN KEY (USER_ID) REFERENCES RAKEUSER(USER_ID),
-- PROFILE_PROVINCE TEXT,
-- PROFILE_CITY TEXT,
-- PROFILE_OCCUPATION VARCHAR(30),
-- PROFILE_COUNTRY TEXT);
-- 
-- CREATE TABLE REVIEW
-- (REVIEW_ID SERIAL PRIMARY KEY,
-- REVIEW_DESCRIPTION TEXT,
-- REVIEW_RATING INTEGER,
-- REVIEW_DATE DATE,
-- CONSTRAINT REVIEW_RATING_C CHECK (REVIEW_RATING >= 0 AND REVIEW_RATING <= 5 ));

-- CREATE TABLE MOVREV
-- (FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- FOREIGN KEY (REVIEW_ID) REFERENCES REVIEW(REVIEW_ID));


	
--------------INITIAL TABLE INSERTS--------------------------------------------------------------------------------------------------------

-- ***************REVIEW*********************************************************************************
-- INSERT INTO REVIEW (REVIEW_DESCRIPTION, REVIEW_RATING, REVIEW_DATE)
-- VALUES
-- ('blablabla', 5, 'March 23 2016')
-- ******************************************************************************************************

-- ***************MOVREV*********************************************************************************
-- INSERT INTO MOVREV (MOVIE_ID, REVIEW_ID)
-- VALUES
-- (1, 1)
-- ******************************************************************************************************

-- ***************USER***********************************************************************************
-- INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_AGE, USER_PICTURE)
-- VALUES
-- ('K.Huang', 'KH@gmail.com', '1234', 'M', '22', '')
-- ******************************************************************************************************

-- *****************PROFILE******************************************************************************
-- INSERT INTO PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY)
-- VALUES
-- (1, 'ON', 'Ottawa', 'Student', 'Canada')
-- ******************************************************************************************************

-- ***************STUDIO*********************************************************************************
-- INSERT INTO STUDIO (STUDIO_NAME, STUDIO_COUNTRY)
-- VALUES
-- ('Pixar', 'USA')
-- ******************************************************************************************************

-- ***************ACTOR**********************************************************************************
-- INSERT INTO ACTOR (ACTOR_NAME)
-- VALUES
-- ('Brad Pitt')
-- ******************************************************************************************************

-- ***************DIRECTOR*******************************************************************************
-- INSERT INTO DIRECTOR (DIR_NAME, DIR_COUNTRY)
-- VALUES
-- ('Frank Darabont', 'USA')
-- ******************************************************************************************************

-- ***************GENRE**********************************************************************************
-- INSERT INTO GENRE (GENRE_NAME)
-- VALUES
-- ('Action');
-- ******************************************************************************************************

-- **************MOVIE **********************************************************************************************************
-- INSERT INTO MOVIES (MOVIE_TITLE, MOVIE_RELEASE_DATE, MOVIE_DESCRIPTION, MOVIE_TG_RATING, MOVIE_DURATION)
-- VALUES 
-- ('Cloud Atlas', 'October 26, 2012', 'Adam Ewing, an American lawyer, has come to the Chatham Islands to conclude a business arrangement with Reverend Horrox and his father-in-law.',
-- 'Rated R', 120);
-- ******************************************************************************************************************************

-------------END INITIAL TABLE INSERTS--------------------------------------------------------------------------------------------------


--------------------QUERIES-------------------------------------------------------------------------------------------------------------

-- *********************LOGIN************************************************************
-- SELECT * 
-- FROM RAKEUSER U
-- WHERE U.EMAIL = '$email' AND 
	  -- U.PASSWORD = '$password';
-- ***************************************************************************************

-- *******************PROFILE*************************************************************
-- SELECT * 
-- FROM PROFILE P, RAKEUSER U
-- WHERE U.USER_ID = '$user_id' AND 
	  -- U.USER_ID = P.USER_ID;
-- ***************************************************************************************

-- *******************SIGN UP***********************************************************************
-- INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_AGE, USER_PICTURE)
-- VALUES 
-- ('$name', '$email', '$password', '$gender', '$age', '$picture')

-- INSERT INTO PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY)
-- VALUES 
-- ($id, '$province', '$country', '$occupation', '$country')
-- **************************************************************************************************

-- ******************HOMEPAGE************************************************************************
-- SELECT M.MOVIE_TITLE, M.MOVIE_RELEASE_DATE, M.MOVIE_DESCRIPTION, M.MOVIE_TG_RATING, M.MOVIE_DURATION 
-- FROM MOVIES M, REVIEWS R, MOVREV MR
-- WHERE M.MOVIE_ID = ;

-- top rated movies
-- 4x random genres/actors + highest rating movie. total 4.

-- SELECT M.MOVIE_TITLE, M.MOVIE_RELEASE_DATE, M.MOVIE_DESCRIPTION, M.MOVIE_TG_RATING, M.MOVIE_DURATION
-- FROM MOVIES M, GENRE G, ACTOR A, DIRECTOR D,
-- -- WHERE 
-- **************************************************************************************************



-------------------END OF QUERIES---------------------------------------------------------------------------------------------------------



