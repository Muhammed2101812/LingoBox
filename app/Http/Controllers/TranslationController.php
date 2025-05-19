<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Language;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $translations = Translation::where('user_id', Auth::id())
            ->with(['sourceLanguage', 'targetLanguage'])
            ->latest()
            ->paginate(10); // Sayfalama ekleyelim

        return view('translations.index', compact('translations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('translations.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $request)
    {
        $validatedData = $request->validated();
        Log::info('Translation store attempt: Validated data', $validatedData);

        $userId = Auth::id();
        Log::info('Translation store attempt: User ID', ['user_id' => $userId]);

        if (!$userId) {
            Log::error('User ID is null during translation store. User may not be authenticated.');
            return redirect()->back()
                             ->with('error', 'Kullanıcı oturumu bulunamadı. Lütfen tekrar giriş yapın.')
                             ->withInput();
        }

        try {
            $dataToCreate = $validatedData;
            $dataToCreate['user_id'] = $userId;

            Translation::create($dataToCreate);

            Log::info('Translation saved successfully for user_id: ' . $userId);
            return redirect()->route('dashboard')->with('success', 'Çeviri başarıyla eklendi!');

        } catch (\Exception $e) {
            Log::error('Error saving translation: ' . $e->getMessage(), [
                'exception' => $e,
                'validated_data' => $validatedData,
                'user_id' => $userId
            ]);
            
            return redirect()->back()
                             ->with('error', 'Çeviri kaydedilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.')
                             ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        // Kullanıcının bu çeviriyi görüntüleme yetkisi var mı?
        $this->authorize('view', $translation);

        // İlişkili dil verilerini yükle (eğer index'te yüklenmediyse veya farklı bir senaryo ise)
        $translation->load(['sourceLanguage', 'targetLanguage']);

        return view('translations.show', compact('translation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Translation $translation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Translation $translation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        //
    }
}
