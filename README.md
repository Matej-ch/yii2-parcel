Parcel extension
====================
Ability to work with Slovak parcel service with soap API

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist matejch/yii2-parcel "dev-master"
```

or add

```
"matejch/yii2-parcel": "dev-master"
```

to the require section of your `composer.json` file.

Setup
-----

#### 1. First migrate tables
./yii migrate --migrationPath=@vendor/matejch/yii2-parcel/src/migrations

#### 2. Add to modules in your web.php



#### 3. Add widget on pages you want to use page guide on


Usage
-----