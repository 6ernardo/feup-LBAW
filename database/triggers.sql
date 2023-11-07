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
        END IF;
    ELSIF TG_TABLE_NAME = 'user_vote_answer' THEN
        IF TG_OP = 'INSERT' THEN
            UPDATE answer
            SET score = score + NEW.vote
            WHERE answer_id = NEW.answer_id;
            RETURN NEW;
        END IF;
    ELSIF TG_TABLE_NAME = 'user_vote_comment_question' THEN
        IF TG_OP = 'INSERT' THEN
            UPDATE comment_question
            SET score = score + NEW.vote
            WHERE comment_id = NEW.comment_id;
            RETURN NEW;
        END IF;
    ELSIF TG_TABLE_NAME = 'user_vote_comment_answer' THEN
        IF TG_OP = 'INSERT' THEN
            UPDATE comment_answer
            SET score = score + NEW.vote
            WHERE comment_id = NEW.comment_id;
            RETURN NEW;
        END IF;
    END IF;

    RETURN NEW;

END
$$ LANGUAGE plpgsql;

CREATE TRIGGER TRIGGER05
AFTER INSERT ON user_vote_question
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER17
AFTER INSERT ON user_vote_answer
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER18
AFTER INSERT ON user_vote_comment_question
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();

CREATE TRIGGER TRIGGER19
AFTER INSERT ON user_vote_comment_answer
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();


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
