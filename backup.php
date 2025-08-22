<?php
session_start();
require_once 'config.php';

// بررسی ورودی
$backup_type = $_POST['backup_type'] ?? 'both';
$send_ftp = isset($_POST['send_ftp']) && $_POST['send_ftp'] == '1';

if (!in_array($backup_type, ['structure', 'data', 'both'])) {
    $backup_type = 'both';
}

// اتصال به دیتابیس
$mysqli = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("اتصال به دیتابیس ناموفق: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");

// نام فایل
$filename = 'backup_' . $db_config['database'] . '_' . date('Y-m-d_H-i-s') . '.sql';
$filepath = $backup_dir . $filename;

// محتوای بک‌آپ
$output = "-- بک‌آپ دیتابیس: {$db_config['database']}\n";
$output .= "-- تاریخ: " . date('Y-m-d H:i:s') . "\n";
$output .= "-- نوع: {$backup_type}\n\n";
$output .= "SET FOREIGN_KEY_CHECKS = 0;\n";
$output .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$output .= "SET AUTOCOMMIT = 0;\n";
$output .= "START TRANSACTION;\n";
$output .= "SET time_zone = \"+00:00\";\n\n";

// لیست جداول
$tables = [];
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    if ($backup_type === 'structure' || $backup_type === 'both') {
        $create_result = $mysqli->query("SHOW CREATE TABLE `{$table}`");
        $create_row = $create_result->fetch_row();
        $output .= "\n-- ساختار جدول `{$table}`\n";
        $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
        $output .= $create_row[1] . ";\n";
    }

    if ($backup_type === 'data' || $backup_type === 'both') {
        $data_result = $mysqli->query("SELECT * FROM `{$table}`");
        if ($data_result->num_rows > 0) {
            $output .= "\n-- داده‌های جدول `{$table}`\n";
            while ($row = $data_result->fetch_assoc()) {
                $keys = array_keys($row);
                $values = array_map(function($value) use ($mysqli) {
                    return $value === null ? 'NULL' : "'" . $mysqli->real_escape_string($value) . "'";
                }, $row);
                $output .= "INSERT INTO `{$table}` (`" . implode('`,`', $keys) . "`) VALUES (" . implode(',', $values) . ");\n";
            }
        }
    }
}

$output .= "\nCOMMIT;\n";
$output .= "SET FOREIGN_KEY_CHECKS = 1;\n";

// ذخیره فایل
if (file_put_contents($filepath, $output)) {
    $msg = "بک‌آپ با موفقیت ایجاد شد: {$filename}";
    $msg_type = "success";

    // ارسال به FTP
    if ($send_ftp) {
        $conn_id = ftp_connect($ftp_config['host'], $ftp_config['port']);
        if ($conn_id && ftp_login($conn_id, $ftp_config['username'], $ftp_config['password'])) {
            ftp_pasv($conn_id, true); // حالت Passive برای فایروال

            $remote_file = $ftp_config['path'] . $filename;
            if (ftp_put($conn_id, $remote_file, $filepath, FTP_ASCII)) {
                $msg .= " و به هاست مقصد ارسال شد ({$remote_file}).";
            } else {
                $msg .= " اما ارسال به FTP با خطا مواجه شد.";
                $msg_type = "warning";
            }
            ftp_close($conn_id);
        } else {
            $msg .= " اما اتصال به FTP برقرار نشد.";
            $msg_type = "danger";
        }
    }

    // دانلود خودکار فایل (اختیاری)
    // header('Content-Type: application/sql');
    // header('Content-Disposition: attachment; filename="' . $filename . '"');
    // echo $output;
    // exit;

} else {
    $msg = "خطا در ایجاد فایل بک‌آپ. دسترسی فولدر را بررسی کنید.";
    $msg_type = "danger";
}

$mysqli->close();

// ذخیره پیام و هدایت به صفحه اصلی
$_SESSION['message'] = $msg;
$_SESSION['msg_type'] = $msg_type;
header('Location: index.php');
exit;