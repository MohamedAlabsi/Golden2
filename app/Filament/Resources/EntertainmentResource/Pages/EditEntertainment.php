<?php

namespace App\Filament\Resources\EntertainmentResource\Pages;

use App\Filament\Resources\EntertainmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntertainment extends EditRecord
{
    protected static string $resource = EntertainmentResource::class;

    protected function afterCreate(): void
    {
        $this->saveTitleTranslations();
        $this->saveOverviewTranslations();
    }

    protected function afterSave(): void
    {
        $this->saveTitleTranslations();
        $this->saveOverviewTranslations();
    }

    protected function saveTitleTranslations(): void
    {
        $lang = $this->data['original_language'] ?? 'ar';

        $original = $this->data['original_title'] ?? '';
        $alt = $this->data['title'] ?? '';

        // تطبيق القاعدة المطلوبة
        $title = $lang === 'ar'
            ? ['ar' => $original, 'en' => $alt]
            : ['ar' => $alt, 'en' => $original];

        $this->record->forgetAllTranslations('title');
        $this->record->title = $title;
        $this->record->save();
    }

    protected function saveOverviewTranslations(): void
    {
        $lang = $this->data['original_language'] ?? 'ar';

        $overview_ar = $this->data['overview_ar'] ?? '';
        $overview_en = $this->data['overview_en'] ?? '';
        $overview = $lang === 'ar'
            ? ['ar' => $overview_ar, 'en' => $overview_en]
            : ['ar' => $overview_ar, 'en' => $overview_en];

        $this->record->forgetAllTranslations('overview');
        $this->record->overview = $overview;
        $this->record->save();
    }
    public function mount(...$params): void
    {
        parent::mount(...$params);



        if ($this->record) {
            $lang = $this->record->original_language ?? 'ar';
            $popularity = $this->record->popularity  ;
            $vote_average = $this->record->vote_average  ;
            $genre_ids = $this->record->genre_ids  ;
            $media_type_id = $this->record->media_type_id  ;
            $poster_path = $this->record->poster_path  ;
            $release_date = $this->record->release_date  ;
            $title = $this->record->getTranslations('title') ?? [];
            $overview = $this->record->getTranslations('overview') ?? [];

            $this->form->fill([
                'original_language' =>$lang,
                'popularity' =>$popularity,
                'poster_path' =>$poster_path,
                'release_date' =>$release_date,
                'vote_average' =>$vote_average,
                'genre_ids' => $genre_ids,
                'media_type_id' =>$media_type_id,
                'original_title' => $lang === 'ar' ? ($title['ar'] ?? '') : ($title['en'] ?? ''),
                'title' => $lang === 'ar' ? ($title['en'] ?? '') : ($title['ar'] ?? ''),
                'overview_ar' => $overview['ar'] ?? '',
                'overview_en' => $overview['en'] ?? '',
            ]);
        }


    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
