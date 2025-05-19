# LingoBox Python API Kurulumu

Bu doküman, LingoBox Python API'sinin kurulumu ve yapılandırması hakkında bilgi vermektedir.

## Kurulum Adımları

### 1. Python Bağımlılıklarını Yükleyin

```bash
cd python_api
pip install -r requirements.txt
```

### 2. API Servisini Başlatın

```bash
cd python_api
python app.py
```

Servis varsayılan olarak `http://localhost:5000` adresinde çalışacaktır.

## Laravel Entegrasyonu

### .env Dosyasını Güncelleyin

Laravel uygulamanız için `.env` dosyanıza aşağıdaki satırı ekleyin:

```
# Python API URL (Lokal geliştirme)
PYTHON_API_URL=http://localhost:5000

# Python API URL (Docker ortamı - Docker kullanıyorsanız bunu aktif hale getirin)
# PYTHON_API_URL=http://python_api:5000
```

## Docker ile Çalıştırma

Docker kullanarak hem Laravel uygulamasını hem de Python API'sini çalıştırmak için:

```bash
docker-compose up -d
```

## API Endpointleri

### 1. Çeviri Yap

**Endpoint:** `http://localhost:5000/api/translate`
**Method:** POST
**İstek Gövdesi:**
```json
{
  "text": "Çevrilecek metin",
  "source_lang": "en", 
  "target_lang": "tr"
}
```

### 2. Desteklenen Dilleri Al

**Endpoint:** `http://localhost:5000/api/languages`
**Method:** GET

## Sorun Giderme

Eğer API bağlantı hatası alırsanız:

1. API servisinin çalıştığını doğrulayın
2. `.env` dosyasındaki `PYTHON_API_URL` değerinin doğru olduğunu kontrol edin
3. Docker kullanıyorsanız ağ yapılandırmasının doğru olduğundan emin olun 