<?php
// filepath: send_email.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';

header('Content-Type: application/json; charset=utf-8');

// استقبال البيانات من POST
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$number = trim($_POST['number'] ?? '');
$message = trim($_POST['message'] ?? '');

// تحقق من الحقول
if (!$name || !$email || !$number) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('info@new-build-egypt.com', 'New Build Website');
    $mail->addAddress('info@new-build-egypt.com');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = "📧 New Message from New Build Website";
    $mail->Body = '
    <html lang="en" dir="ltr">
    <head><meta charset="UTF-8"></head>
    <body style="background:#f6f7fa;padding:30px;">
      <div style="max-width:600px;margin:40px auto;background:#fff;border-radius:14px;box-shadow:0 4px 24px #0001;overflow:hidden;">
        <div style="background:#0078d4;color:#fff;padding:24px 0 18px 0;text-align:center;font-size:1.5rem;font-weight:700;">
          New Message from New Build Website <span style="font-size:1.3rem;">📧</span>
        </div>
        <div style="padding:32px 24px 18px 24px;">
          <div style="margin-bottom:18px;">
            <span style="color:#0078d4;font-weight:600;">Name 👤</span>
            <div style="background:#f7fafd;border-radius:10px;padding:12px 18px;margin-top:6px;border-left:4px solid #0078d4;">' . htmlspecialchars($name) . '</div>
          </div>
          <div style="margin-bottom:18px;">
            <span style="color:#0078d4;font-weight:600;">Email 📧</span>
            <div style="background:#f7fafd;border-radius:10px;padding:12px 18px;margin-top:6px;border-left:4px solid #0078d4;">' . htmlspecialchars($email) . '</div>
          </div>
          <div style="margin-bottom:18px;">
            <span style="color:#0078d4;font-weight:600;">Number 📱</span>
            <div style="background:#f7fafd;border-radius:10px;padding:12px 18px;margin-top:6px;border-left:4px solid #0078d4;">' . htmlspecialchars($number) . '</div>
          </div>'
        . ($message ? '
          <div style="margin-bottom:18px;">
            <span style="color:#d4af37;font-weight:600;">Message 💬</span>
            <div style="background:#fffbe7;border-radius:10px;padding:12px 18px;margin-top:6px;border-left:4px solid #ffc107;">' . nl2br(htmlspecialchars($message)) . '</div>
          </div>' : '') .
        '</div>
        <div style="background:#f6f7fa;padding:18px 0 8px 0;text-align:center;color:#888;font-size:1rem;border-top:1px solid #eee;">
          Sent from New Build Website<br>
          <span style="color:#0078d4;font-size:1.1em;">Date & Time: ' . date("Y-m-d H:i:s") . '</span>
        </div>
      </div>
    </body>
    </html>
    ';

    $mail->send();

    // إرسال رسالة تأكيد عربية للمستخدم
    $userMail = new PHPMailer(true);
    $userMail->CharSet = 'UTF-8';
    $userMail->setFrom('info@new-build-egypt.com', 'NBIG Contact Form');
    $userMail->addAddress($email, $name);
    $userMail->isHTML(true);
    $userMail->Subject = "شكراً لك - تم استلام رسالتك";
    $userMail->Body = '
    <html dir="rtl" lang="ar">
    <head>
        <meta charset="UTF-8">
        <title>تأكيد استلام الرسالة</title>
    </head>
    <body style="background:#f5f5f5;margin:0;padding:20px;">
        <div style="max-width:600px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
            <div style="background:#0078d4;color:white;padding:36px 0 30px 0;text-align:center;border-radius:16px 16px 0 0;">
                <h1 style="margin:0;font-size:2rem;font-weight:700;">شكراً لك</h1>
            </div>
            <div style="padding:30px;text-align:center;">
                <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="success" width="70" style="margin-bottom:18px;">
                <h2 style="color:#222;font-size:1.4rem;font-weight:700;margin-bottom:10px;">تم استلام رسالتك بنجاح</h2>
                <p style="font-size:1.1rem;color:#222;margin-bottom:10px;">عزيزي/عزيزتي <strong>' . htmlspecialchars($name) . '</strong>،</p>
                <p style="color:#8a2be2;font-size:1rem;margin-bottom:10px;">نشكرك لتواصلك معنا. تم استلام رسالتك وسنقوم بالرد عليك في أقرب وقت ممكن.</p>
                <p style="color:#333;font-size:1rem;">سيتم التواصل معك على رقم الهاتف: <strong>' . htmlspecialchars($number) . '</strong></p>
            </div>
            <div style="background:#f8f9fa;padding:20px;text-align:center;color:#666;font-size:12px;border-top:1px solid #e9ecef;">
                نيو بيلد انترناشونال جروب NBIG للتطوير العقاري<br>
                📞 19938 | 📧 info@new-build-egypt.com
            </div>
        </div>
    </body>
    </html>
    ';

    $userMail->send();

    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to send: ' . $mail->ErrorInfo]);
}
?>