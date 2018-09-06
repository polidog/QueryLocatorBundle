# PolidogQueryLocatorBundle

[![Build Status](https://travis-ci.org/polidog/QueryLocatorBundle.svg?branch=1.x)](https://travis-ci.org/polidog/QueryLocatorBundle)
QueryLocatoer for Symfony Bundle.  
using [Koriym.QueryLocator](https://github.com/koriym/Koriym.QueryLocator).


## Installation

### Composer install

```
$ composer require polidog/query-locator-bundle
```

### Usage
   
app/config.yml
    
```yaml
polidog_query_locator:
    locators:
        user_queries:
            sql_dir: "../../sqldir"
            use_apc: false # Default to false.
```

### 

Get Container

```php
$query = $container->get('polidog_query_locator.locators.user_queries') // QueryLocator
$sql = $query['admin/user'];
$sql = $query->getCountQuery('admin/user'); 
```

SQL files
```
└── sql
    └── admin
        └── user.sql
```

## Requirements

 * PHP 5.6+
