SET search_path = "RakeMyMovie";
-- 
-- DROP TABLE ACTOR;
-- DROP TABLE DIRECTOR;
-- DROP TABLE GENRE;
-- DROP TABLE PROFILE;
-- DROP TABLE RAKEUSER CASCADE;
-- DROP TABLE REVIEW CASCADE;
-- DROP TABLE STUDIO CASCADE;
-- DROP TABLE MOVIES CASCADE; 
-- DROP TABLE MOVREV;
-- DROP TABLE MOVACT;
-- DROP TABLE WISH

-- CREATE TABLE MOVIES
-- (MOVIE_ID SERIAL PRIMARY KEY,
-- MOVIE_TITLE TEXT,
-- MOVIE_COVER TEXT,
-- MOVIE_RELEASE_DATE VARCHAR(20),
-- MOVIE_DESCRIPTION TEXT, 
-- MOVIE_DURATION INTEGER,
-- MOVIE_LANGUAGE VARCHAR(20),
-- MOVIE_COUNTRY TEXT,
-- MOVIE_TG_RATING VARCHAR(20),
-- UNIQUE(MOVIE_TITLE));
-- 
-- CREATE TABLE RAKEUSER
-- (USER_ID SERIAL PRIMARY KEY,
-- USER_NAME VARCHAR(35) NOT NULL,
-- USER_EMAIL TEXT NOT NULL,
-- USER_PASSWORD TEXT NOT NULL, 
-- USER_GENDER CHAR(1),
-- USER_DOB DATE,
-- USER_ICON TEXT,
-- USER_ISADMIN BOOLEAN DEFAULT FALSE,
-- UNIQUE(USER_EMAIL));

-- CREATE TABLE GENRE
-- (GENRE_ID SERIAL PRIMARY KEY,
-- GENRE_NAME VARCHAR(20),
-- UNIQUE(GENRE_NAME));
-- 
-- CREATE TABLE DIRECTOR
-- (DIR_ID SERIAL PRIMARY KEY,
-- DIR_NAME TEXT,
-- UNIQUE(DIR_NAME));
-- 
-- CREATE TABLE ACTOR
-- (ACTOR_ID SERIAL PRIMARY KEY,
-- ACTOR_NAME TEXT,
-- UNIQUE(ACTOR_NAME));
-- 
-- CREATE TABLE STUDIO
-- (STUDIO_ID SERIAL PRIMARY KEY,
-- STUDIO_NAME TEXT);
-- 
-- CREATE TABLE PROFILE 
-- (PROFILE_ID SERIAL PRIMARY KEY,
-- USER_ID INTEGER,
-- FOREIGN KEY (USER_ID) REFERENCES RAKEUSER(USER_ID),
-- PROFILE_PROVINCE TEXT,
-- PROFILE_CITY TEXT,
-- PROFILE_OCCUPATION VARCHAR(30),
-- PROFILE_COUNTRY TEXT,
-- PROFILE_QUOTE VARCHAR(100),
-- UNIQUE(USER_ID));
-- 
-- CREATE TABLE REVIEW
-- (REVIEW_ID SERIAL PRIMARY KEY,
-- REVIEW_DESCRIPTION VARCHAR(500),
-- REVIEW_RATING INTEGER DEFAULT 0,
-- REVIEW_DATE DATE,
-- CONSTRAINT REVIEW_RATING_C CHECK (REVIEW_RATING >= 0 AND REVIEW_RATING <= 5 ));

