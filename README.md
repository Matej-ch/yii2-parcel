Parcel extension
====================
Ability to work with Slovak parcel service with soap API

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist matejch/yii2-parcel "dev-main"
```

or add

```
"matejch/yii2-parcel": "dev-main"
```

to the require section of your `composer.json` file.

Setup
-----

#### 1. First migrate tables
./yii migrate --migrationPath=@vendor/matejch/yii2-parcel/src/migrations

#### 2. Add to modules in your web.php

```php 

'parcel' => [
    'class' => \matejch\parcel\Parcel::class,
    /* change if you use rbac rules, and want to have specific rule */
    'controllerAccessRules' => ['@'],
    /* soap ulr for slovak parcel service */
    'wsdlurl' => 'https://webship.sps-sro.sk/services/WebshipWebService?wsdl',
    /* xml containing all available drop off points */
    'placeurl' => 'https://balikomat.sps-sro.sk/alternativneMiesta.xml',
    /* random key for saving parcel account information in database, file can be also used */
    'key' => '',
    /* array of models that are allowed for creating model maps and packages */
    'models' => ['app\models\Order','app\models\Complaint'],
    'pickUpAddressModel' => '\app\models\Address'
]

```

Usage
-----

#### 1. Access index and form for creation of accounts, maps, and loading drop-off points

```php 

{key_of_module_you_use_in_web.php}/parcel/index

/* FOR EXMAPLE */
/** parcel/parcel-account/index */
/** parcel/parcel-shop/index */
/** parcel/parcel-shipment/index */
/** parcel/parcel-model-map/index */

```

#### 2. Parcel accounts
```php  
parcel/parcel-account/index
```

Your accounts


#### 3. Parcel delivery places
```php  
parcel/parcel-shop/index
```

Command for loading parcel delivery places exists

```php
./yii parcel/parcel-shop/init
```

#### 4. Create parcel model map for your models

For creating model map you need set 'pickUpAddressModel' in your module setting and at least one model in 'models'