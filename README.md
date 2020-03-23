# spyko

Spryker Akeneo Connector

Total mess here still. This is Pre pre-alpha ... nothing happening here yet ^^.

Reason to reinvent this wheel. Too much string based/nested configs etc. in the current middleware
and hard/impossible to trace the execution path of the code without actually debugging.

I want a unified way to update/insert (via job and/or click in /zed/products ui):
 - a single concrete/abstract product
 - a single abstract product with all of it's concretes (akeneo >=3.2 required for the parent filter)
 - all abstracts/concretes that have changed since timestamp (delta)
 - all abstracts and concretes

```php
<?php  require_once 'vendor/autoload.php';

$skus = ['123456', '234567'];
$factory->createAkeneoImporter()->getProductImporter()->importManyBySku($skus);
```
