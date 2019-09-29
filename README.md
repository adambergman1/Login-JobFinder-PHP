# Login System in PHP for course 1DV610

92 % completion of 33 [automated tests](http://csquiz.lnu.se:25083/index.php).

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

### 2. Configure remote database

Currently configured with jawsDB.

Create a `.env` file in the root folder:

```
JAWSDB_URL='YOUR_MYSQL_REMOTE_CONNECTION_STRING'
```

### 3. Create a database table called `users`

| Column name | Type | Null | Extra |
| ----------- | ----------- | ----------- | ----------- |
| id | int(11) | NOT NULL | AUTO_INCREMENT & PRIMARY_KEY |
| username | varchar(255) | NOT NULL | UNIQUE |
| password | varchar(255) | NOT NULL | --- |