-- CREATE TABLE MOVREV
-- (MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- REVIEW_ID INTEGER,
-- FOREIGN KEY (REVIEW_ID) REFERENCES REVIEW(REVIEW_ID));
-- 
-- CREATE TABLE WISH 
-- (USER_ID INTEGER,
-- FOREIGN KEY (USER_ID) REFERENCES RAKEUSER(USER_ID),
-- MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- WISH_TIMESTAMP DATE);
-- 
-- CREATE TABLE USRREV
-- (USER_ID INTEGER,
-- FOREIGN KEY (USER_ID) REFERENCES RAKEUSER(USER_ID),
-- REVIEW_ID INTEGER,
-- FOREIGN KEY (REVIEW_ID) REFERENCES REVIEW(REVIEW_ID));
-- 
-- CREATE TABLE USRACT
-- (USER_ID INTEGER,
-- FOREIGN KEY (USER_ID) REFERENCES RAKEUSER(USER_ID),
-- ACTOR_ID INTEGER,
-- FOREIGN KEY (ACTOR_ID) REFERENCES ACTOR(ACTOR_ID));
-- 
-- CREATE TABLE MOVGEN
-- (MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- GENRE_ID INTEGER,
-- FOREIGN KEY (GENRE_ID) REFERENCES GENRE(GENRE_ID));
-- 	
-- CREATE TABLE MOVACT
-- (MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- ACTOR_ID INTEGER,
-- FOREIGN KEY (ACTOR_ID) REFERENCES ACTOR(ACTOR_ID));
-- 	
-- CREATE TABLE SPONSOR
-- (MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- STUDIO_ID INTEGER,
-- FOREIGN KEY (STUDIO_ID) REFERENCES STUDIO(STUDIO_ID));
-- 
-- CREATE TABLE MOVDIR
-- (MOVIE_ID INTEGER,
-- FOREIGN KEY (MOVIE_ID) REFERENCES MOVIES(MOVIE_ID),
-- DIR_ID INTEGER,
-- FOREIGN KEY (DIR_ID) REFERENCES DIRECTOR(DIR_ID));

--------------INITIAL TABLE INSERTS--------------------------------------------------------------------------------------------------------

-- ***************REVIEW*********************************************************************************************
-- INSERT INTO REVIEW (REVIEW_DESCRIPTION, REVIEW_RATING, REVIEW_DATE)
-- VALUES
-- ('blablabla', 5, 'March 23 2016')
-- ******************************************************************************************************************

-- ***************USER***********************************************************************************************
-- INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_DOB, USER_ICON)
-- VALUES
-- ('Abigael', 'abigael.tremblay@gmail.com', '1234', '', '22 April 1990', 'folder/folder/filename')
-- ******************************************************************************************************************

-- *****************PROFILE******************************************************************************************
-- INSERT INTO PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY, PROFILE_QUOTE)
-- VALUES
-- (1, 'Ontario', 'Ottawa', 'Student', 'Canada', 'Today is such a nice day!')
-- ******************************************************************************************************************

-- ***************STUDIO*********************************************************************************************
-- INSERT INTO STUDIO (STUDIO_NAME)
-- VALUES
-- ('Pixar')
-- ******************************************************************************************************************

-- ***************ACTOR**********************************************************************************************
-- INSERT INTO ACTOR (ACTOR_NAME)
-- VALUES
-- ('Brad Pitt')
-- ******************************************************************************************************************

-- ***************DIRECTOR*******************************************************************************************
-- INSERT INTO DIRECTOR (DIR_NAME)
-- VALUES
-- ('Frank Darabont')
-- ******************************************************************************************************************

-- ***************GENRE**********************************************************************************************
-- INSERT INTO GENRE (GENRE_NAME)
-- VALUES
-- ('Action');
-- ******************************************************************************************************************

-- **************MOVIE **********************************************************************************************************************************-- 
-- INSERT INTO MOVIES (MOVIE_TITLE, MOVIE_COVER, MOVIE_RELEASE_DATE, MOVIE_DESCRIPTION, MOVIE_TG_RATING, MOVIE_DURATION, MOVIE_LANGUAGE, MOVIE_COUNTRY)
-- VALUES 
-- ('Cloud Atlas','www.imdb.com/.../...' ,'October 26, 2012', 'Adam Ewing, an American lawyer, has come to the Chatham Islands to conclude a business arrangement with Reverend Horrox and his father-in-law.',
-- 'Rated R', 120, 'English', 'USA');
-- 
-- INSERT INTO MOVIES VALUES('The Shawshank Redemption','http://ia.media-imdb.com/images/M/MV5BODU4MjU4NjIwNl5BMl5BanBnXkFtZTgwMDU2MjEyMDE@._V1_UX182_CR0,0,182,268_AL_.jpg','14 October 1994','Chronicles the experiences of a formerly successful banker as a prisoner in the gloomy jailhouse of Shawshank after being found guilty of a crime he claims he did not commit. The film portrays the man\'s unique way of dealing with his new, torturous life; along the way he befriends a number of fellow prisoners, most notably a wise long-term inmate named Red. ','R','142','English','USA')

