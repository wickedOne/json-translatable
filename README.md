# json translatable

POC to use mysql json columns for record translations.

## getting started

```console
make up
make bash
bin/console doctrine:migrations:migrate -n
bin/console doctrine:migrations:migrate -n --conn=db80
bin/console fixtures:generate 10
bin/console fixtures:generate 10 --conn=db80
```

## switching database

to not overcomplicate the code, you need to change a config when you want to switch from mysql 5.7 to mysql 8.0.

use [this](https://github.com/wickedOne/json-translatable/blob/master/config/packages/doctrine.yaml#L12) configuration 
option to switch between the `db57` and `db80` connection

```yaml
doctrine:
    dbal:
        connections:
            db57:
                url: '%env(resolve:DB57_URL)%'
                profiling_collect_backtrace: '%kernel.debug%'
                use_savepoints: true
            db80:
                url: '%env(resolve:DB80_URL)%'
                profiling_collect_backtrace: '%kernel.debug%'
                use_savepoints: true
        default_connection: db57 # <== change this config setting
    # ....
```
