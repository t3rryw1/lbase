### Instructions

Default log folder is /var/log/
Default logging file name is application.log.
Default log level is logging all.
you may override these behavior by setting global variable / constant
* default_log / DEFAULT_LOG
* log_level / LOG_LEVEL
* log_folder / LOG_FOLDER

when you need to log into a different log file, make sure you define the corresponding constant / variable.
* %log_name%_log / %LOG_NAME%_LOG
* LOG_TYPE_%LOG_NAME%

definition of LOG_TYPE_%LOG_NAME% should start on 4, and avoid duplicate values.

example: to log to /var/log/database.log, we should define
```php
    define('DATABASE_LOG','database.log')
    define('LOG_TYPE_DATABASE',"LOG_TYPE_DATABASE")
```
to override database log location , define in global scope:
```php
 $database_log = '/var/log/laura/database.log';

```


we also have the following log type predefined:
* database
* cron
* access

