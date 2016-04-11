SET search_path = "RakeMyMovie";

--a
SELECT * 
FROM Movies
WHERE movie_title = '$movie_title';

--b
SELECT A.*, MA.ROLE
	FROM ACTOR A, MOVACT MA, MOVIES M
	WHERE M.MOVIE_TITLE = '$title' AND M.MOVIE_ID = MA.MOVIE_ID AND MA.ACTOR_ID = A.ACTOR_ID;

--c

SELECT DISTINCT D.DIR_NAME, S.STUDIO_NAME, M.MOVIE_RELEASE_DATE
	FROM DIRECTOR D, STUDIO S, MOVIES M, GENRE G, MOVGEN MG, MOVDIR MD, SPONSOR SP
	WHERE G.GENRE_NAME = 'Action' AND
		G.GENRE_ID = MG.GENRE_ID AND
		MG.MOVIE_ID = M.MOVIE_ID AND
		MG.MOVIE_ID = MD.DIR_ID AND
		MD.DIR_ID = D.DIR_ID AND
		MG.MOVIE_ID = SP.MOVIE_ID AND
		SP.STUDIO_ID = S.STUDIO_ID;

--d
SELECT A.*, D.*, S.*
FROM ACTOR A, DIRECTOR D, STUDIO S, MOVACT MA, MOVDIR MD, SPONSOR SP
WHERE A.ACTOR_ID = (SELECT A.ACTOR_ID
			FROM ACTOR A, MOVACT MA
			WHERE A.ACTOR_ID = MA.ACTOR_ID
			GROUP BY A.ACTOR_ID
			ORDER BY COUNT(A.ACTOR_ID) DESC
			LIMIT 1) AND
 	MA.ACTOR_ID = A.ACTOR_ID AND 
	MA.MOVIE_ID = MD.MOVIE_ID AND
	MD.DIR_ID = D.DIR_ID AND
	MA.MOVIE_ID = SP.MOVIE_ID AND
	SP.STUDIO_ID = S.STUDIO_ID;

--e
-- SELECT * FROM REVIEW
-- FROM ACTOR A1, ACTOR A2, Movie M, 
-- WHERE


--f
SELECT M.MOVIE_TITLE, AVG(R.REVIEW_RATING)
FROM REVIEW R, MOVREV MR, MOVIES M
WHERE R.REVIEW_ID = MR.REVIEW_ID AND
MR.MOVIE_ID = M.MOVIE_ID
GROUP BY M.MOVIE_TITLE
ORDER BY AVG(R.REVIEW_RATING) DESC
LIMIT 10;

--g
SELECT M.*, G.GENRE_NAME
FROM MOVIES M, REVIEW R, MOVREV MR, GENRE G, MOVGEN MG 
WHERE M.MOVIE_ID = MR.MOVIE_ID AND
	  R.REVIEW_ID = MR.REVIEW_ID AND
	  M.MOVIE_ID = MG.MOVIE_ID AND 
	  G.GENRE_ID = MG.GENRE_ID AND 
	  R.REVIEW_RATING = (SELECT AVG(R.REVIEW_RATING)
						 FROM REVIEW R, MOVIES M, MOVREV MR 
						 WHERE R.REVIEW_ID = MR.REVIEW_ID
						 GROUP BY R.REVIEW_RATING
						 ORDER BY AVG(R.REVIEW_RATING)
						 LIMIT 1);
								

--h 
SELECT M.MOVIE_TITLE, U.USER_NAME, R.REVIEW_RATING
FROM MOVIES M, REVIEW R, RAKEUSER U, MOVREV MR, USRREV UR
WHERE M.MOVIE_ID = MR.MOVIE_ID AND 
      MR.REVIEW_ID = R.REVIEW_ID AND
      R.REVIEW_ID = UR.REVIEW_ID AND
      UR.USER_ID = U.USER_ID;

--i
SELECT M.*
FROM MOVIES M, MOVREV MR, REVIEW R
WHERE R.REVIEW_DATE < '2016-01-01' AND 
      R.REVIEW_ID = MR.REVIEW_ID AND
      MR.MOVIE_ID = M.MOVIE_ID;

--j 

--gives movie and average rating for the movie
SELECT M.MOVIE_TITLE, AVG(R.REVIEW_RATING)
FROM REVIEW R, MOVREV MR, MOVIES M
WHERE R.REVIEW_ID = MR.REVIEW_ID AND
MR.MOVIE_ID = M.MOVIE_ID
GROUP BY M.MOVIE_TITLE
ORDER BY AVG(R.REVIEW_RATING) DESC;

--count of the # of ratings a movie has
SELECT M.MOVIE_TITLE, AVG(R.REVIEW_RATING)
FROM REVIEW R, MOVREV MR, MOVIES M, GENRE G
WHERE R.REVIEW_ID = MR.REVIEW_ID AND
MR.MOVIE_ID = M.MOVIE_ID
GROUP BY M.MOVIE_TITLE
ORDER BY AVG(R.REVIEW_RATING) DESC;


