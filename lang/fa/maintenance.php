<?php
return [
    /*
	|--------------------------------------------------------------------------
	| صفحه نگهداری
	|--------------------------------------------------------------------------
	*/
    'title' => 'نگهداری',
    'description' => 'در این صفحه تمام اقدامات موذد نیاز برای حفظ عملکرد بی نقص و مناسب نسخه لیچی نصب شده خود را خواهید یافت.',
    'cleaning' => [
        'title' => 'پاک‌سازی %s',
        'result' => '%s حذف شد.',
        'description' => 'تمام محتویات <span class="font-mono">%s</span> را حذف کنید',
        'button' => 'پاک‌سازی',
    ],
    'duplicate-finder' => [
        'title' => 'موارد تکراری',
        'description' => 'این ماژول موارد تکراری احتمالی بین تصاویر را شمارش می‌کند.',
        'duplicates-all' => 'موارد تکراری در تمام آلبوم‌ها',
        'duplicates-title' => 'موارد تکراری عنوان در هر آلبوم',
        'duplicates-per-album' => 'موارد تکراری در هر آلبوم',
        'show' => 'نمایش موارد تکراری',
    ],
    'fix-jobs' => [
        'title' => 'اصلاح تاریخچه وظایف',
        'description' => 'وظایف با وضعیت <span class="text-ready-400">%s</span> یا <span class="text-primary-500">%s</span> را به عنوان <span class="text-danger-700">%s</span> علامت‌گذاری کنید.',
        'button' => 'اصلاح تاریخچه وظایف',
    ],
    'gen-sizevariants' => [
        'title' => '%s گمشده',
        'description' => '%d %s یافت شد که می‌تواند تولید شود.',
        'button' => 'تولید!',
        'success' => '%d %s با موفقیت تولید شد.',
    ],
    'fill-filesize-sizevariants' => [
        'title' => 'اندازه فایل‌ها گمشده است',
        'description' => '%d واریانت کوچک بدون اندازه فایل یافت شد.',
        'button' => 'دریافت داده!',
        'success' => 'اندازه %d واریانت کوچک با موفقیت محاسبه شد.',
    ],
    'fix-tree' => [
        'title' => 'آمار درخت',
        'Oddness' => 'ناهنجاری',
        'Duplicates' => 'موارد تکراری',
        'Wrong parents' => 'والدین اشتباه',
        'Missing parents' => 'والدین گمشده',
        'button' => 'اصلاح درخت',
    ],
    'optimize' => [
        'title' => 'بهینه سازی پایگاه داده',
        'description' => 'اگر کندی در نصب خود مشاهده می‌کنید، ممکن است پایگاه داده شما همه ایندکس های لازم را نداشته باشد.',
        'button' => 'بهینه سازی پایگاه داده',
    ],
    'update' => [
        'title' => 'به‌روزرسانی‌ها',
        'check-button' => 'بررسی به‌روزرسانی',
        'update-button' => 'به‌روزرسانی',
        'no-pending-updates' => 'به‌روزرسانی معوقه‌ای وجود ندارد.',
    ],
    'missing-palettes' => [
        'title' => 'Missing Palettes',
        'description' => 'Found %d missing palettes.',
        'button' => 'Create missing',
    ],
    'statistics-check' => [
        'title' => 'بررسی صحت آمار',
        'missing_photos' => '%d آمار عکس گمشده است.',
        'missing_albums' => '%d آمار آلبوم گمشده است.',
        'button' => 'ایجاد موارد گمشده',
    ],
    'flush-cache' => [
        'title' => 'پاک سازی کش',
        'description' => 'کش همه کاربران را برای حل مشکلات اعتبارسنجی پاک کنید.',
        'button' => 'پاک سازی',
    ],
];
