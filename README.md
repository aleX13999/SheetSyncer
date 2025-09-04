# Синхронизация данных из БД с таблицей

---

# Инициализация приложения

## Требования

- Установлены Docker и Docker Compose.

## Шаги запуска

1. Клонируйте репозиторий с проектом:

```shell
git clone https://github.com/aleX13999/SheetSyncer.git
cd <папка_проекта>
```

2. Создайте файл окружения `.env` командой:
```shell
cp .env.example .env
```
3. Отредактируйте `.env`, укажите необходимые настройки (под Docker):
```dotenv
NGINX_HOST=127.0.0.1
NGINX_HTTP_PORT=

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=

MYSQL_HOST=127.0.0.1
MYSQL_PORT=
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=
MYSQL_USER=root
MYSQL_PASSWORD=
MYSQL_SERVER_VERSION=8.0
```

4. Запустите контейнеры Docker:

```shell
docker compose up -d
```

5. Установите зависимости composer:

```shell
docker exec -it php-fpm composer install
```

6. Выполните миграции:

```shell
docker exec -it php-fpm php artisan migrate
```

7. Установите npm зависимости и соберите стили
```shell
docker exec -it node npm install 
docker exec -it node npm run build
```

8. Сгенерируйте ключ приложения:

```shell
docker exec -it php-fpm php artisan key:generate
```

---

# Использование

---

### Создание файла

Для начала использования необходимо создать файл csv.
Для этого можно воспользоваться командой [CreateCsvFileCommand](app%2FConsole%2FCommands%2FCreateCsvFileCommand.php)

```shell
docker exec -it php-fpm php artisan csv:create
```

По умолчанию файл создастся в директории storage/app. 
Для дальнейшей работы важно, чтобы путь файла был указан в `.env`

```dotenv
# Рассположение файла csv внутри директории storage
CSV_PATH=app/notes.csv
```

---
### Синхронизация

Так же есть команда, которая запускается через `schedule` и раз в минуту
синхронизирует данные из БД с созданным csv файлом.
Для запуска синхронизации нужно выполнить:

```shell
docker exec -it php-fpm php artisan schedule:work
```

---

### Получение данных из таблицы


#### Реализована консольная команда с прогресс баром, вызвать которую можно выполнив команду:

```shell
docker exec -it php-fpm php artisan sync:get-notes-csv {count?}
```

- `count` - необязательный параметр количества запрашиваемых данных

#### А так же реализован api endpoint:

`http://localhost:8081/api/notes-csv?count=10`

Который возвращает результат в формате:

```json
{
    "data": [
        "id / comment",
        "id / comment"
    ]
}
```

---

### Генерация

Для удобства тестирования и работы реализованы команды генерации сущностей и полного очищения таблицы.
Генерация выполняется фабрикой через очередь и job.

Для генерации необходимо запустить обработку очереди:
```shell
docker exec -it php-fpm php artisan queue:work
```
