# App database instructions

```
CREATE DATABASE consumer_project_dev CHARACTER SET utf8mb4 COLLATE "utf8mb4_unicode_ci";
```

```
CREATE USER app IDENTIFIED BY 'app';
```

```
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES ON consumer_project_dev.* TO 'app'@'localhost' IDENTIFIED BY 'app';
FLUSH PRIVILEGES;
```