-- INSERT INTO MOVIES VALUES('The Godfather','http://ia.media-imdb.com/images/M/MV5BMjEyMjcyNDI4MF5BMl5BanBnXkFtZTcwMDA5Mzg3OA@@._V1_UX182_CR0,0,182,268_AL_.jpg','24 March 1972','When the aging head of a famous crime family decides to transfer his position to one of his subalterns, a series of unfortunate events start happening to the family, and a war begins between all the well-known families leading to insolence, deportation, murder and revenge, and ends with the favorable successor being finally chosen. ','R','175','English','USA')

-- INSERT INTO MOVIES VALUES('The Godfather: Part II','http://ia.media-imdb.com/images/M/MV5BNDc2NTM3MzU1Nl5BMl5BanBnXkFtZTcwMTA5Mzg3OA@@._V1_UX182_CR0,0,182,268_AL_.jpg','20 December 1974','The continuing saga of the Corleone crime family tells the story of a young Vito Corleone growing up in Sicily and in 1910s New York; and follows Michael Corleone in the 1950s as he attempts to expand the family business into Las Vegas, Hollywood and Cuba. ','R','202','English','USA')

-- ******************************************************************************************************************************************************

-- ***************MOVREV*********************************************************************************************
-- INSERT INTO MOVREV (MOVIE_ID, REVIEW_ID)
-- VALUES
-- (1, 1)
-- ******************************************************************************************************************

-------------END INITIAL TABLE INSERTS--------------------------------------------------------------------------------------------------


--------------------QUERIES-------------------------------------------------------------------------------------------------------------

-- *********************LOGIN************************************************************************
-- SELECT * 
-- FROM RAKEUSER U
-- WHERE U.EMAIL = '$email' AND 
	  -- U.PASSWORD = '$password';

-- SELECT * 
-- FROM RAKEUSER U 
-- WHERE U.USER_EMAIL = 'abigael.tremblay@gmail.com' AND 
--       U.USER_PASSWORD = '1234';

-- ***************************************************************************************************

-- *******************PROFILE*************************************************************************
-- SELECT * 
-- FROM PROFILE P, RAKEUSER U
-- WHERE U.USER_ID = '$user_id' AND 
	  -- U.USER_ID = P.USER_ID;

-- SELECT * 
-- FROM PROFILE P 
-- WHERE (SELECT U.USER_ID 
-- 	FROM RAKEUSER U 
--         WHERE U.USER_EMAIL = 'abigael.tremblay@gmail.com' AND 
--         U.USER_PASSWORD = '1234') = P.USER_ID;

-- ***************************************************************************************************

-- *******************SIGN UP*************************************************************************

-- INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_AGE, USER_PICTURE)
-- VALUES 
-- ('$name', '$email', '$password', '$gender', '$age', '$picture')

-- INSERT INTO PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY)
-- VALUES 
-- ($id, '$province', '$country', '$occupation', '$country', '$quote')
-- ***************************************************************************************************

-- ******************HOMEPAGE***************************************************************************

-- SELECT * 
-- FROM MOVIES M  
-- WHERE M.MOVIE_ID = " + '$movieID' + ";"

-- SELECT * 
-- FROM ACTOR A
-- WHERE A.ACTOR_ID = (SELECT MA.ACTOR_ID 
		-- FROM MOVACT MA, MOVIES M
		-- WHERE M.MOVIE_ID = '$movieid' AND MA.MOVIE_ID = M.MOVIE_ID);

-- SELECT M.*, A.*, D.*, S.*
-- FROM MOVIES M, ACTOR A, MOVACT MA, DIRECTOR D, MOVDIR MD, STUDIO S, SPONSOR SP
-- WHERE M.MOVIE_ID = '1' AND
      -- A.ACTOR_ID = MA.ACTOR_ID AND
      -- MA.MOVIE_ID = M.MOVIE_ID AND
      -- D.DIRECTOR_ID = MD.DIRECTOR_ID AND 
      -- MD.MOVIE_ID = MOVIE_ID AND 
      -- SP.MOVIE_ID = M.MOVIE_ID AND 
      -- SP.STUDIO_ID = S.STUDIO_ID;
		
-- SELECT M.MOVIE_TITLE, M.MOVIE_RELEASE_DATE, M.MOVIE_DESCRIPTION, M.MOVIE_TG_RATING, M.MOVIE_DURATION 
-- FROM MOVIES M, REVIEWS R, MOVREV MR
-- WHERE MR.MOVIE_ID = M.MOVIE_ID AND 
	 -- 	MR.REVIEW_ID = R.REVIEW_ID AND 
			-- R. (SELECT MAX(AVG_RATING)
		-- 	FROM (SELECT MR.MOVIE_ID, AVG(R.RATING) AS AVG_RATING
				-- FROM MOVREV MR, REVIEW R
				-- GROUP BY MR.MOVIE_ID));

