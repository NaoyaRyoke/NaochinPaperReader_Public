-- ユーザーの情報を保存
-- これを元にログインしたりする
-- パーミッションは[admin, develop, viewer]
create table users(
    id int auto_increment primary key,
    username varchar(50) not null,
    email varchar(100) not null,
    password varchar(255) not null,
    permission varchar(50) not null,
    affiliation varchar(50)
);

create table papers(
    id int auto_increment primary key,
    user_id int not null,
    title varchar(255) not null,
    abstract MEDIUMTEXT not null,
    content MEDIUMTEXT not null,
    view_flag bool default true 
);

create table search_term_translator(
    id int auto_increment primary key,
    abbreviation varchar(255) not null,
    expansion varchar(255) not null
);

create table paper_authers(
    id int auto_increment primary key,
    paper_id int not null,
    user_id int not null,
    auther_name varchar(255) not null
);

create table paper_comments(
    id int auto_increment primary key,
    paper_id int not null,
    user_id int not null,
    parent_id int not null,
    comment MEDIUMTEXT,
    anchor_node TEXT not null,
    anchor_offset int not null,
    focus_node TEXT not null,
    focus_offset int not null
);
