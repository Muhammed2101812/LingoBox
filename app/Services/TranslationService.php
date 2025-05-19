<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TranslationService
{
    /**
     * Python API URL
     * 
     * @var string
     */
    protected $apiUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Ortam değişkeninden API URL'sini al, yoksa localhost varsayılanını kullan
        $this->apiUrl = env('PYTHON_API_URL', 'http://localhost:5000');
    }

    /**
     * Metni çevir
     * 
     * @param string $text Çevrilecek metin
     * @param string $sourceLang Kaynak dil kodu
     * @param string $targetLang Hedef dil kodu
     * @return array Çeviri sonuçları
     * @throws Exception API hatası durumunda
     */
    public function translate(string $text, string $sourceLang, string $targetLang): array
    {
        try {
            $response = Http::post("{$this->apiUrl}/api/translate", [
                'text' => $text,
                'source_lang' => $sourceLang,
                'target_lang' => $targetLang,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            $error = $response->json()['error'] ?? 'Bilinmeyen hata';
            Log::error("Çeviri API hatası: {$error}");
            throw new Exception("Çeviri yapılırken bir hata oluştu: {$error}");
        } catch (Exception $e) {
            Log::error("Çeviri servisi hatası: " . $e->getMessage());
            throw new Exception("Çeviri yapılırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
        }
    }

    /**
     * Desteklenen dilleri getir
     * 
     * @return array Dil listesi
     * @throws Exception API hatası durumunda
     */
    public function getSupportedLanguages(): array
    {
        try {
            $response = Http::get("{$this->apiUrl}/api/languages");

            if ($response->successful()) {
                return $response->json()['languages'];
            }

            $error = $response->json()['error'] ?? 'Bilinmeyen hata';
            Log::error("Dil listesi API hatası: {$error}");
            throw new Exception("Dil listesi alınırken bir hata oluştu: {$error}");
        } catch (Exception $e) {
            Log::error("Dil listesi servisi hatası: " . $e->getMessage());
            throw new Exception("Dil listesi alınırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
        }
    }
} 