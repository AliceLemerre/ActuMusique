DROP TABLE IF EXISTS esgi_comment;
DROP TABLE IF EXISTS esgi_post;
DROP TABLE IF EXISTS esgi_user;
DROP TABLE IF EXISTS esgi_media;


CREATE TABLE esgi_user(
        user_id SERIAL PRIMARY KEY,
        email varchar(30) NOT NULL,
        password varchar(255) NOT NULL,
        username varchar(25) NOT NULL,
        emailConfirmation BOOLEAN NOT NULL,
        resetPassword BOOLEAN NULL,
        verificationCode varchar(13) NOT NULL,
        role int NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        isDeleted BOOLEAN DEFAULT false
    );

CREATE TABLE esgi_post(
        id SERIAL PRIMARY KEY,
        title varchar(30) NOT NULL,
        category int NOT NULL,
        date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        place varchar(30) NOT NULL,
        city varchar(30) NOT NULL,
        content TEXT NOT NULL,
        image varchar(255) NOT NULL,
        userid int NOT NULL,
        views int NOT NULL,
        likes int NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL,
        CONSTRAINT userid FOREIGN KEY(userid) REFERENCES esgi_user(id)
    );


CREATE TABLE esgi_comment(
    id SERIAL PRIMARY KEY,
    postid INT NOT NULL,
    userid INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    validity INT NOT NULL DEFAULT 0,
    CONSTRAINT postid FOREIGN KEY(postid) REFERENCES esgi_post(id) ON DELETE CASCADE,
    CONSTRAINT userid FOREIGN KEY(userid) REFERENCES esgi_user(id) ON DELETE CASCADE
);


CREATE TABLE esgi_media (
    id SERIAL PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    userid INT,
    postid INT,
    CONSTRAINT fk_media_user FOREIGN KEY (userid) REFERENCES esgi_user(id) ON DELETE CASCADE,
    CONSTRAINT fk_media_post FOREIGN KEY (postid) REFERENCES esgi_post(id) ON DELETE CASCADE
);

