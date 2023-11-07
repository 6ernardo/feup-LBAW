DROP TABLE IF EXISTS user_vote_comment_answer;
DROP TABLE IF EXISTS user_vote_comment_question;
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
    profilePicture VARCHAR(255),
    score INT NOT NULL DEFAULT 0,
    moderator BOOLEAN NOT NULL DEFAULT false
);

CREATE TABLE admin (
    admin_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE tag (
    tag_id SERIAL PRIMARY KEY ,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE question (
    question_id SERIAL PRIMARY KEY,
    author_id INT NOT NULL,
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

CREATE TABLE user_vote_comment_question (
    user_id INT NOT NULL,
    comment_id INT NOT NULL,
    vote INT NOT NULL CHECK (vote=1 OR vote=-1),
    PRIMARY KEY (user_id, comment_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_comment FOREIGN KEY (comment_id) REFERENCES comment_question(comment_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_vote_comment_answer (
    user_id INT NOT NULL,
    comment_id INT NOT NULL,
    vote INT NOT NULL CHECK (vote=1 OR vote=-1),
    PRIMARY KEY (user_id, comment_id),
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_comment FOREIGN KEY (comment_id) REFERENCES comment_answer(comment_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE notification (
    notificationID SERIAL PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    TYPE NotificationOrigin NOT NULL,
    user_id INT NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);
