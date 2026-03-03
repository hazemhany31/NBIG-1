<?php
// هذا الملف للاختبار فقط. قم بحذفه بعد التأكد من عمله.

// ضعه هنا بريدك الإلكتروني الشخصي الذي ستتحقق منه الآن
$to_test = "info@new-build-egypt.com"; 

$subject_test = "اختبار وظيفة Mail PHP - يجب أن تصل هذه الرسالة الآن!";
$message_test = "إذا تلقيت هذه الرسالة، فإن دالة mail() تعمل بشكل صحيح على خادمك.";
$headers_test = 'From: Webmaster <no-reply@new-build-egypt.com>';

if (mail($to_test, $subject_test, $message_test, $headers_test)) {
    echo "تم إرسال رسالة الاختبار بنجاح إلى: {$to_test}. الرجاء التحقق من صندوق الوارد أو مجلد السبام لديك.";
} else {
    echo "فشل إرسال رسالة الاختبار. دالة mail() في PHP لا تعمل على الخادم الحالي.";
}
?>
