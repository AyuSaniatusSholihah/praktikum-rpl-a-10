<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Testing email configuration..." . PHP_EOL;
echo "MAIL_MAILER: " . config('mail.default') . PHP_EOL;
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . PHP_EOL;
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . PHP_EOL;
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . PHP_EOL;
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . PHP_EOL;
echo PHP_EOL;

try {
    Mail::raw('Test email dari Laravel SEWAIN - ' . date('Y-m-d H:i:s'), function($m) {
        $m->to('alfagusasti@gmail.com')->subject('Test SEWAIN Email');
    });
    echo "✅ Email berhasil dikirim ke alfagusasti@gmail.com!" . PHP_EOL;
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "Exception class: " . get_class($e) . PHP_EOL;
}
