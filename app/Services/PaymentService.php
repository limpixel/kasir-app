<?php

namespace App\Services;

use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Membuat QRIS untuk pembayaran e-wallet
     */
    public function generateQRIS($amount, $orderId)
    {
        // Dalam implementasi nyata, Anda akan menggunakan library atau API pembayaran
        // untuk menghasilkan QRIS yang valid. Untuk simulasi, kita buat kode dummy.
        
        $qrisCode = 'SIMULATED_QRIS_' . $orderId . '_' . $amount . '_' . Str::random(10);
        
        return [
            'success' => true,
            'qris_code' => $qrisCode,
            'amount' => $amount,
            'order_id' => $orderId,
            'expiry_time' => now()->addHour()->toISOString(), // QR berlaku 1 jam
        ];
    }

    /**
     * Membuat instruksi transfer untuk pembayaran
     */
    public function generateTransferInstruction($amount, $orderId)
    {
        // Dalam implementasi nyata, Anda akan membuat instruksi transfer ke rekening yang dituju
        // Untuk simulasi, kita buat data dummy
        
        return [
            'success' => true,
            'transfer_to' => [
                'bank' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'PT. Toko Parfum',
            ],
            'amount' => $amount,
            'order_id' => $orderId,
            'reference_number' => rand(1000, 9999), // Nomor referensi untuk memudahkan identifikasi pembayaran
            'instructions' => [
                '1. Transfer sesuai nominal yang tertera',
                '2. Gunakan nomor referensi sebagai catatan tambahan saat transfer',
                '3. Screenshot bukti transfer sebagai konfirmasi',
            ],
            'valid_until' => now()->addDay()->toISOString(), // Instruksi berlaku 1 hari
        ];
    }

    /**
     * Membuat pembayaran berdasarkan metode
     */
    public function createPayment($method, $amount, $orderId)
    {
        switch ($method) {
            case 'e-wallet':
                return $this->generateQRIS($amount, $orderId);
            case 'transfer':
                return $this->generateTransferInstruction($amount, $orderId);
            default:
                return [
                    'success' => false,
                    'message' => 'Metode pembayaran tidak didukung'
                ];
        }
    }
}