-- top rated movies
-- 4x random genres/actors + highest rating movie. total 4.

-- SELECT M.MOVIE_TITLE, M.MOVIE_RELEASE_DATE, M.MOVIE_DESCRIPTION, M.MOVIE_TG_RATING, M.MOVIE_DURATION
-- FROM MOVIES M, GENRE G, ACTOR A, DIRECTOR D,
-- -- WHERE 

SELECT M.*, A.*, D.*, S.*
FROM MOVIES M, ACTOR A, MOVACT MA, DIRECTOR D, MOVDIR MD, STUDIO S, SPONSOR SP
WHERE M.MOVIE_ID = 1 AND
      A.ACTOR_ID = MA.ACTOR_ID AND
      MA.MOVIE_ID = M.MOVIE_ID AND
      D.DIRECTOR_ID = MD.DIRECTOR_ID AND 
      MD.MOVIE_ID = M.MOVIE_ID AND 
      SP.MOVIE_ID = M.MOVIE_ID AND 
      SP.STUDIO_ID = S.STUDIO_ID;

-- ******************************************************************************************************

-- *****************ADD TO WISH LIST*********************************************************************

-- INSERT INTO WISH (USER_ID, MOVIE_ID, WISH_TIMESTAMP)
-- VALUES 
-- ('$user_id', '$movie_id', '$date')
-- ******************************************************************************************************

-- *****************OPEN PROFILE*************************************************************************

-- SELECT * 
-- FROM RAKEUSER U, PROFILE P
-- WHERE U.USER_ID = 1 AND 
	-- P.USER_ID = U.USER_ID;
-- ******************************************************************************************************

-- ********************SAVE PROFILE**********************************************************************

-- do this for each change
-- ALTER TABLE RAKEUSER 
	-- ALTER COLUMN USER_PASSWORD SET '$new_pass';
-- ******************************************************************************************************

-- *********************WISH LIST************************************************************************

-- SELECT M.MOVIE_TITLE, M.MOVIE_COVER, M.MOVIE_DURATION, WL.DATE
-- FROM MOVIES M, WISH WL, RAKEUSER U
-- WHERE U.USER_ID = '$id' AND 
		-- WL.USER_ID = U.USER_ID AND
		-- WL.MOVIE_ID = M.MOVIE_ID
-- ORDER BY WL.DATE DESC;
-- ********************************************************************************************************

-- ***********************DELETE MOVIE FROM WISH LIST******************************************************

-- DELETE FROM WISH 
	-- WHERE MOVIE_ID = '$movieid';
-- ********************************************************************************************************

-- ********************REVIEW LIST************************************************************************* 

-- SELECT R.REVIEW_DESCRIPTION, R.REVIEW_RATING, R.REVIEW_DATE 
-- FROM REVIEW R, RAKEUSER U
-- WHERE U.RAKEUSER = '$id';
-- ********************************************************************************************************

-- **********************WRITE A REVIEW********************************************************************

-- INSERT INTO TABLE REVIEW (REVIEW_DESCRIPTION, REVIEW_RATING, REVIEW_DATE)
-- VALUES ('$description','$rating','$date')

-- INSERT INTO USERREVIEW (USER_ID, REVIEW_ID)
-- VALUES ('$userid', '$reviewid')

-- INSERT INTO MOVREV (MOVIE_ID, REVIEW_ID)
-- VALUES ('$moveid', '$reviewid')
-- ********************************************************************************************************

-- ***********************GENRE LIST***********************************************************************

-- SELECT G.GENRE_NAME 
-- FROM GENRE G, USRGEN UG
-- WHERE UG.USER_ID = '$userid' AND 
		-- UG.GENRE_ID = G.GENRE_ID;
-- ********************************************************************************************************

-- ************************EDIT GENRE LIST*****************************************************************

-- INSERT INTO USRGEN (USER_ID, GENRE_ID)
-- VALUES ('$userid', '$genreid')

-- DELETE FROM USRGEN 
	-- WHERE USER_ID = '$userid' AND GENRE_ID = '$genreid';
-- ********************************************************************************************************
		
-------------------END OF QUERIES---------------------------------------------------------------------------------------------------------



