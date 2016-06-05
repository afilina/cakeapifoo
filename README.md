# CakePHP Demo for PHP API Foo

## Configuring the server

Apache example

```
<VirtualHost *:80>
    ServerName cakeapi.foo
    DocumentRoot /var/www/cakeapifoo
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory />
        Options FollowSymLinks
        AllowOverride All
    </Directory>
</VirtualHost>
```

## Database

This demo uses an SQLite in-memory database with a couple of records. See config/app.php under Datasources > default >init.

## Accessing the API

From the browser, you can view a list:

```
https://cakeapi.foo/games
https://cakeapi.foo/games?title=battle
```

Specific record:

```
https://cakeapi.foo/games/1
```

To update a record, you can either use something like REST Console to send a PATCH to http://cakeapi.foo/games/1 with the JSON `{"title": "Diablo 3"}` in the body, or try this cURL in the command-line:

```
curl 'http://cakeapi.foo/games/1' -X PATCH -H 'Content-Type: application/json' --data-binary '{"title": "Diablo 3"}' --compressed
```
