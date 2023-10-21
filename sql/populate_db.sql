INSERT INTO admin (name, email, password) 
VALUES
    ('Admin1', 'admin1@example.com', 'password1'),
    ('Admin2', 'admin2@example.com', 'password2'),
    ('Admin3', 'admin3@example.com', 'password3'),
    ('Admin4', 'admin4@example.com', 'password4'),
    ('Admin5', 'admin5@example.com', 'password5');


INSERT INTO ban (user_id, admin_id) 
VALUES
    (1, 1),
    (2, 2);


INSERT INTO users (email, name, password, reputation)
VALUES
    ('user1@example.com', 'User1', 'password1', 100),
    ('user2@example.com', 'User2', 'password2', 150),
    ('user3@example.com', 'User3', 'password3', 200),
    ('user4@example.com', 'User4', 'password4', 50),
    ('user5@example.com', 'User5', 'password5', 300),
    ('user6@example.com', 'User6', 'password6', 75),
    ('user7@example.com', 'User7', 'password7', 250),
    ('user8@example.com', 'User8', 'password8', 30),
    ('user9@example.com', 'User9', 'password9', 180),
    ('user10@example.com', 'User10', 'password10', 90);


INSERT INTO comment (text, date, likes, dislikes, user_id, article_id)
VALUES
    ('This is a comment 1', CURRENT_TIMESTAMP, 10, 2, 1, 1),
    ('This is a comment 2', CURRENT_TIMESTAMP, 5, 1, 2, 1),
    ('This is a comment 3', CURRENT_TIMESTAMP, 12, 0, 3, 2),
    ('This is a comment 4', CURRENT_TIMESTAMP, 8, 3, 4, 2),
    ('This is a comment 5', CURRENT_TIMESTAMP, 15, 1, 5, 3),
    ('This is a comment 6', CURRENT_TIMESTAMP, 3, 0, 6, 4),
    ('This is a comment 7', CURRENT_TIMESTAMP, 7, 4, 7, 5),
    ('This is a comment 8', CURRENT_TIMESTAMP, 2, 0, 8, 5),
    ('This is a comment 9', CURRENT_TIMESTAMP, 6, 1, 9, 6),
    ('This is a comment 10',CURRENT_TIMESTAMP, 4, 2, 10, 6);


INSERT INTO topic (name) VALUES
    ('Technology'),
    ('Science'),
    ('Sports'),
    ('Art'),
    ('Travel');

INSERT INTO follow (user_id, topic_id) 
VALUES
    (1, 1),  -- User 1 follows Technology
    (2, 2),  -- User 2 follows Science
    (3, 3),  -- User 3 follows Sports
    (4, 4),  -- User 4 follows Art
    (5, 5);  -- User 5 follows Travel

INSERT INTO article (name, description, date, topic_id, user_id)
VALUES
    ('Article 1', 'Description for Article 1', '2023-10-21 10:00:00', 1, 1),
    ('Article 2', 'Description for Article 2', '2023-10-21 11:00:00', 2, 2),
    ('Article 3', 'Description for Article 3', '2023-10-21 12:00:00', 1, 3),
    ('Article 4', 'Description for Article 4', '2023-10-21 13:00:00', 2, 4),
    ('Article 5', 'Description for Article 5', '2023-10-21 14:00:00', 1, 5),
    ('Article 6', 'Description for Article 6', '2023-10-21 15:00:00', 2, 6),
    ('Article 7', 'Description for Article 7', '2023-10-21 16:00:00', 1, 7),
    ('Article 8', 'Description for Article 8', '2023-10-21 17:00:00', 2, 8),
    ('Article 9', 'Description for Article 9', '2023-10-21 18:00:00', 1, 9),
    ('Article 10','Description for Article 10','2023-10-21 19:00:00', 2, 10);

INSERT INTO article_vote (like, article_id, user_id)
VALUES
    (TRUE, 1, 1),
    (TRUE, 2, 2),
    (FALSE, 3, 3),
    (TRUE, 4, 4),
    (FALSE, 5, 5),
    (TRUE, 6, 6),
    (FALSE, 7, 7),
    (TRUE, 8, 8),
    (FALSE, 9, 9),
    (TRUE, 10, 10);

INSERT INTO favourite (article_id, user_id)
VALUES
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 3);

INSERT INTO notification (date, viewed, user_id)
VALUES
    ('2023-10-21 08:00:00', FALSE, 1),
    ('2023-10-20 14:30:00', TRUE, 2),
    ('2023-10-19 10:15:00', FALSE, 3),
    ('2023-10-18 17:45:00', TRUE, 4);

INSERT INTO notification (message) VALUES
    ('Notification 1'),
    ('Notification 2'),
    ('Notification 3');

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
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6);

INSERT INTO dislike_post (notification_id, user_id) VALUES
    (1, 2),
    (2, 3),
    (3, 4),
    (4, 5),
    (5, 6),
    (6, 1);

INSERT INTO like_comment (notification_id, user_id) VALUES
    (1, 3),
    (2, 4),
    (3, 5),
    (4, 6),
    (5, 1),
    (6, 2);

INSERT INTO dislike_comment (notification_id, user_id) VALUES
    (1, 4),
    (2, 5),
    (3, 6),
    (4, 1),
    (5, 2),
    (6, 3);

INSERT INTO report (description, date) VALUES
    ('Report 1 Description', '2023-10-21 10:00:00'),
    ('Report 2 Description', '2023-10-22 11:30:00'),
    ('Report 3 Description', '2023-10-23 15:45:00'),
    ('Report 4 Description', '2023-10-24 10:00:00'),
    ('Report 5 Description', '2023-10-25 11:30:00'),
    ('Report 6 Description', '2023-10-26 15:45:00');

INSERT INTO comment_report (comment_id, report_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO article_report (article_id, report_id) VALUES
    (4, 4),
    (5, 5),
    (6, 6);