--gives movie and average rating for the movie
-- SELECT M.MOVIE_TITLE, AVG(R.REVIEW_RATING), RU.USER_ID
-- FROM REVIEW R, MOVREV MR, MOVIES M, RAKEUSER RU
-- WHERE R.REVIEW_ID = MR.REVIEW_ID AND
-- MR.MOVIE_ID = M.MOVIE_ID
-- GROUP BY M.MOVIE_TITLE
-- ORDER BY AVG(R.REVIEW_RATING) DESC

--given a genre, shows all the movies in it
-- SELECT M.MOVIE_TITLE, G.GENRE_NAME
-- FROM MOVIES M, GENRE G, MOVGEN MG
-- WHERE G.GENRE_NAME = 'Biography' AND
-- M.MOVIE_ID = MG.MOVIE_ID AND
-- G.GENRE_ID = MG.GENRE_ID

-- AVG + GENRE_NAME
-- SELECT M.MOVIE_TITLE, G.GENRE_NAME, AVG(R.REVIEW_RATING)
-- FROM REVIEW R, MOVREV MR, MOVIES M, GENRE G, MOVGEN MG
-- WHERE R.REVIEW_ID = MR.REVIEW_ID AND
-- MR.MOVIE_ID = M.MOVIE_ID AND
-- G.GENRE_NAME = 'Drama' AND
-- M.MOVIE_ID = MG.MOVIE_ID AND
-- G.GENRE_ID = MG.GENRE_ID
-- GROUP BY M.MOVIE_TITLE, G.GENRE_NAME
-- ORDER BY AVG(R.REVIEW_RATING) DESC

--given a movie, find all reviews for it
-- SELECT M.MOVIE_TITLE, R.REVIEW_ID, R.REVIEW_DESCRIPTION, R.REVIEW_RATING, R.REVIEW_DATE
-- FROM MOVIES M, MOVREV MR, REVIEW R
-- WHERE M.MOVIE_TITLE = 'The Shawshank Redemption' AND
-- M.MOVIE_ID = MR.MOVIE_ID AND
-- MR.REVIEW_ID = R.REVIEW_ID


--get highest rated movie ID in a genre
-- SELECT M.MOVIE_ID, R.REVIEW_RATING, AVG(R.REVIEW_RATING)
-- FROM MOVIES M, REVIEW R, MOVREV MR
-- WHERE M.MOVIE_ID = MR.MOVIE_ID AND
-- MR.REVIEW_ID = R.REVIEW_ID
-- GROUP BY M.MOVIE_ID, R.REVIEW_RATING
-- ORDER BY AVG(R.REVIEW_RATING) DESC
-- LIMIT 1


-- --given a movie ID, find all the users that rated it

-- 	M.MOVIE_ID = (SELECT M.MOVIE_ID, R.REVIEW_RATING, AVG(R.REVIEW_RATING)
-- 	FROM MOVIES M, REVIEW R, MOVREV MR
-- 	WHERE M.MOVIE_ID = MR.MOVIE_ID AND
-- 	MR.REVIEW_ID = R.REVIEW_ID
-- 	GROUP BY M.MOVIE_ID, R.REVIEW_RATING
-- 	ORDER BY AVG(R.REVIEW_RATING) DESC
-- 	LIMIT 1
-- 	)


-- k
SELECT M.MOVIE_TITLE, M.MOVIE_ID, RU.USER_NAME
FROM MOVIES M, RAKEUSER RU, USRREV UR, MOVREV MR
WHERE
RU.USER_ID = UR.USER_ID AND
UR.REVIEW_ID = MR.REVIEW_ID AND
M.MOVIE_ID = (SELECT M.MOVIE_ID
				FROM REVIEW R, MOVREV MR, MOVIES M, GENRE G, MOVGEN MG
				WHERE R.REVIEW_ID = MR.REVIEW_ID AND
				MR.MOVIE_ID = M.MOVIE_ID AND
				G.GENRE_NAME = 'Drama' AND
				M.MOVIE_ID = MG.MOVIE_ID AND
				G.GENRE_ID = MG.GENRE_ID
				GROUP BY M.MOVIE_ID
				ORDER BY AVG(R.REVIEW_RATING) DESC
				LIMIT 1) AND
MR.MOVIE_ID = M.MOVIE_ID;

--m
SELECT UR.USER_ID, AVG(R.REVIEW_RATING), RU.USER_NAME, RU.USER_GENDER
FROM RAKEUSER RU, USRREV UR, MOVREV MR, REVIEW R, PROFILE P
WHERE 
RU.USER_ID = UR.USER_ID AND
UR.REVIEW_ID = MR.REVIEW_ID AND
MR.REVIEW_ID = R.REVIEW_ID AND
RU.USER_ID = P.USER_ID
GROUP BY UR.USER_ID, RU.USER_NAME, RU.USER_GENDER, RU.USER_DOB
ORDER BY AVG(R.REVIEW_RATING) DESC
