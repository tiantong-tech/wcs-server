# README

## 依赖安装

```
composer install
```

## 自动加载

如果新加入的文件无法被找到，可能是它使用了 [composer autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading)， 请手动运行命令来重新生成 `/vendor/autoload.php` 文件。

```
composer dump
```

## 数据库

```
// 运行数据库脚本
php artisan migrate

// 插入数据
php artisan db:seed

// migrate + db:seed
php artisan db:rebuild
```

## 运行测试

```
phpunit
```
