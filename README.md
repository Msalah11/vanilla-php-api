# vanilla-php-api

To begin, run the following command to download the project using Git:

```
git clone https://github.com/Msalah11/vanilla-php-api.git
```

Next, move into the new project’s folder and install all its dependencies:
```
// move into the new folder
cd vanilla-php-api

//install dependencies
composer install
```
Next, edit database credentials from `Config/database.php`:
```
'mysql' => [
    'name' => '', // Database Name
    'username' => '', // Database Username
    'password' => '', // Database Password
    'connection' => '', // Database Connection
]
```

Next, migrate the database tables by visiting install URL:
```
http://YOURSITEURL/install
```

# API Endpoints
### Auth
| Endpoint  | Method | Body | Description |
| ------------- | ------------- | ------------- | ------------- |
| api/register  | POST  | name, email, password | Create New User
| api/login  | POST  | email, password | Login to account
| api/password-reset  | POST | email | Rest Password

### Lists

| Endpoint  | Method | Body | Description |
| ------------- | ------------- | ------------- | ------------- |
| api/lists  | POST  | name | Create New List
| api/lists  | PUT  | name, id | Update List
| api/lists  | DELETE  | id | Delete List
| api/lists/items  | POST  | name, list_id | Add New Item To List
