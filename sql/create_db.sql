CREATE SCHEMA IF NOT EXISTS labw2394;

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
CREATE TABLE users(
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

CREATE INDEX notification_user ON notification USING hash (user_id);

CREATE INDEX posts_user ON article USING hash (user_id);

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
CREATE INDEX search_article ON post USING GIN (tsvectors);

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
CREATE INDEX search_user ON work USING GIN (tsvectors);



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

CREATE TRIGGER trigger_5
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



------------------------------------------------------------------------------------
------------------------------------- TRANSACTIONS ---------------------------------
------------------------------------------------------------------------------------


------TRAN 01------

BEGIN;

INSERT INTO article_content (body, publish_date, is_edited, like_count, dislike_count, author_user_id)
VALUES ('This is the article content', CURRENT_TIMESTAMP, false, 0, 0, 123)
RETURNING content_id INTO new_content_id;


INSERT INTO articles (content_id, article_title, thumbnail_url)
VALUES (new_content_id, 'New Article Title', 'thumbnail.jpg')
RETURNING article_id INTO new_article_id;


INSERT INTO article_tags (article_id, tag_id)
VALUES (new_article_id, 456);

COMMIT;





------TRAN 02------

BEGIN;

INSERT INTO comment_content (body, publish_date, is_edited, like_count, dislike_count, author_user_id)
VALUES ('Este é o conteúdo do comentário', CURRENT_TIMESTAMP, false, 0, 0, 789)
RETURNING content_id INTO new_comment_content_id;


INSERT INTO comments (content_id, article_id, parent_comment_id)
VALUES (new_comment_content_id, 123, null)
RETURNING comment_id INTO new_comment_id;

COMMIT;




------TRAN 03------
