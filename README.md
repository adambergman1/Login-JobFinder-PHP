# Job Finder

This application has been developed during the course 1DV610 and is based on a login system and a portal for finding jobs. It is written according to the MVC principle in PHP.

The login system provides the ability to login and register. It has 96 % completion of 33 [automated tests](http://csquiz.lnu.se:25083/index.php).

The Job Finder portal allows users to search for jobs in Sweden based on `keyword` and `city`. Currently, the results are obtained from the [Swedish public employment service](https://arbetsformedlingen.se/).

Press [here](https://ab224qr-1dv610-lab-2.herokuapp.com/) to see the live version.

## Installation instructions

### 1. Configure local database

Edit the `LocalSettings.php` in `authentication` folder with your preferred values.

```php
<?php

namespace login;

class LocalSettings {
    public $DB_HOST = "localhost";
    public $DB_NAME = "1dv610";
    public $DB_USERNAME = "root";
    public $DB_PASSWORD = "root";
}
```

### 2. Get your API key from JobTechDev

Click [here](https://apirequest.jobtechdev.se/)

### 3. Configure remote database

Currently configured with jawsDB.

Create the following dotenv variables:

```
JAWSDB_URL='YOUR_MYSQL_REMOTE_CONNECTION_STRING'
AF_KEY='YOUR_API_KEY'
```

### 4. Configure local API settings for Arbetsförmedlingen

Create a file called `LocalAPIKey.php` inside the folder `application`

```php
<?php

namespace application;

class LocalAPIKey {
    public $API_KEY = 'YOUR_API_KEY';
}
```

### 4. Create a database table called `users`

| Column name | Type | Null | Extra |
| ----------- | ----------- | ----------- | ----------- |
| id | int(11) | NOT NULL | AUTO_INCREMENT & PRIMARY_KEY |
| username | varchar(255) | NOT NULL | UNIQUE |
| password | varchar(255) | NOT NULL | --- |

### 5. Create a database table called `cookies`

| Column name | Type | Null | Extra |
| ----------- | ----------- | ----------- | ----------- |
| id | int(11) | NOT NULL | AUTO_INCREMENT & PRIMARY_KEY |
| username | varchar(255) | NOT NULL | UNIQUE |
| password | varchar(255) | NOT NULL | --- |
