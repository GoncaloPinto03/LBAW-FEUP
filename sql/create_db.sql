DROP SCHEMA lbaw2394 CASCADE;
CREATE SCHEMA lbaw2394	
SET search_path TO lbaw2394;

------------------------------------------------------------------------------------
------------------------------------- DROP TABLES ----------------------------------
------------------------------------------------------------------------------------


DROP TABLE IF EXISTS comment_report CASCADE;
DROP TABLE IF EXISTS article_report CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS dislike_comment CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS dislike_post CASCADE;
DROP TABLE IF EXISTS like_post CASCADE;
DROP TABLE IF EXISTS article_notification CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS favourite CASCADE;
DROP TABLE IF EXISTS article_vote CASCADE;
DROP TABLE IF EXISTS follow CASCADE;
DROP TABLE IF EXISTS comment_vote CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS article CASCADE;
DROP TABLE IF EXISTS topic CASCADE;
DROP TABLE IF EXISTS ban CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS admin CASCADE;

DROP FUNCTION IF EXISTS article_search_update CASCADE;
DROP FUNCTION IF EXISTS user_search_update CASCADE;
DROP FUNCTION IF EXISTS adjust_likes_dislikes_and_notification CASCADE;
DROP FUNCTION IF EXISTS undo_like_dislike_and_update_reputation CASCADE;
DROP FUNCTION IF EXISTS delete_related_data CASCADE;
DROP FUNCTION IF EXISTS delete_comment_content CASCADE;
DROP FUNCTION IF EXISTS prevent_self_like_dislike CASCADE;
DROP FUNCTION IF EXISTS create_comment_notification CASCADE;
DROP FUNCTION IF EXISTS prevent_multiple_likes_on_article CASCADE;
DROP FUNCTION IF EXISTS prevent_multiple_likes_on_comment CASCADE;
DROP FUNCTION IF EXISTS prevent_duplicate_topic_follow CASCADE;

------------------------------------------------------------------------------------
------------------------------------- TABLES ---------------------------------------
------------------------------------------------------------------------------------

-- Note that plural table names are used to avoid conflicts with reserved words (users).

