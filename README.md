# vanilla-php-api

To begin, run the following command to download the project using Git:

```bash
git clone https://github.com/Msalah11/vanilla-php-api.git
```

Next, move into the new project’s folder and install all its dependencies:

```bash
# move into the new folder
cd vanilla-php-api

# install dependencies
composer install
```

Next, edit database credentials from `Config/database.php`:

```sql
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

| Endpoint           | Method | Body                  | Description      |
| ------------------ | ------ | --------------------- | ---------------- |
| api/register       | POST   | name, email, password | Create New User  |
| api/login          | POST   | email, password       | Login to account |
| api/password-reset | POST   | email                 | Reset Password   |

### Lists

| Endpoint            | Method | Body | Description          |
| ------------------- | ------ | ---- | -------------------- |
| api/lists           | GET    |      | Get All Lists        |
| api/lists/{id}      | GET    |      | Get List By ID       |
| api/lists           | POST   | name | Create New List      |
| api/lists/{id}      | PUT    | name | Update List          |
| api/lists           | DELETE | id   | Delete List          |
| api/lists/{id}/item | POST   | name | Add New Item To List |
