# asterios-bot

Парсер убийства РБ с RSS фида на сайте Астериоса. Обновление раз в 7 секунд. Так же добавлен функционал подсчета остатка времени респауна, будет 2 оповещения, одно за 3ч до окончания респа, второе за 1,5ч. Эта фича сделана специально для ленивого фарма, когда ждать вообще лень, а 1,5-3ч подождать можно. Данная фича сейчас в тестовом режиме!

### Каналы по РБ для сервера x5

https://t.me/asteriosx5rb - сабовые, Кабрио и ТоИ

https://t.me/asteriosX5keyRB - все остальные с фида

### Каналы по РБ для сервера x7

https://t.me/asteriosx7rb  - сабовые, Кабрио и ТоИ

https://t.me/asteriosX7keyRB- все остальные с фида

## Tech info

- Crontab config

```bash
 * * * * * php /home/ubuntu/asterios-bot/check.php >> /home/ubuntu/asterios.bot.check.log 2>&1
 * * * * * php /home/ubuntu/asterios-bot/checkx7.php >> /home/ubuntu/asterios.bot.check.log 2>&1
 
 * * * * * php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1
 * * * * * ( sleep 7 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 15 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 23 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 30 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 37 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 45 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 53 ; php /home/ubuntu/asterios-bot/bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )

 * * * * * php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1
 * * * * * ( sleep 7 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 15 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 23 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 30 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 37 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 45 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 53 ; php /home/ubuntu/asterios-bot/botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )

```
- DB dump
```SQL
use asterios;

DROP TABLE IF EXISTS `new_raids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `new_raids` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `server` int(11) NOT NULL,
                             `title` varchar(200) NOT NULL,
                             `description` varchar(200) DEFAULT NULL,
                             `timestamp` varchar(20) NOT NULL,
                             `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `new_raids_server_title_timestamp_uindex` (`server`,`title`,`timestamp`),
                             KEY `new_raids_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
CREATE TABLE `respawn_notification` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`server` INT NOT NULL,
	`title` VARCHAR(200) NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT NOW(),
	`shout` INT DEFAULT '1',
	KEY `respawn_notification_created_at_index` (`created_at`) USING BTREE,
    KEY `respawn_notification_shout_index` (`shout`) USING BTREE,
	PRIMARY KEY (`id`)
);
```
- .env.dist (need create `.env`)
```yaml
TG_API=
DB_HOST=localhost
DB_NAME=asterios
DB_CHARSET=utf8
DB_USERNAME=asterios
DB_PASSWORD=

```
