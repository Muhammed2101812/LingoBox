# LingoBox Çeviri API Servisi

Bu Flask tabanlı API, Google Translate hizmetini ücretsiz olarak kullanmak için `deep-translator` kütüphanesini kullanır.

## Kurulum

1. Gereksinimleri yükleyin:
```
pip install -r requirements.txt
```

2. Servisi başlatın:
```
python app.py
```

## API Endpointleri

### 1. Çeviri Yap

**Endpoint:** `/api/translate`
**Metod:** POST
**İstek Gövdesi:**
```json
{
  "text": "Çevrilecek metin",
  "source_lang": "en", // veya "auto" otomatik tespit için
  "target_lang": "tr"
}
```

**Başarılı Yanıt:**
```json
{
  "original_text": "Çevrilecek metin",
  "translated_text": "Çevrilmiş metin",
  "source_lang": "en",
  "target_lang": "tr"
}
```

### 2. Desteklenen Dilleri Al

**Endpoint:** `/api/languages`
**Metod:** GET

**Başarılı Yanıt:**
```json
{
  "languages": {
    "arabic": "ar",
    "english": "en",
    "french": "fr",
    ...
  }
}
```

## Notlar

- Bu API, ücretsiz çeviri yapmak için Google'ın web arayüzünü kullanır
- Yoğun kullanımda Google tarafından IP adresiniz engellenebilir
- Ticari projeler için resmi Google Cloud Translation API'sini kullanmanız tavsiye edilir 