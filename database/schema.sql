--
-- Use a specific schema and set it as default
--
DROP SCHEMA IF EXISTS lbaw2381 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2381;
SET search_path TO lbaw2381;

DROP TABLE IF EXISTS user_vote_answer;
DROP TABLE IF EXISTS user_vote_question;
DROP TABLE IF EXISTS report_comment_answer;
DROP TABLE IF EXISTS report_comment_question;
DROP TABLE IF EXISTS report_answer;
DROP TABLE IF EXISTS report_question;
DROP TABLE IF EXISTS user_badges;
DROP TABLE IF EXISTS badge;
DROP TABLE IF EXISTS follow_user;
DROP TABLE IF EXISTS follow_tag;
DROP TABLE IF EXISTS follow_question;
DROP TABLE IF EXISTS comment_answer;
DROP TABLE IF EXISTS comment_question;
DROP TABLE IF EXISTS answer;
DROP TABLE IF EXISTS question_tags;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS users;

DROP TYPE IF EXISTS NotificationOrigin;

DROP FUNCTION IF EXISTS question_own_report CASCADE;
DROP FUNCTION IF EXISTS answer_own_report CASCADE;
DROP FUNCTION IF EXISTS check_own_report_comment CASCADE;
DROP FUNCTION IF EXISTS check_own_follow_user CASCADE;
DROP FUNCTION IF EXISTS update_post_rating CASCADE;
DROP FUNCTION IF EXISTS upvote_own_question CASCADE;
DROP FUNCTION IF EXISTS upvote_own_answer CASCADE;
DROP FUNCTION IF EXISTS enforce_answer_timestamp CASCADE;
DROP FUNCTION IF EXISTS enforce_comment_question_timestamp CASCADE;
DROP FUNCTION IF EXISTS enforce_comment_answer_timestamp CASCADE;
DROP FUNCTION IF EXISTS delete_answer_comments CASCADE;
DROP FUNCTION IF EXISTS delete_associated_answers CASCADE;
DROP FUNCTION IF EXISTS delete_question_comments CASCADE;
DROP FUNCTION IF EXISTS question_unique_report CASCADE;
DROP FUNCTION IF EXISTS answer_unique_report CASCADE;
DROP FUNCTION IF EXISTS comment_unique_report CASCADE;

DROP FUNCTION IF EXISTS question_search_update CASCADE;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE NotificationOrigin AS ENUM ('Question', 'Answer', 'Comment', 'Rating', 'Badge');

-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    score INT NOT NULL DEFAULT 0,
    is_moderator BOOLEAN NOT NULL DEFAULT false,
    is_blocked BOOLEAN NOT NULL DEFAULT false

);

