<?php

namespace App\Filament\Resources\AccountSettingResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\AccountSettingResource;
use App\Models\AccountSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountSettings extends ListRecords
{
    protected static string $resource = AccountSettingResource::class;
    protected string $view = 'livewire.card-component';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function updateCard($name,$value)
    {
       $accountSetting=  AccountSetting::where('id',1)->first();
       switch ($name) {
        case 'show_movies_only':
            $accountSetting->show_movies_only=$value;
            $accountSetting->show_movies_only=$value;
            break;

        case 'show_movies_all':
                # code...
             break;   

        case 'show_my_movies_and_all':
                # code...
                break;
    
        case 'show_series_only':
                    # code...
                 break;  
        case 'show_series_all':
                    # code...
                    break;
        
        case 'show_my_series_and_all':
                        # code...
                     break;
                     
        case 'notification':
                        # code...
                     break;   
        case 'active':
                        # code...
                     break;    

        default:
            # code...
            break;
       }
    }


    protected function getViewData(): array
    {

 
        return [
            'data' =>   AccountSetting::where('id',1)->first(), 
        ];
       

    }
}
