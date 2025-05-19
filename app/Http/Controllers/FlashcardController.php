<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\FlashcardProgress;
use App\Models\TranslationList;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FlashcardController extends Controller
{
    /**
     * Flashcard ana sayfasını göster - liste seçimi ve başlangıç
     */
    public function index()
    {
        $lists = TranslationList::where('user_id', Auth::id())
            ->withCount('translations')
            ->get();
            
        // Toplam istatistikleri hesapla
        $totalProgress = FlashcardProgress::where('user_id', Auth::id())->count();
        $knownCount = FlashcardProgress::where('user_id', Auth::id())
            ->where('status', 'known')
            ->count();
            
        $progressPercentage = $totalProgress > 0 
            ? round(($knownCount / $totalProgress) * 100) 
            : 0;
        
        return view('flashcards.index', compact('lists', 'totalProgress', 'knownCount', 'progressPercentage'));
    }
    
    /**
     * Belirli bir liste için flashcard çalışmasını başlat
     */
    public function start(Request $request)
    {
        $request->validate([
            'list_id' => 'required|exists:translation_lists,id',
        ]);
        
        $list = TranslationList::findOrFail($request->list_id);
        
        // Yetkilendirme kontrolü
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Bu listeye erişim yetkiniz yok.');
        }
        
        // Listedeki tüm çevirileri al
        $list->load([
            'translations' => function($query) {
                $query->with(['sourceLanguage', 'targetLanguage']);
            }
        ]);
        
        if ($list->translations->isEmpty()) {
            return redirect()->route('flashcards.index')
                ->with('error', 'Bu listede çalışılacak kelime bulunmuyor.');
        }
        
        // Çevirileri karıştır - rastgele öğrenme sırası için
        $translations = $list->translations->shuffle();
        
        // İlerleme durumunu yükle
        $progressData = [];
        foreach ($translations as $translation) {
            $progress = FlashcardProgress::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'translation_id' => $translation->id
                ],
                [
                    'status' => 'unknown',
                    'last_reviewed_at' => null
                ]
            );
            
            $progressData[$translation->id] = $progress->status;
        }
        
        return view('flashcards.study', compact('list', 'translations', 'progressData'));
    }
    
    /**
     * Bilinen/bilinmeyen olarak işaretle
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'translation_id' => 'required|exists:translations,id',
            'status' => 'required|in:known,unknown',
        ]);
        
        $translation = Translation::findOrFail($request->translation_id);
        
        // Yetkilendirme kontrolü
        if ($translation->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu çeviriyi güncelleme yetkiniz yok.'
            ], 403);
        }
        
        // İlerleme kaydını güncelle
        $progress = FlashcardProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'translation_id' => $translation->id
            ],
            [
                'status' => $request->status,
                'last_reviewed_at' => Carbon::now()
            ]
        );
        
        return response()->json([
            'success' => true,
            'status' => $progress->status,
            'message' => 'Durum başarıyla güncellendi.'
        ]);
    }
    
    /**
     * Sadece bilinmeyen kelimeleri çalış
     */
    public function studyUnknown(Request $request)
    {
        $request->validate([
            'list_id' => 'required|exists:translation_lists,id',
        ]);
        
        $list = TranslationList::findOrFail($request->list_id);
        
        // Yetkilendirme kontrolü
        if ($list->user_id !== Auth::id()) {
            abort(403, 'Bu listeye erişim yetkiniz yok.');
        }
        
        // Bu listedeki ve bilinmeyen durumunda olan çevirileri al
        $translations = Translation::whereHas('lists', function($query) use ($list) {
                $query->where('translation_lists.id', $list->id);
            })
            ->whereHas('flashcardProgress', function($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'unknown');
            })
            ->orWhereDoesntHave('flashcardProgress') // Hiç çalışılmamış olanlar
            ->with(['sourceLanguage', 'targetLanguage'])
            ->get();
        
        if ($translations->isEmpty()) {
            return redirect()->route('flashcards.index')
                ->with('info', 'Bu listede bilinmeyen kelime kalmadı! Tebrikler!');
        }
        
        // Çevirileri karıştır
        $translations = $translations->shuffle();
        
        // İlerleme durumunu yükle
        $progressData = [];
        foreach ($translations as $translation) {
            $progress = FlashcardProgress::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'translation_id' => $translation->id
                ],
                [
                    'status' => 'unknown',
                    'last_reviewed_at' => null
                ]
            );
            
            $progressData[$translation->id] = $progress->status;
        }
        
        return view('flashcards.study', compact('list', 'translations', 'progressData'));
    }
    
    /**
     * İlerleme istatistiklerini göster
     */
    public function stats()
    {
        $totalTranslations = Translation::where('user_id', Auth::id())->count();
        $totalProgress = FlashcardProgress::where('user_id', Auth::id())->count();
        $knownCount = FlashcardProgress::where('user_id', Auth::id())
            ->where('status', 'known')
            ->count();
            
        $progressPercentage = $totalProgress > 0 
            ? round(($knownCount / $totalProgress) * 100) 
            : 0;
            
        // Son 7 gündeki ilerlemeyi al
        $dailyProgress = FlashcardProgress::where('user_id', Auth::id())
            ->where('last_reviewed_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('last_reviewed_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->last_reviewed_at)->format('Y-m-d');
            });
            
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = isset($dailyProgress[$date]) ? $dailyProgress[$date]->count() : 0;
            $chartData[$date] = $count;
        }
        
        return view('flashcards.stats', compact(
            'totalTranslations', 
            'totalProgress', 
            'knownCount', 
            'progressPercentage',
            'chartData'
        ));
    }
}
