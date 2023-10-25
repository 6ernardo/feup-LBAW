-- A user can’t report his own question, as stated in BR01
CREATE FUNCTION check_own_report() RETURNS TRIGGER AS $$
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
EXECUTE FUNCTION check_own_report();

-- A user can’t report his own answer, as stated in BR01

CREATE FUNCTION check_own_report_answer() RETURNS TRIGGER AS $$
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
EXECUTE FUNCTION check_own_report_answer();

-- A user can’t report his own comment, as stated in BR01
CREATE OR REPLACE FUNCTION check_own_report_comment() RETURNS TRIGGER AS $$
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


CREATE TRIGGER TRIGGER03
BEFORE INSERT ON report_comment_answer
FOR EACH ROW
EXECUTE FUNCTION check_own_report_comment();

-- A user can’t follow his own account, as stated in BR02
CREATE OR REPLACE FUNCTION check_own_follow_user() RETURNS TRIGGER AS $$
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

-- A post’s rating is equal to the number of upvotes minus the number of downvotes, as stated in BR03
CREATE FUNCTION update_post_rating() RETURNS TRIGGER AS $$
DECLARE
    upvote_count INT;
    downvote_count INT;
    rating INT;
BEGIN
    DECLARE
        table_name TEXT;
    BEGIN
        IF TG_RELNAME = 'user_vote_question' THEN
            table_name := 'question';
        ELSIF TG_RELNAME = 'user_vote_answer' THEN
            table_name := 'answer';
        END IF;

        SELECT COUNT(*) INTO upvote_count
        FROM table_name
        WHERE NEW.question_id = table_name.question_id AND NEW.vote = 1;

        SELECT COUNT(*) INTO downvote_count
        FROM table_name
        WHERE NEW.question_id = table_name.question_id AND NEW.vote = -1;

        -- rating
        rating := upvote_count - downvote_count;

        -- update the post's rating
        UPDATE table_name
        SET score = rating
        WHERE NEW.question_id = table_name.question_id;

        RETURN NEW;
    END;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER TRIGGER05
AFTER INSERT ON user_vote_question
FOR EACH ROW
EXECUTE FUNCTION update_post_rating();


CREATE TRIGGER TRIGGER05
AFTER INSERT ON user_vote_answer
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


CREATE TRIGGER TRIGGER06
AFTER INSERT ON answer
FOR EACH ROW
EXECUTE FUNCTION upvote_own_answer();