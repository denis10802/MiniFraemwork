# **Простой Фреймворк PHP для Вашего проекта**

### 1.Компонент QueryBuilder - для создания запросов к вашей базе данных;
### 2.Компонент Flash - для вывода флэш сообщений;
### 3.Компонент Router - для роутинга вашего проекта;
### 4.Компонент Validator - для валидации форм;
 

_**Использование:**_

### _Компонент QueryBuilder_

Для начала создайте экземпляр класса далее выберите нужный вам запрос:

`<?php`
 `$database = QueryBuilder::getInstance();`
 
 `$database->get(string $table,array where = []) : array|false Извлечение  следующей строки из результирующего набора`

          ->getAll(string $table) : array|false Возвращает массив, содержащий все строки результирующего набора                
          ->getById(string $table ,int $id) : array|false Возвращает массив, находит даные по id 
          ->create(string $table,array $data); выполняет INSERT        
 ?>`
