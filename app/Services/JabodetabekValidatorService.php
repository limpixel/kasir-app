<?php

namespace App\Services;

class JabodetabekValidatorService
{
    /**
     * Jabodetabek cities array
     */
    private array $jabodetabekCities = [
        // Jakarta
        'jakarta pusat', 'jakarta utara', 'jakarta barat', 'jakarta selatan', 'jakarta timur',
        'jakarta', 'central jakarta', 'north jakarta', 'west jakarta', 'south jakarta', 'east jakarta',
        
        // Bogor
        'bogor', 'kota bogor', 'kabupaten bogor', 'bogor city', 'bogor regency',
        
        // Depok
        'depok', 'kota depok', 'depok city',
        
        // Tangerang
        'tangerang', 'kota tangerang', 'kabupaten tangerang', 'tangerang regency',
        'tangerang city', 'south tangerang', 'kota tangerang selatan', 'tangerang selatan',
        
        // Bekasi
        'bekasi', 'kota bekasi', 'kabupaten bekasi', 'bekasi city', 'bekasi regency',
    ];

    /**
     * Jabodetabek provinces array
     */
    private array $jabodetabekProvinces = [
        'jakarta', 'dki jakarta', 'banten', 'west java', 'jawa barat',
    ];

    /**
     * Check if the given location is within Jabodetabek region
     * 
     * @param string|null $city
     * @param string|null $province
     * @param string|null $address
     * @return bool
     */
    public function isJabodetabek(?string $city, ?string $province, ?string $address = null): bool
    {
        if (!$city && !$province) {
            return false;
        }

        // Normalize input strings
        $normalizedCity = strtolower(trim($city ?? ''));
        $normalizedProvince = strtolower(trim($province ?? ''));
        $normalizedAddress = strtolower(trim($address ?? ''));

        // Check if city is in Jabodetabek
        if ($normalizedCity) {
            foreach ($this->jabodetabekCities as $jabodetabekCity) {
                if (stripos($normalizedCity, $jabodetabekCity) !== false) {
                    return true;
                }
            }
            
            // Also check in the address string if city wasn't matched
            if ($normalizedAddress) {
                foreach ($this->jabodetabekCities as $jabodetabekCity) {
                    if (stripos($normalizedAddress, $jabodetabekCity) !== false) {
                        return true;
                    }
                }
            }
        }

        // Check if province is in Jabodetabek
        if ($normalizedProvince) {
            foreach ($this->jabodetabekProvinces as $jabodetabekProvince) {
                if (stripos($normalizedProvince, $jabodetabekProvince) !== false) {
                    return true;
                }
            }
            
            // Also check in the address string if province wasn't matched
            if ($normalizedAddress) {
                foreach ($this->jabodetabekProvinces as $jabodetabekProvince) {
                    if (stripos($normalizedAddress, $jabodetabekProvince) !== false) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Get the list of Jabodetabek cities
     * 
     * @return array
     */
    public function getJabodetabekCities(): array
    {
        return $this->jabodetabekCities;
    }

    /**
     * Get the list of Jabodetabek provinces
     * 
     * @return array
     */
    public function getJabodetabekProvinces(): array
    {
        return $this->jabodetabekProvinces;
    }
}