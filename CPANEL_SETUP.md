# دليل رفع الموقع على cPanel

## الملفات المطلوبة للرفع:

### 1. ملفات PHP الأساسية:
- `send_email.php` - ملف إرسال الإيميلات
- `email_config.php` - ملف إعدادات البريد
- `test_smtp.php` - ملف اختبار الاتصال (اختياري)

### 2. مجلد PHPMailer:
- `src/` - مجلد يحتوي على مكتبة PHPMailer
  - `PHPMailer.php`
  - `SMTP.php`
  - `Exception.php`
  - `OAuth.php`
  - `POP3.php`
  - `DSNConfigurator.php`
  - `OAuthTokenProvider.php`

## خطوات الرفع على cPanel:

### 1. رفع الملفات:
1. ادخل إلى cPanel
2. اذهب إلى "File Manager"
3. اذهب إلى مجلد `public_html`
4. ارفع جميع الملفات والمجلدات

### 2. تعديل إعدادات البريد:
1. افتح ملف `email_config.php`
2. تأكد من صحة البيانات التالية:
   - `host`: `mail.new-build-egypt.com`
   - `username`: `info@new-build-egypt.com`
   - `password`: كلمة مرور البريد الإلكتروني
   - `port`: `587` (لـ TLS) أو `465` (لـ SSL)

### 3. اختبار الإعدادات:
1. اذهب إلى `yoursite.com/test_email_simple.php`
2. تحقق من النتائج
3. إذا نجح الاختبار، تحقق من صندوق الوارد
4. إذا لم تجد الإيميل، تحقق من مجلد البريد غير الهام (Spam/Junk)

### 4. إعدادات cPanel المطلوبة:

#### في Email Accounts:
- تأكد من وجود البريد `info@new-build-egypt.com`
- تأكد من صحة كلمة المرور

#### في Email Routing:
- اختر "Automatically Detect Configuration"

#### في PHP Selector:
- تأكد من تفعيل PHP 7.4 أو أحدث
- تأكد من تفعيل الامتدادات:
  - `openssl`
  - `curl`
  - `mbstring`

### 5. إعدادات الأمان:
1. في `email_config.php`، غيّر `debug` إلى `false` في الإنتاج
2. احذف ملف `test_email_simple.php` بعد التأكد من عمل النظام
3. تأكد من أن ملف `email_errors.log` محمي

### 6. حل مشاكل الترميز:
- تم تحسين النظام لدعم الترميز العربي بشكل صحيح
- الإيميلات الآن تُرسل بصيغة HTML مع ترميز UTF-8
- العنوان يُرمز بـ base64 لتجنب مشاكل الترميز

## استكشاف الأخطاء:

### إذا لم تعمل الإيميلات:
1. تحقق من ملف `email_errors.log`
2. تأكد من صحة كلمة مرور البريد
3. جرب تغيير المنفذ من 587 إلى 465
4. تأكد من تفعيل SSL/TLS في cPanel

### رسائل الخطأ الشائعة:
- **"Authentication failed"**: كلمة مرور خاطئة
- **"Connection refused"**: المنفذ مغلق أو مضيف خاطئ
- **"SMTP connect() failed"**: مشكلة في إعدادات SSL

## ملاحظات مهمة:
- تأكد من أن جميع الملفات في نفس المجلد
- تأكد من صلاحيات الملفات (644 للملفات، 755 للمجلدات)
- اختبر النظام قبل النشر النهائي
