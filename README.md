# asterios-bot

Парсер убийства РБ с RSS фида на сайте Астериоса и сохраняет в базу данных.
Имея эту информацию бот публикует следующие виды сообщений в каналы:
- начало респа РБ
- осталось 3ч до максимального респа
- осталось 1,5ч до максимального респа
- смерть РБ (сундук стоит 2 минуты, вполне можно успеть зайти с релога и поговорить с ящиком)

Так же бот имеет возможность посмотреть статус респауна в конкретный момент

### Ссылки на бота и каналы в Телеграм 

- https://t.me/AsteriosRBBot - бот
- https://t.me/asteriosx5rb - x5 сабовые, Кабрио и ТоИ
- https://t.me/asteriosX5keyRB - x5 все остальные с фида
- https://t.me/asteriosx7rb  - x7 сабовые, Кабрио и ТоИ
- https://t.me/asteriosX7keyRB - x7 все остальные с фида
- https://t.me/asteriosx3rb  - x3 сабовые, Кабрио и ТоИ
- https://t.me/asteriosX3keyRB - x3 все остальные с фида

### Ссылки на html (без телеграма) и svg (версия для подписи на форумах)

- https://asterios.webhook.pp.ua/?html&server=x3 - html для x3 сабовые, Кабрио и ТоИ
- https://asterios.webhook.pp.ua/?html&server=x5 - html для x5 сабовые, Кабрио и ТоИ
- https://asterios.webhook.pp.ua/?html&server=x7 - html для x7 сабовые, Кабрио и ТоИ
- https://asterios.webhook.pp.ua/?color=dark&server=x3 - svg (темный фон) для x3 сабовые, Кабрио и ТоИ
- https://asterios.webhook.pp.ua/?color=dark&server=x5 - svg (темный фон) для x5 сабовые, Кабрио и ТоИ
- https://asterios.webhook.pp.ua/?color=dark&server=x7 - svg (темный фон) для x7 сабовые, Кабрио и ТоИ

## Техническая документация

Данный проект работает в `docker` и имеет быстрый набор команд в `Makefile`. Этот проект не может работать самостоятельно, так требует окружения в виде MySQL, Redis, Prometheus, Grafana. Если вы хотите поднять проект самостоятельно, вам требуется следующие шаги:
1. Скачать и устновить окружение
```bash
git clone https://github.com/omentes/bots-environment.git
cd bots-environment
echo "DB_PASSWORD=password\n" > .env
make up
```
2. Скачать и установить самого бота
```bash
git clone https://github.com/omentes/asterios-bot.git
cd asterios-bot
make build
```
3. Создать файл `.env` и вписать туда свои токен от телеграм и свой user_id
```bash
cat .env.dist > .env
```
4. Запустить контейнеры докера
```bash
make up
```
5. Проверить статус воркеров, остановить, снова запустить
```bash
make worker-status
make worker-stop-all
make worker-start-all
```

### Расширение функционала и тестирование

Вы можете добавить свои фичи, создавайте пулл реквесты. По возможности покрывайте сложный код тестами, тут настроено Github Actions, который триггернется при ПР в мастер.

Так же тесты можно запускать локально. Вы папке tests/_data вы можете найти dump.sql для тестовой бд.

Запустить все тесты:
```bash
make test
```
Запустить один тест:
```bash
 make test-run tests/unit/RepositoryTest.php
```