CREATE TABLE admin (
    admin_id SERIAL PRIMARY KEY,
    CONSTRAINT fk_user FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tag (
    tag_id SERIAL PRIMARY KEY ,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE question (
    question_id SERIAL PRIMARY KEY,
    author_id INT NOT NULL,
    correct_answer_id INT,
    title TEXT NOT NULL,
    description TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    score INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_author FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE question_tags (
    question_id INT,
    tag_id INT,
    PRIMARY KEY (question_id, tag_id),
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tag FOREIGN KEY (tag_id) REFERENCES tag(tag_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE answer (
    answer_id SERIAL PRIMARY KEY,
    author_id INT NOT NULL,
    question_id INT NOT NULL,
    description TEXT NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    score INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_author FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE Question
ADD FOREIGN KEY (correct_answer_id) REFERENCES Answer(answer_id);

CREATE TABLE comment_question (
    comment_id SERIAL PRIMARY KEY,
    author_id INT NOT NULL,
    question_id INT NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    score INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_author FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comment_answer (
    comment_id SERIAL PRIMARY KEY,
    author_id INT NOT NULL,
    answer_id INT NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    score INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_author FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_answer FOREIGN KEY (answer_id) REFERENCES answer(answer_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE follow_question (
    user_id INT,
    question_id INT,
    PRIMARY KEY (user_id, question_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE follow_tag (
    user_id INT,
    tag_id INT,
    PRIMARY KEY (user_id, tag_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tag FOREIGN KEY (tag_id) REFERENCES tag(tag_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE follow_user (
    follower_id INT,
    following_id INT,
    PRIMARY KEY (follower_id, following_id),
    CONSTRAINT fk_follower FOREIGN KEY (follower_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_following FOREIGN KEY (following_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE badge (
    badge_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE user_badges (
    user_id INT,
    badge_id INT,
    PRIMARY KEY (user_id, badge_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_badge FOREIGN KEY (badge_id) REFERENCES badge(badge_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE report_question (
    report_id SERIAL PRIMARY KEY,
    question_id INT NOT NULL,
    reporter_id INT NOT NULL,
    reason TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reporter FOREIGN KEY (reporter_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE report_answer (
    report_id SERIAL PRIMARY KEY,
    answer_id INT NOT NULL,
    reporter_id INT NOT NULL,
    reason TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_answer FOREIGN KEY (answer_id) REFERENCES answer(answer_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reporter FOREIGN KEY (reporter_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE report_comment_question (
    report_id SERIAL PRIMARY KEY,
    comment_id INT NOT NULL,
    reporter_id INT NOT NULL,
    reason TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment FOREIGN KEY (comment_id) REFERENCES comment_question(comment_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reporter FOREIGN KEY (reporter_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE report_comment_answer (
    report_id SERIAL PRIMARY KEY,
    comment_id INT NOT NULL,
    reporter_id INT NOT NULL,
    reason TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment FOREIGN KEY (comment_id) REFERENCES comment_answer(comment_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reporter FOREIGN KEY (reporter_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_vote_question (
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    vote INT NOT NULL CHECK (vote=1 OR vote=-1),
    PRIMARY KEY (user_id, question_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_vote_answer (
    user_id INT NOT NULL,
    answer_id INT NOT NULL,
    vote INT NOT NULL CHECK (vote=1 OR vote=-1),
    PRIMARY KEY (user_id, answer_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_answer FOREIGN KEY (answer_id) REFERENCES answer(answer_id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE notification (
    notificationID SERIAL PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    TYPE NotificationOrigin NOT NULL,
    user_id INT NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-----------------------------------------
-- Indexes
-----------------------------------------

-- Performance Indices
CREATE INDEX author_questions ON question USING btree(author_id);
CREATE INDEX notification_user ON notification USING btree(user_id);
CREATE INDEX tag_question ON question_tags USING btree(tag_id);
CREATE INDEX username ON users USING hash(name);

-- Full-text Search Indices
ALTER TABLE question
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION question_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER question_search_update
 BEFORE INSERT OR UPDATE ON question
 FOR EACH ROW
 EXECUTE PROCEDURE question_search_update();

CREATE INDEX search_idx ON question USING GIN (tsvectors);

-----------------------------------------
-- Triggers
-----------------------------------------

-- A user can’t report his own question, as stated in BR01
CREATE FUNCTION question_own_report() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.reporter_id = (SELECT author_id FROM question WHERE question_id = NEW.question_id) THEN
        RAISE EXCEPTION 'A user is not allowed to report their own question';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER TRIGGER01
BEFORE INSERT ON report_question
FOR EACH ROW
EXECUTE FUNCTION question_own_report();

-- A user can’t report his own answer, as stated in BR01
CREATE FUNCTION answer_own_report() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.reporter_id = (SELECT author_id FROM answer WHERE answer_id = NEW.answer_id) THEN
        RAISE EXCEPTION 'A user is not allowed to report their own answer';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER02
BEFORE INSERT ON report_answer
FOR EACH ROW
EXECUTE FUNCTION answer_own_report();

-- A user can’t report his own comment, as stated in BR01
CREATE FUNCTION check_own_report_comment() RETURNS TRIGGER AS $$
BEGIN
    
    DECLARE
        table_name TEXT;
    BEGIN
        IF TG_RELNAME = 'report_comment_question' THEN
            table_name := 'comment_question';
        ELSIF TG_RELNAME = 'report_comment_answer' THEN
            table_name := 'comment_answer';
        END IF;

        IF NEW.reporter_id = (SELECT author_id FROM table_name WHERE comment_id = NEW.comment_id) THEN
            RAISE EXCEPTION 'A user is not allowed to report their own comment';
        END IF;

        RETURN NEW;
    END;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER03
BEFORE INSERT ON report_comment_question
FOR EACH ROW
EXECUTE FUNCTION check_own_report_comment();



-- A user can’t follow his own account, as stated in BR02
CREATE FUNCTION check_own_follow_user() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.follower_id = NEW.following_id THEN
        RAISE EXCEPTION 'A user is not allowed to follow their own account';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER TRIGGER04
BEFORE INSERT ON follow_user
FOR EACH ROW
EXECUTE FUNCTION check_own_follow_user();


--v2
-- A post’s rating is equal to the number of upvotes minus the number of downvotes, as stated in BR03
CREATE FUNCTION update_post_rating() RETURNS TRIGGER AS $$
BEGIN

    IF TG_TABLE_NAME = 'user_vote_question' THEN
        IF TG_OP = 'INSERT' THEN
            UPDATE question
            SET score = score + NEW.vote
            WHERE question_id = NEW.question_id;
        ELSIF TG_OP = 'DELETE' THEN
            UPDATE question
            SET score = score - OLD.vote
            WHERE question_id = OLD.question_id;
        END IF;

    ELSIF TG_TABLE_NAME = 'user_vote_answer' THEN
        IF TG_OP = 'INSERT' THEN
            UPDATE answer
            SET score = score + NEW.vote
            WHERE answer_id = NEW.answer_id;
        ELSIF TG_OP = 'DELETE' THEN
            UPDATE answer
            SET score = score - OLD.vote
            WHERE answer_id = OLD.answer_id;
        END IF;
    END IF;

    IF TG_OP = 'INSERT' THEN
        RETURN NEW;
    ELSE
        RETURN OLD;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- questions e answers
CREATE TRIGGER TRIGGER05
AFTER INSERT ON user_vote_question
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER20
AFTER DELETE ON user_vote_question
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER17
AFTER INSERT ON user_vote_answer
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER18
AFTER DELETE ON user_vote_answer
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();


CREATE FUNCTION update_vote_change() RETURNS TRIGGER AS $$
BEGIN
    -- ve se foi alterado
    IF OLD.vote != NEW.vote THEN
        
        IF TG_TABLE_NAME = 'user_vote_question' THEN
            UPDATE question
            SET score = score - OLD.vote + NEW.vote
            WHERE question_id = NEW.question_id;

        
        ELSIF TG_TABLE_NAME = 'user_vote_answer' THEN
            UPDATE answer
            SET score = score - OLD.vote + NEW.vote
            WHERE answer_id = NEW.answer_id;
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER21
AFTER UPDATE ON user_vote_question
FOR EACH ROW
EXECUTE FUNCTION update_vote_change();

CREATE TRIGGER TRIGGER22
AFTER UPDATE ON user_vote_answer
FOR EACH ROW
EXECUTE FUNCTION update_vote_change();


-- By default, the user will have his own question upvoted, as stated in BR04
CREATE FUNCTION upvote_own_question() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO user_vote_question (user_id, question_id, vote)
    VALUES (NEW.author_id, NEW.question_id, 1);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER06
AFTER INSERT ON question
FOR EACH ROW
EXECUTE FUNCTION upvote_own_question();



-- By default, the user will have his own answer upvoted, as stated in BR04
CREATE FUNCTION upvote_own_answer() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO user_vote_answer (user_id, answer_id, vote)
    VALUES (NEW.author_id, NEW.answer_id, 1);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER07
AFTER INSERT ON answer
FOR EACH ROW
EXECUTE FUNCTION upvote_own_answer();

--The timestamp for an answer must always be higher then the timestamp of the question it was posted on, as stated in BR05
CREATE FUNCTION enforce_answer_timestamp() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.timestamp <= (SELECT timestamp FROM question WHERE question_id = NEW.question_id) THEN
        RAISE EXCEPTION 'Answer timestamp must be higher than the question timestamp';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER TRIGGER08
BEFORE INSERT ON answer
FOR EACH ROW
EXECUTE FUNCTION enforce_answer_timestamp();

--The timestamp for a comment must always be higher then the timestamp of the question it was posted on, as stated in BR05
CREATE FUNCTION enforce_comment_question_timestamp() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.timestamp <= (SELECT timestamp FROM question WHERE question_id = NEW.question_id) THEN
        RAISE EXCEPTION 'Comment timestamp must be higher than the question timestamp';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER09
BEFORE INSERT ON comment_question
FOR EACH ROW
EXECUTE FUNCTION enforce_comment_question_timestamp();

--The timestamp for a comment must always be higher then the timestamp of the answer it was posted on, as stated in BR05
CREATE FUNCTION enforce_comment_answer_timestamp() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.timestamp <= (SELECT timestamp FROM answer WHERE answer_id = NEW.answer_id) THEN
        RAISE EXCEPTION 'Comment timestamp must be higher than the answer timestamp';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER10
BEFORE INSERT ON comment_answer
FOR EACH ROW
EXECUTE FUNCTION enforce_comment_answer_timestamp();

--Whenever an Answer is deleted the respective Comments should be deleted as well, as stated in BR07
CREATE FUNCTION delete_answer_comments() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM comment_answer
    WHERE answer_id = OLD.answer_id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER11
AFTER DELETE ON answer
FOR EACH ROW
EXECUTE FUNCTION delete_answer_comments();

--Whenever a Question is deleted the respective Answers should be deleted as well, as stated in BR08
CREATE FUNCTION delete_associated_answers() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM answer
    WHERE question_id = OLD.question_id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER12
AFTER DELETE ON question
FOR EACH ROW
EXECUTE FUNCTION delete_associated_answers();

--Whenever a Question is deleted the respective Comments should be deleted as well, as stated in BR08
CREATE FUNCTION delete_question_comments() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM comment_question
    WHERE question_id = OLD.question_id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER13
AFTER DELETE ON question
FOR EACH ROW
EXECUTE FUNCTION delete_question_comments();

--A user can only report a specific question once, as stated in BR09
CREATE FUNCTION question_unique_report() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1
        FROM report_question
        WHERE question_id = NEW.question_id AND reporter_id = NEW.reporter_id
    ) THEN
        RAISE EXCEPTION 'A user can only report a specific question once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER14
BEFORE INSERT ON report_question
FOR EACH ROW
EXECUTE FUNCTION question_unique_report();

--A user can only report a specific answer once, as stated in BR09
CREATE FUNCTION answer_unique_report() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1
        FROM report_answer
        WHERE answer_id = NEW.answer_id AND reporter_id = NEW.reporter_id
    ) THEN
        RAISE EXCEPTION 'A user can only report a specific answer once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER15
BEFORE INSERT ON report_answer
FOR EACH ROW
EXECUTE FUNCTION answer_unique_report();

--A user can only report a specific comment once, as stated in BR09
CREATE FUNCTION comment_unique_report() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1
        FROM report_comment_answer
        WHERE comment_id = NEW.comment_id AND reporter_id = NEW.reporter_id
    ) THEN
        RAISE EXCEPTION 'A user can only report a specific comment once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER16
BEFORE INSERT ON report_comment_answer
FOR EACH ROW
EXECUTE FUNCTION comment_unique_report();


-- Populate
insert into users (name, email, password, score, is_moderator) values ('client', 'client@client.com', '$2a$12$fu9IyYyjE5YGQmXpgzWPuO5jrGCEbkwSzYfIHZdAXr9FlZdILPD1C', 2080, true);
insert into admin (admin_id) VALUES (1);