------- ADMIN --------
CREATE TABLE admin (
    admin_id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

------- USER -------
CREATE TABLE users(
    user_id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    reputation INTEGER
);

-------- BAN --------
CREATE TABLE ban (
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    admin_id INTEGER NOT NULL REFERENCES admin (admin_id) ON UPDATE CASCADE
);

------- TOPIC -------
CREATE TABLE topic (
    topic_id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL CONSTRAINT topic_name_uk UNIQUE
);

------------ ARTICLE ------------
CREATE TABLE article (
    article_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    date TIMESTAMP NOT NULL,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    topic_id INTEGER NOT NULL REFERENCES topic (topic_id) ON UPDATE CASCADE
);


------- COMMENT -------
CREATE TABLE comment (
    comment_id SERIAL PRIMARY KEY ,
    text VARCHAR(256) NOT NULL,
    date TIMESTAMP NOT NULL,
    likes INTEGER DEFAULT 0,
    dislikes INTEGER DEFAULT 0,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    article_id INTEGER NOT NULL REFERENCES article(article_id) ON UPDATE CASCADE
);

-------- COMMENT-VOTE --------
CREATE TABLE comment_vote (
    is_like BOOLEAN NOT NULL,
    comment_id INTEGER NOT NULL REFERENCES comment (comment_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE
);

-------- FOLLOW --------
CREATE TABLE follow (
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    topic_id INTEGER NOT NULL REFERENCES topic (topic_id) ON UPDATE CASCADE
);

-------- ARTICLE-VOTE --------
CREATE TABLE article_vote (
    is_like BOOLEAN NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    article_id INTEGER NOT NULL REFERENCES article (article_id) ON UPDATE CASCADE
);

-------- FAVOURITE --------
CREATE TABLE favourite (
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    article_id INTEGER NOT NULL REFERENCES article(article_id) ON UPDATE CASCADE
);

----------- NOTIFICATION -----------
CREATE TABLE notification (
    notification_id SERIAL PRIMARY KEY,
    date TIMESTAMP NOT NULL,
    viewed BOOLEAN DEFAULT FALSE,
    notified_user INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE,
    emitter_user INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE
);

------- COMMENT-NOTIFICATION -------
CREATE TABLE comment_notification (
   notification_id SERIAL PRIMARY KEY REFERENCES notification (notification_id) ON UPDATE CASCADE,
   comment_id INTEGER NOT NULL REFERENCES comment (comment_id) ON UPDATE CASCADE
);

------- ARTIcLE-NOTIFICATION -------
CREATE TABLE article_notification (
   notification_id SERIAL PRIMARY KEY REFERENCES notification (notification_id) ON UPDATE CASCADE,
   article_id INTEGER NOT NULL REFERENCES article (article_id) ON UPDATE CASCADE
);

------- LIKE-POST -------
CREATE TABLE like_post (
    notification_id INTEGER NOT NULL REFERENCES notification(notification_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE
);

------- DISLIKE-POST ------
CREATE TABLE dislike_post (
    notification_id INTEGER NOT NULL REFERENCES notification(notification_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE
);

------- LIKE-COMMENT -------
CREATE TABLE like_comment (
    notification_id INTEGER NOT NULL REFERENCES notification(notification_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE
);

------- DISLIKE-COMMENT -------
CREATE TABLE dislike_comment (
    notification_id INTEGER NOT NULL REFERENCES notification(notification_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON UPDATE CASCADE
);

-------- REPORT --------
CREATE TABLE report (
    report_id SERIAL PRIMARY KEY,
    description TEXT NOT NULL,
    date TIMESTAMP NOT NULL
);

------- COMMENT-REPORT -------
CREATE TABLE comment_report (
    comment_id INTEGER NOT NULL  REFERENCES comment(comment_id) ON UPDATE CASCADE,
    report_id INTEGER NOT NULL REFERENCES report(report_id)ON UPDATE CASCADE
); 

------- ARTICLE-REPORT -------
CREATE TABLE article_report (
    article_id INTEGER NOT NULL REFERENCES article(article_id) ON UPDATE CASCADE,
    report_id INTEGER NOT NULL REFERENCES report(report_id) ON UPDATE CASCADE
);

------------------------------------------------------------------------------------
------------------------------------- INDEXES --------------------------------------
------------------------------------------------------------------------------------

CREATE INDEX user_notified ON notification USING btree (notified_user);
CLUSTER notification USING user_notified;

CREATE INDEX user_emitter ON notification USING btree (emitter_user);
CLUSTER notification USING user_emitter;

CREATE INDEX owner_id_article ON article USING hash (user_id);

CREATE INDEX owner_id_comment ON comment USING hash (user_id);

-- FTS INDEXES

-- Add column to article to store computed ts_vectors.
ALTER TABLE article
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION article_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('simple', NEW.name), 'A') ||
         setweight(to_tsvector('simple', NEW.description), 'B')
        );
END IF;
IF TG_OP = 'UPDATE' THEN
    IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
        NEW.tsvectors = (
            setweight(to_tsvector('simple', NEW.name), 'A') ||
            setweight(to_tsvector('simple', NEW.description), 'B')
           );
    END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on article
CREATE TRIGGER article_search_update
 BEFORE INSERT OR UPDATE ON article
 FOR EACH ROW
 EXECUTE PROCEDURE article_search_update();

-- Create a GIN index for ts_vectors.
CREATE INDEX search_article ON article USING GIN (tsvectors);

-- Add column to user to store computed ts_vectors.
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
       NEW.tsvectors = (
         setweight(to_tsvector('simple', NEW.name), 'A') ||
         setweight(to_tsvector('simple', NEW.email), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.email <> OLD.email) THEN
            NEW.tsvectors = (
            setweight(to_tsvector('simple', NEW.name), 'A') ||
            setweight(to_tsvector('simple', NEW.description), 'B')
           );
    END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on user.
CREATE TRIGGER user_search_update
 BEFORE INSERT OR UPDATE ON users
 FOR EACH ROW
 EXECUTE PROCEDURE user_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_user ON users USING GIN (tsvectors);



------------------------------------------------------------------------------------
------------------------------------- TRIGGERS -------------------------------------
------------------------------------------------------------------------------------

------TRIGGER 01------

CREATE OR REPLACE FUNCTION adjust_likes_dislikes_and_notification()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.like THEN
        UPDATE article SET likes = likes + 1 WHERE article_id = NEW.article_id;
    ELSE
        UPDATE article SET dislikes = dislikes + 1 WHERE article_id = NEW.article_id;
    END IF;

    -- Generate a notification associated with the feedback event
    INSERT INTO notification (date, user_id) VALUES (NOW(), NEW.user_id)
    RETURNING notification_id INTO NEW.notification_id;
    
    -- Update the reputation of the user who provided the feedback
    UPDATE users SET reputation = reputation + 1 WHERE user_id = NEW.user_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER adjust_likes_dislikes_and_notification
AFTER INSERT ON article_vote
FOR EACH ROW
EXECUTE FUNCTION adjust_likes_dislikes_and_notification();

------TRIGGER 02------

CREATE OR REPLACE FUNCTION undo_like_dislike_and_update_reputation()
RETURNS TRIGGER AS $$
BEGIN
    IF OLD.like THEN
        UPDATE article SET likes = likes - 1 WHERE article_id = OLD.article_id;
    ELSE
        UPDATE article SET dislikes = dislikes - 1 WHERE article_id = OLD.article_id;
    END IF;

    -- Update the reputation of the authenticated user
    UPDATE users SET reputation = reputation - 1 WHERE user_id = OLD.user_id;

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER undo_like_dislike_and_update_reputation
AFTER DELETE ON article_vote
FOR EACH ROW
EXECUTE FUNCTION undo_like_dislike_and_update_reputation();

------TRIGGER 03------

CREATE OR REPLACE FUNCTION delete_related_data()
RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM comment WHERE article_id = OLD.article_id;

    DELETE FROM article_vote WHERE article_id = OLD.article_id;

    DELETE FROM favourite WHERE article_id = OLD.article_id;

    DELETE FROM article_notification WHERE article_id = OLD.article_id;

    DELETE FROM article_report WHERE article_id = OLD.article_id;

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_related_data
BEFORE DELETE ON article
FOR EACH ROW
EXECUTE FUNCTION delete_related_data();

------TRIGGER 04------

CREATE OR REPLACE FUNCTION delete_comment_content()
RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM comment_vote WHERE comment_id = OLD.comment_id;
    DELETE FROM comment_notification WHERE comment_id = OLD.comment_id;
    
    UPDATE article
    SET likes = likes - OLD.likes,
        dislikes = dislikes - OLD.dislikes
    WHERE article_id = OLD.article_id;

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_comment_content
BEFORE DELETE ON comment
FOR EACH ROW
EXECUTE FUNCTION delete_comment_content();

------TRIGGER 05------

CREATE OR REPLACE FUNCTION prevent_self_like_dislike()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT user_id FROM article WHERE article_id = NEW.article_id) THEN
        RAISE EXCEPTION 'You cannot like or dislike your own content';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_self_like_dislike
BEFORE INSERT ON article_vote
FOR EACH ROW
EXECUTE FUNCTION prevent_self_like_dislike();

------TRIGGER 06------

CREATE OR REPLACE FUNCTION create_comment_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notification (date, user_id)
    VALUES (NOW(), NEW.user_id)
    RETURNING notification_id INTO NEW.notification_id;
    
    INSERT INTO comment_notification (notification_id, comment_id)
    VALUES (NEW.notification_id, NEW.comment_id);
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER create_comment_notification
AFTER INSERT ON comment
FOR EACH ROW
EXECUTE FUNCTION create_comment_notification();

------TRIGGER 07------

CREATE OR REPLACE FUNCTION prevent_multiple_likes_on_article()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the user has already liked the article
    IF EXISTS (SELECT 1 FROM article_vote WHERE article_id = NEW.article_id AND user_id = NEW.user_id AND is_like = true) THEN
        RAISE EXCEPTION 'You can only like the article once';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_on_article
BEFORE INSERT ON article_vote
FOR EACH ROW
EXECUTE FUNCTION prevent_multiple_likes_on_article(); 

------TRIGGER 08------

CREATE OR REPLACE FUNCTION prevent_multiple_likes_on_comment()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the user has already liked the comment on this article
    IF EXISTS (SELECT 1 FROM comment_vote WHERE comment_id = NEW.comment_id AND user_id = NEW.user_id AND is_like = true) THEN
        RAISE EXCEPTION 'You can only like a comment once';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_on_comment
BEFORE INSERT ON comment_vote
FOR EACH ROW
EXECUTE FUNCTION prevent_multiple_likes_on_comment();

------TRIGGER 09------

CREATE OR REPLACE FUNCTION prevent_duplicate_topic_follow()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the user is already following the topic
    IF EXISTS (SELECT 1 FROM follow WHERE user_id = NEW.user_id AND topic_id = NEW.topic_id) THEN
        RAISE EXCEPTION 'You are already following this topic';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_duplicate_topic_follow
BEFORE INSERT ON follow
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_topic_follow();


------------------------------------------------------------------------------------
------------------------------------- TRANSACTIONS ---------------------------------
------------------------------------------------------------------------------------

------TRAN 01------

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

-- Insert report
INSERT INTO report (description, date)
 VALUES ($description, TIMESTAMP);

-- Insert article report
INSERT INTO article_report (article_id, report_id)
 VALUES (currval('article_id_seq'), $report_id);

END TRANSACTION;


------TRAN 02------

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

    INSERT INTO comment (text, date, likes, dislikes, user_id, article_id)
     VALUES ($text, TIMESTAMP, 0, 0, $user_id, $article_id);

COMMIT;
