INSERT INTO admin (name, email, password) 
VALUES
    ('John Doe', 'johndoe@example.com', 'adminpass1'),
    ('Jane Smith', 'janesmith@example.com', 'adminpass2'),
    ('Michael Johnson', 'michaeljohnson@example.com', 'adminpass3'),
    ('Emily Wilson', 'emilywilson@example.com', 'adminpass4'),
    ('David Brown', 'davidbrown@example.com', 'adminpass5');


INSERT INTO users (email, name, password, reputation)
VALUES
    ('alice@example.com', 'Alice Johnson', 'password1', 100),
    ('bob@example.com', 'Bob Smith', 'password2', 150),
    ('charlie@example.com', 'Charlie Davis', 'password3', 200),
    ('david@example.com', 'David Wilson', 'password4', 50),
    ('eva@example.com', 'Eva Martin', 'password5', 300),
    ('frank@example.com', 'Frank Harris', 'password6', 75),
    ('grace@example.com', 'Grace Lee', 'password7', 250),
    ('helen@example.com', 'Helen White', 'password8', 30),
    ('ian@example.com', 'Ian Clark', 'password9', 180),
    ('judy@example.com', 'Judy Brown', 'password10', 90);


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
    ('Tech News', 'Latest tech updates', '2023-10-21 10:00:00', 1, 1),
    ('Science Breakthrough', 'Exciting scientific discoveries', '2023-10-21 11:00:00', 2, 2),
    ('Sports Highlights', 'Recap of the week''s sports events', '2023-10-21 12:00:00', 3, 3),
    ('Music Reviews', 'Latest album reviews', '2023-10-21 13:00:00', 4, 4),
    ('Travel Destinations', 'Explore the world', '2023-10-21 14:00:00', 5, 5),
    ('The Future of AI', 'Exploring the impact of artificial intelligence', '2023-10-21 15:00:00', 1, 6),
    ('Football Match Analysis', 'In-depth review of the latest game', '2023-10-21 16:00:00', 3, 7),
    ('Hidden Gems of Europe', 'Exploring lesser-known travel destinations', '2023-10-21 17:00:00', 5, 8),
    ('Cybersecurity Best Practices', 'Protecting your online identity', '2023-10-21 18:00:00', 1, 9),
    ('Upcoming Album Releases', 'Anticipating new music releases','2023-10-21 19:00:00', 4, 10);

INSERT INTO comment (text, date, likes, dislikes, user_id, article_id)
VALUES
    ('Great article!', CURRENT_TIMESTAMP, 0, 0, 1, 1),
    ('I found this very interesting', CURRENT_TIMESTAMP, 5, 1, 2, 1),
    ('Good review!', CURRENT_TIMESTAMP, 0, 0, 4, 2),
    ('Sports are awesome!', CURRENT_TIMESTAMP, 0, 0, 3, 3),
    ('I completely agree with the author.', CURRENT_TIMESTAMP, 0, 0, 6, 4),
    ('I want to visit this place!', CURRENT_TIMESTAMP, 0, 0, 5, 5),
    ('The topic is very relevant in today''s world.', CURRENT_TIMESTAMP, 0, 0, 7, 5),
    ('I enjoyed reading this article! Well done.', CURRENT_TIMESTAMP, 0, 0, 8, 5),
    ('The author has done a fantastic job!', CURRENT_TIMESTAMP, 0, 0, 9, 6),
    ('I didn''t find this article very helpful.', CURRENT_TIMESTAMP, 0, 0, 10, 6);




INSERT INTO follow (user_id, topic_id) 
VALUES
    (1, 1), 
    (2, 2), 
    (3, 3),
    (4, 4),  
    (5, 5);  


INSERT INTO article_vote (is_like, article_id, user_id)
VALUES
    (TRUE, 1, 2),
    (TRUE, 2, 3),
    (FALSE, 3, 4),
    (TRUE, 4, 5),
    (FALSE, 5, 6),
    (TRUE, 6, 7),
    (FALSE, 7, 8),
    (TRUE, 8, 9),
    (FALSE, 9, 10),
    (TRUE, 10, 1);

INSERT INTO favourite (article_id, user_id)
VALUES
    (1, 1),
    (2, 1),
    (3, 2),
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



INSERT INTO report (description, date) VALUES
    ('Data security breach incident', '2023-10-22 11:15:00'),
    ('Quality control audit report', '2023-10-23 14:45:00'),
    ('Customer service feedback analysis', '2023-10-24 09:30:00'),
    ('Website performance evaluation', '2023-10-25 15:00:00'),
    ('Product defects analysis', '2023-10-26 14:30:00'),
    ('Financial expense review', '2023-10-27 10:45:00');
    
INSERT INTO comment_report (comment_id, report_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO article_report (article_id, report_id) VALUES
    (4, 4),
    (5, 5),
    (6, 6);


