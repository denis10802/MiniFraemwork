Простой Фреймворк PHP для Вашего проекта
======================================================
### 1.Компонент QueryBuilder - для создания запросов к вашей базе данных;
### 2.Компонент Flash - для вывода флэш сообщений;
### 3.Компонент Router - для роутинга вашего проекта;
### 4.Компонент Validator - для валидации форм;
 

_**Использование:**_

### _Компонент QueryBuilder_

Для начала создайте экземпляр класса далее выберите нужный вам запрос:

```
<?php

 $database = QueryBuilder::getInstance();
 
 $database->get(string $table,array where = []) : array|false //Извлечение  следующей строки из результирующего набора 
 
          ->getAll(string $table) : array|false Возвращает массив, содержащий все строки результирующего набора    
            
          ->getById(string $table, int $id) : array|false Возвращает массив, находит строку по id 

          ->update(string $table, array $data);Обновляет данные таблицы 

          ->delete(string $table, int $id);удалет строку по id

          ->count(string $table);подсчет количества строк в таблице

          ->insert(string $table, array $data); обновляет данные полей, выполняет команду INSERT      
 ?>
```
### _Компонент Flash_

Используется для записи и вывода флэш сообщений 

```$xslt
<?php

Flash::putMessage(string $name,string $message);// для записи флэщ сообщения

Flash::showMessage(string $name);// для вывода флэш сообщия

Flash::delete(string $name);// для удаления флэш сообщения

Flash::exists(string $name);// проверяет существует ли флэш сообщение с именем $name

?>
```

### _Компонент Router_

Используется для веб-маршрутизации запросов

Для начала работы пропишите в конфигурационом файле src.php пути и заголовки к вашим файлам
```$xslt
<?php
return [
    '/' => "../page.php",
    "/about" =>'test.php',
];
?>
```
Далее настройте свой сервер: 
```$xslt
// для apache создайте файл .htaccess на одном уровне с index.php, пропишите туда вот этот код:

Options +FollowSymLinks -Indexes
RewriteEngine On

RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

//для Nginx:

location / {
    try_files $uri $uri/ /index.php?$args;
}
```
В файле index.php подключите класс, и можете запускать методом `run`
```$xslt
<?php
require 'Router.php';

Router::run(string $errorRoute:'404.php');// для того что бы маршрутизатор заработал введите в поле аргумента путь к вашей странице 404 ошибки 
?>
```

### _Компонент Validator_

Предназначен для валидации полей формы:

для начала работы объявите новый класс,
```$xslt
<?php
$val = new Validator();
```
далее вызывайте метод `check` для начала работы, 1 аргумент принимает $_POST, $_GET, $_FIlES, так же возможно совмещать. 2 аргумент принимает массив с именами ваших полей из формы, и применимые для них правила валидации. Так же ознакомьтесь с правилами валидации. 
```$xslt
$val->check(array $_POST + $_FILES, array [
    'input_name' => [
        'rule' => 'rule_value'        
    ]    
]);
```
для проверки прощла ли валидация используйте следующий метод,
```$xslt
if ($validate->passed()) {
  // ваш код
} else {
```
для вывода ошибок валидации,
```$xslt
foreach ($validate->errors() as $error) {
                echo $error;
        }
    }
?>
```