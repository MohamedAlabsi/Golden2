<?php

namespace App\Filament\Resources\EntertainmentResource\Pages;

use App\Filament\Resources\EntertainmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEntertainment extends CreateRecord
{
    protected static string $resource = EntertainmentResource::class;
//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $lang = $data['original_language'];
//        $data['title'] = $lang === 'ar'
//            ? ['ar' => $data['original_title'], 'en' => $data['title']]
//            : ['ar' => $data['title'], 'en' => $data['original_title']];
//
//        return $data;
//    }
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
    protected function afterFormFilled(): void
    {
        $overview = $this->record->getTranslations('overview');

        $this->form->fill([
            'overview_ar' => $overview['ar'] ?? '',
            'overview_en' => $overview['en'] ?? '',
            'original_language' => $this->record->original_language,

        ]);
    }

}
