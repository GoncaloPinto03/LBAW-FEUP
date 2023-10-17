create schema if not exists labw2394;

------------------------------------------------------------------------------------
------------------------------------- DROP TABLES ----------------------------------
------------------------------------------------------------------------------------

DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS ban CASCADE;

DROP TABLE IF EXISTS user CASCADE;

DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS comment_vote CASCADE;

DROP TABLE IF EXISTS topic CASCADE;
DROP TABLE IF EXISTS follow CASCADE;

DROP TABLE IF EXISTS article CASCADE;
DROP TABLE IF EXISTS article_vote CASCADE;
DROP TABLE IF EXISTS favourite CASCADE;

DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS article_notification CASCADE;
DROP TABLE IF EXISTS like_post CASCADE;
DROP TABLE IF EXISTS dislike_post CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS dislike_comment CASCADE;

DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS comment_report CASCADE;
DROP TABLE IF EXISTS article_report CASCADE;

------------------------------------------------------------------------------------
------------------------------------- TABLES ---------------------------------------
------------------------------------------------------------------------------------

------- ADMIN --------
CREATE TABLE admin (
    admin_id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

-------- BAN --------
CREATE TABLE ban (
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id)
);

------- USER -------
CREATE TABLE user(
    user_id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    reputation INTEGER
);

------- COMMENT -------
CREATE TABLE comment (
    comment_id SERIAL PRIMARY KEY ,
    text VARCHAR(256) NOT NULL,
    date DATETIME NOT NULL,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (article_id) REFERENCES article(article_id)
);

-------- COMMENT-VOTE --------
CREATE TABLE comment_vote (
    like BOOLEAN NOT NULL,
    FOREIGN KEY (comment_id) REFERENCES comment(comment_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

------- TOPIC -------
CREATE TABLE topic (
    topic_id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL CONSTRAINT topic_name_uk UNIQUE,
);

-------- FOLLOW --------
CREATE TABLE follow (
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (topic_id) REFERENCES topic(topic_id)
);

------------ ARTICLE ------------
CREATE TABLE article (
    article_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    date DATETIME NOT NULL,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    FOREIGN KEY (topic_id) REFERENCES topic(topic_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

-------- ARTICLE-VOTE --------
CREATE TABLE article_vote (
    like BOOLEAN NOT NULL,
    FOREIGN KEY (article_id) REFERENCES article(article_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

-------- FAVOURITE --------
CREATE TABLE favourite (
    FOREIGN KEY (article_id) REFERENCES article(article_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

----------- NOTIFICATION -----------
CREATE TABLE notification (
    notification_id SERIAL PRIMARY KEY,
    date DATETIME NOT NULL,
    viewed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
);

------- COMMENT-NOTIFICATION -------
CREATE TABLE comment_notification (
   notification_id SERIAL PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
   comment_id INTEGER NOT NULL REFERENCES comment (id) ON UPDATE CASCADE
);

------- ARTICLE-NOTIFICATION -------
CREATE TABLE post_notification (
   notification_id SERIAL PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
   article_id INTEGER NOT NULL REFERENCES article (id) ON UPDATE CASCADE
);

------- LIKE-POST -------
CREATE TABLE like_post (
    FOREIGN KEY (notification_id) REFERENCES notification(notification_id)
    FOREIGN KEY (user_id) REFERENCES user(user_id),
);

------- DISLIKE-POST ------
CREATE TABLE dislike_post (
    FOREIGN KEY (notification_id) REFERENCES notification(notification_id)
    FOREIGN KEY (user_id) REFERENCES user(user_id),
);

------- LIKE-COMMENT -------
CREATE TABLE like_comment (
    FOREIGN KEY (notification_id) REFERENCES notification(notification_id)
    FOREIGN KEY (user_id) REFERENCES user(user_id),
);

------- DISLIKE-COMMENT -------
CREATE TABLE dislike_comment (
    FOREIGN KEY (notification_id) REFERENCES notification(notification_id)
    FOREIGN KEY (user_id) REFERENCES user(user_id),
);

-------- REPORT --------
CREATE TABLE report (
    report_id SERIAL PRIMARY KEY,
    description TEXT NOT NULL,
    date DATETIME NOT NULL,
);

------- COMMENT-REPORT -------
CREATE TABLE comment_report (
    FOREIGN KEY (comment_id) REFERENCES comment(comment_id),
    FOREIGN KEY (report_id) REFERENCES report(report_id)
);

------- ARTICLE-REPORT -------
CREATE TABLE article_report (
    FOREIGN KEY (article_id) REFERENCES article(article_id),
    FOREIGN KEY (report_id) REFERENCES report(report_id)
);

------------------------------------------------------------------------------------
------------------------------------- INDEXES --------------------------------------
------------------------------------------------------------------------------------

------------------------------------------------------------------------------------
------------------------------------- TRIGGERS -------------------------------------
------------------------------------------------------------------------------------
