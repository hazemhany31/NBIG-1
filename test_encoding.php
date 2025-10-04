<?php
// اختبار ترميز الأحرف العربية
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$emailConfig = require 'email_config.php';

try {
    $mail = new PHPMailer(true);
    
    // إعدادات SMTP
    $mail->isSMTP();
    $mail->Host = $emailConfig['smtp']['host'];
    $mail->SMTPAuth = $emailConfig['smtp']['auth'];
    $mail->Username = $emailConfig['smtp']['username'];
    $mail->Password = $emailConfig['smtp']['password'];
    $mail->SMTPSecure = $emailConfig['smtp']['encryption'] === 'ssl' ? 
                       PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $emailConfig['smtp']['port'];
    
    // إعدادات SSL
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // إعدادات الترميز
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = '8bit';
    $mail->setLanguage('ar');
    
    // إعدادات البريد
    $mail->setFrom($emailConfig['email']['from_email'], 'اختبار الترميز');
    $mail->addAddress($emailConfig['email']['to_email'], 'المستقبل');
    
    // المحتوى
    $mail->isHTML(true);
    $mail->Subject = "اختبار ترميز الأحرف العربية - " . date('Y-m-d H:i:s');
    
    $mail->Body = "<!DOCTYPE html>
    <html dir='rtl' lang='ar'>
    <head>
        <meta charset='UTF-8'>
        <title>اختبار الترميز</title>
    </head>
    <body>
        <h2>اختبار ترميز الأحرف العربية</h2>
        <p>هذا اختبار للتأكد من ظهور الأحرف العربية بشكل صحيح.</p>
        <p><strong>الاسم:</strong> أحمد محمد</p>
        <p><strong>البريد الإلكتروني:</strong> test@example.com</p>
        <p><strong>رقم الهاتف:</strong> 01234567890</p>
        <p><strong>الرسالة:</strong> هذه رسالة اختبار للتأكد من عمل الترميز العربي بشكل صحيح.</p>
        <hr>
        <p style='color: #666; font-size: 12px;'>
            تم إرسال هذا الإيميل من نظام اختبار NBIG<br>
            التاريخ: " . date('Y-m-d H:i:s') . "
        </p>
    </body>
    </html>";
    
    $mail->send();
    
    echo "<h2 style='color: green;'>✅ تم إرسال الإيميل بنجاح!</h2>";
    echo "<p>تحقق من صندوق الوارد في البريد الإلكتروني: " . $emailConfig['email']['to_email'] . "</p>";
    echo "<p>يجب أن تظهر الأحرف العربية بشكل صحيح الآن</p>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ فشل إرسال الإيميل</h2>";
    echo "<p><strong>الخطأ:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>تفاصيل إضافية:</strong> " . $mail->ErrorInfo . "</p>";
}
?>
