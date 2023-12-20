BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

SELECT question.question_id, question.title, question.description, question.timestamp, users.name AS author_name
FROM question
JOIN users ON question.author_id = users.user_id
WHERE now() < question.timestamp
GROUP BY question.question_id, users.name
ORDER BY question.score
LIMIT 10;

END TRANSACTION;  


BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL READ COMMITTED;

SELECT question.question_id, question.title, question.description, question.timestamp, users.name AS author_name
FROM question
INNER JOIN users ON question.author_id = users.user_id
WHERE question.title = '$search_inp'
OR question.description = '$search_inp';

END TRANSACTION; 


BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

SELECT question.question_id, question.title, question.description, question.timestamp, users.name AS author_name
FROM question
INNER JOIN users ON question.author_id = users.user_id
INNER JOIN question_tags ON question_tags.question_id = question.question_id
INNER JOIN tag ON question_tags.tag_id = tag.tag_id
WHERE tag.name = '$tag_name'
AND now() < question.timestamp
LIMIT 10;

END TRANSACTION;