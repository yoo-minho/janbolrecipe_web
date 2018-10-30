CREATE TABLE recipe_list(
    id INT(11) NOT NULL AUTO_INCREMENT,
    class VARCHAR(20) NOT NULL,
    recipe VARCHAR(20) NOT NULL,
    meal TINYINT(2) NOT NULL,
    video_code VARCHAR(20) NULL,
    seasoning VARCHAR(20) NULL,
    grocery0 VARCHAR(20) NULL, gram0 SMALLINT(5) NULL,
    grocery1 VARCHAR(20) NULL, gram1 SMALLINT(5) NULL,
    grocery2 VARCHAR(20) NULL, gram2 SMALLINT(5) NULL,
    grocery3 VARCHAR(20) NULL, gram3 SMALLINT(5) NULL,
    grocery4 VARCHAR(20) NULL, gram4 SMALLINT(5) NULL,
    grocery5 VARCHAR(20) NULL, gram5 SMALLINT(5) NULL,
    PRIMARY KEY(id));

CREATE TABLE shopping_list(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(20) NOT NULL,
    shop VARCHAR(20) NULL,
    class0 VARCHAR(20) NULL, recipe0 VARCHAR(20) NULL, meal0 TINYINT(2) NULL,
    class1 VARCHAR(20) NULL, recipe1 VARCHAR(20) NULL, meal1 TINYINT(2) NULL,
    class2 VARCHAR(20) NULL, recipe2 VARCHAR(20) NULL, meal2 TINYINT(2) NULL,
    class3 VARCHAR(20) NULL, recipe3 VARCHAR(20) NULL, meal3 TINYINT(2) NULL,
    class4 VARCHAR(20) NULL, recipe4 VARCHAR(20) NULL, meal4 TINYINT(2) NULL,
    PRIMARY KEY(id));

CREATE TABLE payment_list(
    id INT(11) NOT NULL AUTO_INCREMENT,
    nick VARCHAR(20) NOT NULL,
    name VARCHAR(20) NOT NULL,
    m_uid VARCHAR(30) NULL,
    price VARCHAR(20) NULL,
    list_number INT(11) NULL,
    list_text TEXT NULL,
    status VARCHAR(20) NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id));

CREATE TABLE grocery_list(
    id INT(11) NOT NULL AUTO_INCREMENT,
    grocery_name VARCHAR(20) NOT NULL,
    price_100g SMALLINT(5) NULL,
    reference VARCHAR(20) NULL,
    gram_unit SMALLINT(5) NULL,
    unit VARCHAR(10) NULL,
    calorie_100g SMALLINT(5) NULL,
    etc VARCHAR(20) NULL,
    PRIMARY KEY(id));

CREATE TABLE user_list(
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_email VARCHAR(30) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_nickname VARCHAR(10) NOT NULL,
    user_phonenumber VARCHAR(11) NOT NULL,
    PRIMARY KEY(user_id));

CREATE TABLE chat_room_list (
  chat_room_id int(11) NOT NULL AUTO_INCREMENT,
  chat_name varchar(100) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(chat_room_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE chat (
  message_id int(11) NOT NULL AUTO_INCREMENT,
  chat_room_id int(11) NOT NULL,
  user_id VARCHAR(10) NOT NULL,
  message text NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(message_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
