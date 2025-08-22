<?php
// config.php

// تنظیمات دیتابیس محلی (منبع)
$db_config = [
    'host'     => 'localhost',
    'username' => 'admin',
    'password' => 'admin',
    'database' => 'dima_shop'
];

// تنظیمات FTP برای انتقال به هاست دیگر (مقصد)
$ftp_config = [
    'host'     => 'ftp.example.com',         // آی‌پی یا دامنه هاست مقصد
    'username' => 'ftp_user@example.com',
    'password' => 'your_ftp_password',
    'port'     => 21,
    'path'     => '/public_html/backups/'   // مسیر مقصد در سرور (باید ایجاد شده باشد)
];

// تنظیم مسیر فولدر بک‌آپ (خارج از public_html یا با .htaccess محافظت شود)
$backup_dir = __DIR__ . '/backups/';