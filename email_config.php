<?php
// ملف إعدادات البريد الإلكتروني
// يمكن تعديل هذه الإعدادات حسب خادم cPanel الخاص بك

return [
    // إعدادات SMTP
    'smtp' => [
        'host' => 'mail.new-build-egypt.com',        // مضيف SMTP
        'port' => 587,                               // منفذ SMTP (587 لـ TLS، 465 لـ SSL)
        'encryption' => 'tls',                       // نوع التشفير (tls أو ssl)
        'auth' => true,                              // تفعيل المصادقة
        'username' => 'info@new-build-egypt.com',    // اسم المستخدم (البريد الكامل)
        'password' => 'SLHEzvx3UmjWYzf',            // كلمة المرور
    ],
    
    // إعدادات البريد
    'email' => [
        'from_email' => 'info@new-build-egypt.com',  // البريد المرسل منه
        'from_name' => 'NBIG Contact Form',          // اسم المرسل
        'to_email' => 'info@new-build-egypt.com',    // البريد المستقبل
        'to_name' => 'NBIG Recipient',               // اسم المستقبل
    ],
    
    // إعدادات إضافية
    'settings' => [
        'timeout' => 60,                             // مهلة الاتصال (ثانية)
        'charset' => 'UTF-8',                        // ترميز النص
        'debug' => false,                            // تفعيل وضع التصحيح
        'verify_peer' => false,                      // التحقق من شهادة SSL
        'verify_peer_name' => false,                 // التحقق من اسم الشهادة
        'allow_self_signed' => true,                 // السماح بالشهادات الذاتية
    ]
];
?>
