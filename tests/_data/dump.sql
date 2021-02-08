CREATE DATABASE IF NOT EXISTS test_db;

use test_db;

CREATE TABLE IF NOT EXISTS new_raids
(
    id int auto_increment
    primary key,
    server int not null,
    title varchar(200) not null,
    description varchar(200) null,
    timestamp varchar(20) not null,
    created_at datetime default CURRENT_TIMESTAMP null,
    alarm int default 0 null,
    constraint new_raids_title_timestamp_server_uindex
    unique (title, timestamp, server)
    )
    charset=utf8mb4;


