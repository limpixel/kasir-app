<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $accountType;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->accountType = env('RAJAONGKIR_ACCOUNT_TYPE', 'starter');
        
        // Base URL berbeda untuk tiap jenis akun
        $baseUrlMap = [
            'starter' => 'https://api.rajaongkir.com/starter',
            'basic' => 'https://api.rajaongkir.com/basic',
            'pro' => 'https://pro.rajaongkir.com/api',
        ];
        
        $this->baseUrl = $baseUrlMap[$this->accountType] ?? $baseUrlMap['starter'];
    }

    /**
     * Mendapatkan daftar provinsi
     */
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/province');

        if ($response->successful()) {
            return $response->json()['rajaongkir']['results'];
        }

        return null;
    }

    /**
     * Mendapatkan daftar kota berdasarkan provinsi
     */
    public function getCities($provinceId = null)
    {
        $url = $this->baseUrl . '/city';
        if ($provinceId) {
            $url .= '?province=' . $provinceId;
        }

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['rajaongkir']['results'];
        }

        return null;
    }

    /**
     * Mendapatkan daftar kecamatan berdasarkan kota
     */
    public function getSubDistricts($cityId)
    {
        $url = $this->baseUrl . '/subdistrict?city=' . $cityId;

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['rajaongkir']['results'];
        }

        return null;
    }

    /**
     * Menghitung biaya pengiriman
     */
    public function calculateShippingCost($params)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . '/cost', [
            'origin' => $params['origin'],
            'destination' => $params['destination'],
            'weight' => $params['weight'] ?? 1000, // dalam gram
            'courier' => $params['courier'] ?? 'jne'
        ]);

        if ($response->successful()) {
            return $response->json()['rajaongkir']['results'];
        }

        return null;
    }
}