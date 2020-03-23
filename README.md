# spyko

Spryker Akeneo Connector

Total mess here still. This is Pre pre-alpha ... nothing happening here yet ^^.
```php
<?php  require_once 'vendor/autoload.php';

$skus = ['123456', '234567'];
$factory->createAkeneoImporter()->getProductImporter()->importManyBySku($skus);
```
