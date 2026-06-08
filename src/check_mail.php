<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kategori;
use App\Models\User;

$kategoris = Kategori::all();
echo "=== KATEGORIS ===" . PHP_EOL;
foreach ($kategoris as $k) {
    echo "ID:{$k->id} | Nama: {$k->nama_kategori}" . PHP_EOL;
}

echo PHP_EOL . "=== USERS ===" . PHP_EOL;
$users = User::withCount('barangs')->get();
foreach ($users as $u) {
    $isOwner = $u->barangs_count > 0;
    echo "ID:{$u->id} | Name: {$u->name} | Role: {$u->role} | Barangs: {$u->barangs_count} | IsOwner: " . ($isOwner ? 'YES' : 'NO') . PHP_EOL;
}
