DROP SCHEMA IF EXISTS lbaw2394 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2394;
SET search_path TO lbaw2394;

------------------------------------------------------------------------------------
------------------------------------- DROP TABLES ----------------------------------
------------------------------------------------------------------------------------



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
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS comment_vote CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS article CASCADE;
DROP TABLE IF EXISTS topicproposal CASCADE;
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
DROP FUNCTION IF EXISTS prevent_duplicate_tag_follow CASCADE;

------------------------------------------------------------------------------------
------------------------------------- TABLES ---------------------------------------
------------------------------------------------------------------------------------

-- Note that plural table names are used to avoid conflicts with reserved words (users).

------- ADMIN --------
CREATE TABLE admin (
    admin_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    user_blocked BOOLEAN DEFAULT FALSE


);

------- USER -------
CREATE TABLE users(
    user_id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    reputation INTEGER DEFAULT 0,
    user_blocked BOOLEAN DEFAULT FALSE,
    number_followers INTEGER DEFAULT 0
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

-- TOPIC PROPOSAL
CREATE TABLE topicproposal (
    topicproposal_id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    date TIMESTAMP NOT NULL,
    accepted BOOLEAN DEFAULT NULL
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

-------- TAG --------
CREATE TABLE tag (
    tag_id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL CONSTRAINT tag_name_uk UNIQUE
);

-------- ARTICLE-TAG --------
CREATE TABLE article_tag (
    article_id INTEGER NOT NULL REFERENCES article (article_id) ON UPDATE CASCADE,
    tag_id INTEGER NOT NULL REFERENCES tag (tag_id) ON UPDATE CASCADE
);

-------- FOLLOW --------
CREATE TABLE follow (
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    tag_id INTEGER NOT NULL REFERENCES tag (tag_id) ON UPDATE CASCADE
);

------- FOLLOWERS -------
CREATE TABLE followers (
    follower_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users (user_id) ON UPDATE CASCADE,
    PRIMARY KEY (follower_id, user_id)
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
            setweight(to_tsvector('simple', NEW.email), 'B')
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

CREATE OR REPLACE FUNCTION adjust_likes_dislikes_and_notification() RETURNS TRIGGER AS $$
BEGIN
    
    IF NEW.is_like THEN
        UPDATE article SET likes = likes + 1 WHERE article_id = NEW.article_id;
    ELSE
        UPDATE article SET dislikes = dislikes + 1 WHERE article_id = NEW.article_id;
    END IF;

    UPDATE users SET reputation = CASE WHEN NEW.is_like THEN reputation + 1 ELSE reputation - 1 END
    WHERE user_id = (SELECT user_id FROM article WHERE article_id = NEW.article_id);

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
    IF OLD.is_like THEN
        UPDATE article SET likes = likes - 1 WHERE article_id = OLD.article_id;
    ELSE
        UPDATE article SET dislikes = dislikes - 1 WHERE article_id = OLD.article_id;
    END IF;

    UPDATE users SET reputation = CASE WHEN OLD.is_like THEN reputation - 1 ELSE reputation + 1 END
    WHERE user_id = (SELECT user_id FROM article WHERE article_id = OLD.article_id);

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
    DELETE FROM favourite WHERE article_id = OLD.article_id;

    DELETE FROM article_vote WHERE article_id = OLD.article_id;

    DELETE FROM article_notification WHERE article_id = OLD.article_id;

    DELETE FROM comment WHERE article_id = OLD.article_id;

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

/*CREATE OR REPLACE FUNCTION create_comment_notification() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO notification (date, viewed, notified_user, emitter_user)
    VALUES (NOW(), FALSE, (SELECT user_id FROM article WHERE article_id = NEW.article_id), NEW.user_id);


    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER create_comment_notification
AFTER INSERT ON comment
FOR EACH ROW
EXECUTE FUNCTION create_comment_notification();*/


------TRIGGER 07------

CREATE OR REPLACE FUNCTION prevent_multiple_likes_on_article()
RETURNS TRIGGER AS $$
BEGIN
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

CREATE OR REPLACE FUNCTION prevent_duplicate_tag_follow()
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM follow WHERE user_id = NEW.user_id AND tag_id = NEW.tag_id) THEN
        RAISE EXCEPTION 'You are already following this topic';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_duplicate_tag_follow
BEFORE INSERT ON follow
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_tag_follow();



------------------------------------------------------------------------------------
------------------------------------- TRANSACTIONS ---------------------------------
------------------------------------------------------------------------------------


-- Populate

INSERT INTO admin (name, email, password) 
VALUES
    ('John Doe', 'johndoe@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Jane Smith', 'janesmith@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Michael Johnson', 'michaeljohnson@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Emily Wilson', 'emilywilson@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('David Brown', 'davidbrown@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W');


INSERT INTO users (email, name, password, reputation)
VALUES
    ('alice@example.com', 'Alice Johnson', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 100),
    ('bob@example.com', 'Bob Smith', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 150),
    ('charlie@example.com', 'Charlie Davis', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 200),
    ('david@example.com', 'David Wilson', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 50),
    ('eva@example.com', 'Eva Martin', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 300),
    ('frank@example.com', 'Frank Harris', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75),
    ('grace@example.com', 'Grace Lee', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 250),
    ('helen@example.com', 'Helen White', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 30),
    ('ian@example.com', 'Ian Clark', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 180),
    ('judy@example.com', 'Judy Brown', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90);


INSERT INTO ban (user_id, admin_id) 
VALUES
    (1, 1),
    (2, 2);

INSERT INTO topic (name) VALUES
('Technology'),
('Science'),
('Sports'),
('Art'),
('Travel');

INSERT INTO article (name, description, date, topic_id, user_id)
VALUES
    ('Tech News', 'The global rollout of 5G networks is accelerating, offering faster and more reliable connectivity. The technology''s impact extends beyond smartphones, influencing industries like healthcare, manufacturing, and smart cities.', '2023-10-21 10:00:00', 1, 1),
    ('Science Breakthrough', 'The rapid development and deployment of COVID-19 vaccines showcase the power of scientific collaboration. mRNA vaccine technology, exemplified by vaccines like Pfizer-BioNTech and Moderna, has proven to be highly effective.', '2023-10-21 11:00:00', 2, 2),
    ('Sports Highlights', 'Djokovic pursued a historic calendar-year Grand Slam in tennis, reaching the finals of all four major tournaments. However, he narrowly missed the achievement, losing in the US Open final.
', '2023-10-21 12:00:00', 3, 3),
    ('Music Reviews', '"Losing My Religion" by R.E.M. is a masterpiece that encapsulates the essence of 1990s alternative rock. The haunting mandolin riff and Michael Stipe''s soulful vocals create a uniquely emotional and introspective atmosphere. The enigmatic lyrics, open to interpretation, add a layer of depth that invites listeners to connect with the song on a personal level. The music video''s surreal visuals enhance the overall experience, making it an iconic piece of 1990s music culture. The song''s enduring popularity is a testament to its timeless quality, and it remains a favorite for those seeking a blend of poignant lyrics and evocative musicality in the alternative rock genre.', '2023-10-21 13:00:00', 4, 4),
    ('Travel Destinations', '
Embark on a journey to three of the world''s most captivating destinations. In Santorini, Greece, experience the magic of iconic white-washed buildings clinging to cliffs, overlooking the mesmerizing Aegean Sea. The charm of Oia''s narrow streets and the allure of black sand beaches create an unforgettable Greek island escape.

Kyoto, Japan, beckons with its harmonious blend of ancient traditions and modern innovation. Wander through streets adorned with cherry blossoms, explore historic temples, and feel the cultural pulse of Gion''s geisha district. Kyoto is a captivating city that unfolds a rich tapestry of Japanese heritage.

For those seeking adventure amid stunning landscapes, Queenstown, New Zealand, offers the perfect blend. Nestled within the Southern Alps and alongside Lake Wakatipu, Queenstown boasts a backdrop of snow-capped peaks. This adventure haven invites thrill-seekers to bungee jump, hike, and explore Fiordland National Park, all while embracing the serene beauty of the surroundings. These three destinations promise an immersive and diverse travel experience, blending history, culture, and natural wonders for an unforgettable journey.', '2023-10-21 14:00:00', 5, 5),
    ('The Future of AI', 'AI''s evolution will see advancements in machine learning techniques, enabling systems to learn and adapt more effectively. Deep learning and reinforcement learning will continue to push the boundaries of what AI can achieve.', '2023-10-21 15:00:00', 1, 6),
    ('Football Match Analysis', 'In an electrifying football match bathed in sunlight, Cambridge United clashed with Salford in a battle of tactical prowess and skillful play. The first half saw Cambridge United dominating possession, orchestrating fluid passing sequences that kept Salford''s defense on their toes. However, it was Salford that struck first, capitalizing on a counterattack to secure an early lead.

The second half witnessed a spirited comeback from Cambridge United, with their star forward showcasing dazzling footwork to equalize. The match intensified as both teams relentlessly pursued a winning goal. Salford''s goalkeeper made a series of outstanding saves, denying Cambridge United''s potent attacks. The turning point came when Cambridge United, through a perfectly executed set piece, secured a late lead.

In the dying moments, Salford mounted a dramatic comeback, with a powerful long-range shot finding the net, leveling the score once again. The match concluded in a breathtaking draw, leaving fans on the edge of their seats and celebrating the brilliance of both Cambridge United and Salford. This pulsating encounter will be remembered for its dynamic plays, strategic maneuvers, and the sheer excitement that echoed through the stadium.
', '2023-10-21 16:00:00', 3, 7),
    ('Hidden Gems of Europe', 'Tucked away in the Rila Mountains, the Rila Monastery is a UNESCO World Heritage site and a symbol of Bulgarian cultural and spiritual heritage. The monastery''s intricate frescoes, wooden balconies, and mountainous backdrop create a picturesque setting. It''s a serene escape from the bustling cities, offering a glimpse into Bulgaria''s rich history and Orthodox Christian traditions.', '2023-10-21 17:00:00', 5, 8),
    ('Cybersecurity Best Practices', 'Implementing robust cybersecurity is crucial for protecting sensitive data. This involves using strong, unique passwords with two-factor authentication. Regular software updates and secure Wi-Fi practices are essential to prevent vulnerabilities. Employee education, data encryption, and regular backups add layers of defense. Endpoint protection and incident response plans are crucial for swift and effective threat management. Access control principles and physical security measures limit unauthorized access. Ongoing monitoring and assessments of third-party vendors ensure comprehensive cybersecurity. These practices collectively form a strong defense against evolving cyber threats.', '2023-10-21 18:00:00', 1, 9),
    ('Upcoming Album Releases', '"Ephemeral Echoes" is the highly anticipated upcoming album from the visionary ambient electronica artist, Celestia Nova. Transporting listeners into a dreamlike realm, the album weaves intricate sonic landscapes with ethereal melodies and pulsating rhythms. Celestia Nova, known for her mesmerizing soundscapes, invites audiences to embark on a cosmic journey where time seems to stand still.

Each track on "Ephemeral Echoes" is a sonic exploration, creating a seamless fusion of electronic beats and otherworldly textures. With influences ranging from deep space to the depths of the ocean, the album is a sonic tapestry that unfolds, revealing new layers with each listen. The release promises to be a meditative and immersive experience, inviting listeners to escape into a realm of limitless imagination.

Stay tuned for the release of "Ephemeral Echoes" in the summer of 2024, where Celestia Nova invites you to immerse yourself in a musical odyssey that transcends boundaries and resonates with the soul.','2023-10-21 19:00:00', 4, 10);

INSERT INTO comment (text, date, likes, dislikes, user_id, article_id)
VALUES
    ('Great article!', CURRENT_TIMESTAMP, 0, 0, 1, 1),
    ('I found this very interesting', CURRENT_TIMESTAMP, 0, 0, 2, 1),
    ('Good review!', CURRENT_TIMESTAMP, 0, 0, 4, 2),
    ('Sports are awesome!', CURRENT_TIMESTAMP, 0, 0, 3, 3),
    ('I completely agree with the author.', CURRENT_TIMESTAMP, 0, 0, 6, 4),
    ('I want to visit this place!', CURRENT_TIMESTAMP, 0, 0, 5, 5),
    ('The topic is very relevant in today''s world.', CURRENT_TIMESTAMP, 0, 0, 7, 5),
    ('I enjoyed reading this article! Well done.', CURRENT_TIMESTAMP, 0, 0, 8, 5),
    ('The author has done a fantastic job!', CURRENT_TIMESTAMP, 0, 0, 9, 6),
    ('I didn''t find this article very helpful.', CURRENT_TIMESTAMP, 0, 0, 10, 6);


INSERT INTO tag (name) VALUES
    ('tech'),
    ('footbal'),
    ('vacation'),
    ('gaming'),
    ('research'),
    ('expositions');

INSERT INTO article_tag (article_id, tag_id) VALUES
    (1, 1),
    (2, 5),
    (3, 2),
    (5, 3);


INSERT INTO follow (user_id, tag_id) 
VALUES
    (1, 1);



INSERT INTO article_vote (is_like, article_id, user_id)
VALUES
    (TRUE, 1, 2),
    (TRUE, 1, 4),
    (TRUE, 1, 3),
    (FALSE, 3, 4),
    (TRUE, 4, 5),
    (FALSE, 5, 6),
    (TRUE, 6, 7),
    (TRUE, 6, 1),
    (FALSE, 7, 8),
    (TRUE, 8, 9),
    (FALSE, 9, 10),
    (TRUE, 10, 1);

INSERT INTO favourite (article_id, user_id)
VALUES
    
    (4, 3);

INSERT INTO notification (date, viewed, notified_user, emitter_user)
VALUES
    ('2023-10-21 08:00:00', FALSE, 1, 2),
    ('2023-10-20 14:30:00', TRUE, 2, 3),
    ('2023-10-19 10:15:00', FALSE, 3, 4),
    ('2023-10-18 17:45:00', TRUE, 4, 5);

INSERT INTO comment_notification (notification_id, comment_id) VALUES
    (1, 1),  
    (2, 2),  
    (3, 3);  


INSERT INTO article_notification (notification_id, article_id) VALUES
    (1, 1),  
    (2, 2), 
    (3, 3);  

INSERT INTO like_post (notification_id, user_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO dislike_post (notification_id, user_id) VALUES
    (1, 2),
    (2, 3),
    (3, 4);


INSERT INTO like_comment (notification_id, user_id) VALUES
    (1, 3),
    (2, 4),
    (3, 5);


INSERT INTO dislike_comment (notification_id, user_id) VALUES
    (1, 4),
    (2, 5),
    (3, 6);

INSERT INTO topicproposal (name, user_id, date) VALUES
('Government', 1, CURRENT_TIMESTAMP),
('Health', 2, CURRENT_TIMESTAMP),
('Business', 3, CURRENT_TIMESTAMP),
('Education', 4, CURRENT_TIMESTAMP),
('Entertainment', 5, CURRENT_TIMESTAMP);
