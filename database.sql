create schema ITECH3108_30331986_A1;

create table Likes (
    user_id int not null,
    nailpolish_id int not null,
    primary key (user_id, nailpolish_id)
    );

create table Message (
    from_user_id int not null,
    to_user_id int not null,
    datetime datetime not null,
    text varchar(256) not null,
    primary key (to_user_id, from_user_id)
    );

create table NailPolish (
    id int auto_increment
        primary key,
    title varchar(32) not null
    );

create table User (
    id int auto_increment
        primary key,
    username varchar(64) not null,
    name varchar(64) not null,
    email varchar(128) not null,
    password varchar(255) not null,
    profile varchar(128) not null,
    photo_url varchar(128) null
    );

INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (1, 1);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (1, 2);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (2, 3);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (2, 4);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (3, 3);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (3, 5);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (4, 1);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (4, 2);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (5, 4);
INSERT INTO ITECH3108_30331986_A1.Likes (user_id, nailpolish_id)
VALUES (5, 5);

INSERT INTO ITECH3108_30331986_A1.NailPolish (id, title)
VALUES (1, 'red');
INSERT INTO ITECH3108_30331986_A1.NailPolish (id, title)
VALUES (2, 'green');
INSERT INTO ITECH3108_30331986_A1.NailPolish (id, title)
VALUES (3, 'yellow');
INSERT INTO ITECH3108_30331986_A1.NailPolish (id, title)
VALUES (4, 'purple');
INSERT INTO ITECH3108_30331986_A1.NailPolish (id, title)
VALUES (5, 'orange');

INSERT INTO ITECH3108_30331986_A1.User (id, username, name, email, password, profile, photo_url)
VALUES (1, '30331986', 'Ben', 'benjamin.james98@gmail.com',
        '$2y$10$123689133030000999999u1u9Wxj5d6Xwo7iojWJmJWQLut.8Byvi', 'Student at Feduni', null);
INSERT INTO ITECH3108_30331986_A1.User (id, username, name, email, password, profile, photo_url)
VALUES (2, 'harry_potter', 'Harry', 'hpotter@hogwarts.magic',
        '$2y$10$123689133030000999999u1u9Wxj5d6Xwo7iojWJmJWQLut.8Byvi', 'He''s a wizard', null);
INSERT INTO ITECH3108_30331986_A1.User (id, username, name, email, password, profile, photo_url)
VALUES (3, 'ron_weasley', 'Ron', 'rweasley@hogwarts.magic',
        '$2y$10$123689133030000999999u1u9Wxj5d6Xwo7iojWJmJWQLut.8Byvi', 'Also a Wizard', null);
INSERT INTO ITECH3108_30331986_A1.User (id, username, name, email, password, profile, photo_url)
VALUES (4, 'tutor', 'Tut', 'tutor@school.edu', '$2y$10$123689133030000999999u1u9Wxj5d6Xwo7iojWJmJWQLut.8Byvi',
        'Not a doctor', null);
INSERT INTO ITECH3108_30331986_A1.User (id, username, name, email, password, profile, photo_url)
VALUES (5, 'thomas', 'Thomas', 'thomas@the.train.engine',
        '$2y$10$123689133030000999999u1u9Wxj5d6Xwo7iojWJmJWQLut.8Byvi', 'He thinks he can, he thinks he can...', null);