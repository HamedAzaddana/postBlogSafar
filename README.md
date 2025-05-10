# Step 1
Run the command:
 ```bash
composer install
```
and
set configs in .env file and create init database.

# Step 2
 Run the file:
  ```bash
 php migrate.php
```

# Step 3
Run the command:
 ```bash
php -S localhost:8090 public/index.php
```
and then open localhost:8090/login/  to see login page first
