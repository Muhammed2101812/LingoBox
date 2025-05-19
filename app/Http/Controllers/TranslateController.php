<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Translation;
use App\Models\Language;
use App\Models\TranslationList;
use App\Models\TranslationListItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\TranslationService;

class TranslateController extends Controller
{
    /**
     * Çeviri arayüzünü göster
     */
    public function index()
    {
        $languages = Language::all();
        $lists = TranslationList::where('user_id', Auth::id())->get();
        
        return view('translate.index', compact('languages', 'lists'));
    }
    
    /**
     * Metni çevir
     */
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'source_lang_id' => 'required|exists:languages,id',
            'target_lang_id' => 'required|exists:languages,id',
        ]);
        
        $sourceLanguage = Language::find($request->source_lang_id);
        $targetLanguage = Language::find($request->target_lang_id);
        
        try {
            // TranslationService kullan
            $translationService = new TranslationService();
            
            $result = $translationService->translate(
                $request->text,
                $sourceLanguage->code,
                $targetLanguage->code
            );
            
            return response()->json([
                'success' => true,
                'translation' => $result['translated_text'],
                'original' => $request->text,
                'source_lang' => $sourceLanguage,
                'target_lang' => $targetLanguage,
            ]);
            
        } catch (\Exception $e) {
            // Hata logla
            Log::error('Çeviri hatası: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Çeviri yapılırken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Çeviriyi kaydet
     */
    public function save(Request $request)
    {
        $request->validate([
            'source_text' => 'required|string|max:500',
            'target_text' => 'required|string|max:500',
            'source_lang_id' => 'required|exists:languages,id',
            'target_lang_id' => 'required|exists:languages,id',
            'list_id' => 'nullable|exists:translation_lists,id',
            'category' => 'nullable|string|max:100',
        ]);
        
        // Çeviriyi kaydet
        $translation = Translation::create([
            'user_id' => Auth::id(),
            'source_text' => $request->source_text,
            'target_text' => $request->target_text,
            'source_lang_id' => $request->source_lang_id,
            'target_lang_id' => $request->target_lang_id,
            'category' => $request->category ?? 'Genel',
        ]);
        
        // Eğer bir listeye eklenmesi isteniyorsa
        if ($request->list_id) {
            TranslationListItem::create([
                'translation_list_id' => $request->list_id,
                'translation_id' => $translation->id,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'translation' => $translation,
            'message' => 'Çeviri başarıyla kaydedildi.'
        ]);
    }
    
    /**
     * Yeni bir liste oluştur
     */
    public function createList(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);
        
        $list = TranslationList::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return redirect()->route('translate.lists.index')
            ->with('success', 'Liste başarıyla oluşturuldu.');
    }
    
    /**
     * Kullanıcının listelerini getir
     */
    public function getLists()
    {
        $lists = TranslationList::where('user_id', Auth::id())
            ->withCount('translations')
            ->paginate(9); // Sayfa başına 9 liste göster
        
        return view('translate.lists.index', compact('lists'));
    }
    
    /**
     * Belirli bir çeviri listesini ve içindeki öğeleri göster
     */
    public function showList(TranslationList $list)
    {
        // Yetkilendirme kontrolü - kullanıcı sadece kendi listelerini görebilir
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Bu listeyi görüntüleme yetkiniz yok.');
        }
        
        // Eager loading ile listedeki çevirileri ve dil bilgilerini yükleyelim
        $list->load(['translations.sourceLanguage', 'translations.targetLanguage']);
        
        return view('translate.lists.show', compact('list'));
    }
    
    /**
     * Bir listeyi güncelle
     */
    public function updateList(Request $request, TranslationList $list)
    {
        // Yetkilendirme kontrolü - kullanıcı sadece kendi listelerini güncelleyebilir
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Bu listeyi güncelleme yetkiniz yok.');
        }
        
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);
        
        $list->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return redirect()->route('translate.lists.show', $list)
            ->with('success', 'Liste başarıyla güncellendi.');
    }
    
    /**
     * Bir listeyi sil
     */
    public function destroyList(TranslationList $list)
    {
        // Yetkilendirme kontrolü - kullanıcı sadece kendi listelerini silebilir
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Bu listeyi silme yetkiniz yok.');
        }
        
        $list->delete();
        
        return redirect()->route('translate.lists.index')
            ->with('success', 'Liste başarıyla silindi.');
    }
} 

