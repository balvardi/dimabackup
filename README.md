## 📄 `README.md`

```markdown
# Dima Backup 💾

<p align="center">
  <img src="https://img.shields.io/badge/Version-1.0.0-blue" alt="Version">
  <img src="https://img.shields.io/badge/PHP->=7.4-green" alt="PHP">
  <img src="https://img.shields.io/badge/License-MIT-purple" alt="License">
</p>

**Dima Backup** یک ابزار ساده و قدرتمند بر پایه PHP برای گرفتن بک‌آپ از دیتابیس MySQL با رابط کاربری زیبا و قابلیت ارسال خودکار به هاست دیگر از طریق FTP است.  
این ابزار بدون نیاز به `mysqldump` کار می‌کند و کاملاً درون PHP اجرا می‌شود.

🌐 [مشاهده در گیت‌هاب](https://github.com/balvardi/dimabackup)

---

## ✨ ویژگی‌ها

- 🎨 رابط کاربری مدرن و واکنش‌گرا (با Bootstrap)
- 🔁 انتخاب نوع بک‌آپ: فقط ساختار، فقط داده، یا هر دو
- 📥 دانلود مستقیم فایل بک‌آپ
- 🚀 ارسال خودکار به هاست دیگر از طریق FTP
- 🔐 تنظیمات امن در `config.php`
- 📁 ذخیره‌سازی ایمن بک‌آپ‌ها در فولدر محافظت‌شده
- 🌍 پشتیبانی از کاراکترهای فارسی و UTF-8

---

## 🛠️ نصب و راه‌اندازی

1. این مخزن را کلون کنید:
   ```bash
   git clone https://github.com/balvardi/dimabackup.git
   ```

2. وارد پوشه پروژه شوید:
   ```bash
   cd dimabackup
   ```

3. فایل `config.php` را با اطلاعات دیتابیس و FTP تنظیم کنید:
   ```php
   $db_config = [
       'host'     => 'localhost',
       'username' => 'your_username',
       'password' => 'your_password',
       'database' => 'your_database'
   ];

   $ftp_config = [
       'host'     => 'ftp.example.com',
       'username' => 'ftp_user',
       'password' => 'ftp_pass',
       'port'     => 21,
       'path'     => '/public_html/backups/'
   ];
   ```

4. فولدر `backups/` را ایجاد کنید و دسترسی نوشتن (`755` یا `777`) بدهید.

5. برای محافظت از فایل‌های بک‌آپ، یک فایل `.htaccess` در فولدر `backups` ایجاد کنید:
   ```
   Deny from all
   ```

6. مرورگر خود را باز کنید و به آدرس زیر بروید:
   ```
   http://yoursite.com/dimabackup/
   ```

---

## 🖼️ نمایه (Screenshots)

![صفحه اصلی](https://via.placeholder.com/800x500/2c3e50/ffffff?text=Dima+Backup+Interface)  
*رابط کاربری ساده و کاربرپسند*

---

## 🧩 ساختار پروژه

```
dimabackup/
├── index.php          # رابط کاربری
├── backup.php         # انجام بک‌آپ و ارسال به FTP
├── config.php         # تنظیمات دیتابیس و FTP
├── backups/           # فایل‌های بک‌آپ (محافظت‌شده)
└── README.md
```

---

## 🔐 امنیت

- این ابزار فقط برای استفاده داخلی و توسط مدیران سیستم طراحی شده است.
- دسترسی به پوشه `backups` باید محدود شود.
- برای محافظت بیشتر، از `.htpasswd` یا محدودیت IP استفاده کنید.

---
