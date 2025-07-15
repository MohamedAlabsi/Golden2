<?php

namespace App\Livewire;

use App\Models\AccountSetting;
use Livewire\Component;

 
class CardComponent extends Component
{
    public $card1;
    public $card2;

    public function mount($card1, $card2)
    {
        $this->card1 = $card1;
        $this->card2 = $card2;
    }

    public function updateCard1($property, $value)
    {
        dd($property, $value);
        $this->card1[$property] = $value;
        AccountSetting::find(1)->update([$property => $value]);
    }

    public function updateChecke(  $value)
    {
        dd( $value); 
    }
 

    public function updateCard2($property, $value)
    {
        dd($property, $value);
        $this->card2[$property] = $value;
        AccountSetting::find(1)->update([$property => $value]);
    }

    public function render()
    {
        return view('livewire.card-component');
    }
}