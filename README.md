# Тестовое задание на позицию php разработчика 
# API Documentation 

## To run simply be in the directory with docker-compose.yml and run 
```shell
docker-compose up --build -d
```

 Для всех запросов используйте базовый URL `http://localhost/api/v1/notebook`.

### Получение записок

#### Получить все записки
```shell
curl http://localhost/api/v1/notebook
```

#### Получить записки на определенной странице
```shell
curl http://localhost/api/v1/notebook?page=2&limit=3
```

#### Получить конкретную записку по ID
```shell
curl http://localhost/api/v1/notebook?id=1
```

### Управление пользователями

#### Обновить информацию о пользователе
```shell
curl -X PUT -H "Content-Type: application/json" -d '{"full_name":"Новое Имя","company":"Новая Компания","phone_number":"1334567890","email":"john.de@example.com","birth_date":"1985-05-15","photo":null}' http://localhost/api/v1/users?id=1
```

#### Создать нового пользователя
```shell
curl -X POST -H "Content-Type: application/json" -d '{"full_name":"Новое Имя","company":"Новая Компания","phone_number":"1334567890","email":"john.de@example.com","birth_date":"1985-05-15","photo":null}' http://localhost/api/v1/users
```

#### Удалить пользователя по ID
```shell
curl -X DELETE http://localhost/api/v1/users?id=5
