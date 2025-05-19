from flask import Flask, request, jsonify
from flask_cors import CORS
from deep_translator import GoogleTranslator
import logging

app = Flask(__name__)
CORS(app)  # Laravel uygulamasından yapılacak isteklere izin ver

# Loglama için yapılandırma
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

@app.route('/api/translate', methods=['POST'])
def translate():
    try:
        data = request.get_json()
        
        if not data:
            return jsonify({"error": "JSON verisi bulunamadı"}), 400
            
        # İstek verilerini kontrol et
        required_fields = ['text', 'source_lang', 'target_lang']
        for field in required_fields:
            if field not in data:
                return jsonify({"error": f"Eksik alan: {field}"}), 400
                
        text = data['text']
        source_lang = data['source_lang']
        target_lang = data['target_lang']
        
        # Kaynak dil auto olabilir
        if source_lang == 'auto':
            translator = GoogleTranslator(source='auto', target=target_lang)
        else:
            translator = GoogleTranslator(source=source_lang, target=target_lang)
            
        # Çeviri yap
        translated = translator.translate(text)
        
        logger.info(f"Çeviri başarılı: {source_lang} -> {target_lang}")
        
        return jsonify({
            "original_text": text,
            "translated_text": translated,
            "source_lang": source_lang,
            "target_lang": target_lang
        })
        
    except Exception as e:
        logger.error(f"Çeviri sırasında hata: {str(e)}")
        return jsonify({"error": str(e)}), 500

@app.route('/api/languages', methods=['GET'])
def get_languages():
    try:
        # Google Translator'ın desteklediği dilleri al
        languages = GoogleTranslator().get_supported_languages(as_dict=True)
        
        return jsonify({
            "languages": languages
        })
        
    except Exception as e:
        logger.error(f"Diller alınırken hata: {str(e)}")
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000) 