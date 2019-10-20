# Login System in PHP for course 1DV610

96 % completion of 33 [automated tests](http://csquiz.lnu.se:25083/index.php).

Press [here](https://ab224qr-1dv610-lab-2.herokuapp.com/) to see the live version.

## Installation instructions

### 1. Configure local database

Edit the `LocalSettings.php` in root folder with your preferred values.

```
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

```
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
