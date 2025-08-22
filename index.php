<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>سیستم بک‌آپ دیتابیس</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet"/>
    <style>
        body { background: #f4f6f9; font-family: Tahoma, sans-serif; }
        .card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 12px; }
        .btn-primary { background: #0d6efd; }
        .alert { border-radius: 8px; }
    </style>
</head>
<body class="py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>🔐 سیستم بک‌آپ دیتابیس</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
                            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="backup.php" method="POST">
                        <div class="mb-4">
                            <label class="form-label">نوع بک‌آپ را انتخاب کنید:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="backup_type" value="structure" id="structure">
                                <label class="form-check-label" for="structure">فقط ساختار جداول (CREATE TABLE)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="backup_type" value="data" id="data">
                                <label class="form-check-label" for="data">فقط داده‌ها (INSERT)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="backup_type" value="both" id="both" checked>
                                <label class="form-check-label" for="both">هر دو (ساختار + داده)</label>
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="send_ftp" value="1" id="send_ftp">
                            <label class="form-check-label" for="send_ftp">ارسال خودکار به هاست دیگر (FTP)</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-download"></i> ایجاد بک‌آپ و ارسال
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>