<?php

namespace App\Services;

use App\Models\Keranjang;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class KeranjangService
{
    /**
     * Get user's cart items
     */
    public function getItems($user)
    {
        $items = $user->keranjang()
            ->with('barang.kategori')
            ->get()
            ->map(function (Keranjang $item) {
                $subtotal = (float) $item->jumlah * (float) $item->barang->harga_sewa;

                return [
                    'id' => $item->id,
                    'barang' => $item->barang,
                    'jumlah' => $item->jumlah,
                    'tanggal_sewa' => optional($item->tanggal_sewa)->toDateString(),
                    'tanggal_kembali_rencana' => optional($item->tanggal_kembali_rencana)->toDateString(),
                    'subtotal' => $subtotal,
                ];
            });

        return [
            'items' => $items,
            'total_estimasi' => $items->sum('subtotal'),
        ];
    }

    /**
     * Add item to cart
     */
    public function addItem($user, array $data)
    {
        $barang = Barang::find($data['barang_id']);
        if (!$barang || $barang->status !== 'tersedia' || $barang->stok <= 0) {
            throw new \Exception('Barang tidak tersedia atau stok habis.');
        }

        $jumlahDiKeranjang = Keranjang::where('user_id', $user->id)
            ->where('barang_id', $data['barang_id'])
            ->sum('jumlah');

        if (($jumlahDiKeranjang + $data['jumlah']) > $barang->stok) {
            throw new \Exception('Jumlah barang di keranjang melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok);
        }

        $item = Keranjang::firstOrNew([
            'user_id' => $user->id,
            'barang_id' => $data['barang_id'],
            'tanggal_sewa' => $data['tanggal_sewa'],
            'tanggal_kembali_rencana' => $data['tanggal_kembali_rencana'],
        ]);

        $item->jumlah = ($item->exists ? $item->jumlah : 0) + $data['jumlah'];
        $item->save();

        return $item->load('barang.kategori');
    }

    /**
     * Update item in cart
     */
    public function updateItem($user, $id, array $data)
    {
        $item = $user->keranjang()->find($id);

        if (!$item) {
            throw new \Exception('Item keranjang tidak ditemukan', 404);
        }

        if (isset($data['jumlah'])) {
            $barang = $item->barang;
            
            $jumlahLainnya = $user->keranjang()
                ->where('barang_id', $item->barang_id)
                ->where('id', '!=', $item->id)
                ->sum('jumlah');

            if (($jumlahLainnya + $data['jumlah']) > $barang->stok) {
                throw new \Exception('Jumlah barang melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok);
            }
        }

        if (isset($data['tanggal_sewa']) && isset($data['tanggal_kembali_rencana'])) {
            if ($data['tanggal_kembali_rencana'] < $data['tanggal_sewa']) {
                throw new \Exception('Tanggal kembali rencana harus sama atau setelah tanggal sewa');
            }
        } elseif (isset($data['tanggal_sewa']) && !empty($item->tanggal_kembali_rencana)) {
             if ($item->tanggal_kembali_rencana < $data['tanggal_sewa']) {
                 throw new \Exception('Tanggal kembali rencana harus sama atau setelah tanggal sewa');
             }
        }

        $item->fill($data);
        $item->save();

        return $item->load('barang.kategori');
    }

    /**
     * Delete item from cart
     */
    public function removeItem($user, $id)
    {
        $item = $user->keranjang()->find($id);

        if (!$item) {
            throw new \Exception('Item keranjang tidak ditemukan', 404);
        }

        $item->delete();
    }

    /**
     * Clear all items in cart
     */
    public function clearCart($user)
    {
        $user->keranjang()->delete();
    }
}
