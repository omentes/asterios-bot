# asterios-bot

Парсер убийства РБ с RSS фида на сайте Астериоса. Добавлен функционал подсчета остатка времени респауна, будет 2 оповещения, одно за 3ч до окончания респа, второе за 1,5ч. Эта фича сделана специально для ленивого фарма, когда ждать вообще лень, а 1,5-3ч подождать можно.

### Каналы по РБ для сервера x5

https://t.me/asteriosx5rb - сабовые, Кабрио и ТоИ

https://t.me/asteriosX5keyRB - все остальные с фида

### Каналы по РБ для сервера x7

https://t.me/asteriosx7rb  - сабовые, Кабрио и ТоИ

https://t.me/asteriosX7keyRB - все остальные с фида

### Каналы по РБ для сервера x3

https://t.me/asteriosx3rb  - сабовые, Кабрио и ТоИ

https://t.me/asteriosX3keyRB - все остальные с фида

## Tech info

- DB dump
```SQL
CREATE DATABASE IF NOT EXISTS asterios;

use asterios;

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

CREATE index new_raids_created_at_index
	ON new_raids (created_at);

```
- .env.dist (need create `.env`)
```yaml
SERVICE_ROLE=prod
TG_API=YOUR_API_TOKEN
TG_ADMIN_ID=YOUR_USER_ID
TG_NAME=AsteriosRBbot
DB_HOST=mysql
DB_NAME=asterios
DB_CHARSET=utf8
DB_USERNAME=root
DB_PASSWORD=password
LOG_PATH=/app/logs/
DB_NAME_TEST=test
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_DB=0
SILENT_MODE=true
FILLER_MODE=true
```
