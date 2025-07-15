<x-filament::page>
     <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">طريقة عرض الافلام</div>
        </div>
 
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">عرض افلامي فقط</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('show_movies_only',$event.target.checked)" {{ $data->show_movies_only ? 'checked' : '' }} class="mb-2">

                </div>
            </div>


            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">عرض كل الافلام</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('show_movies_all',$event.target.checked)" {{ $data->show_movies_all ? 'checked' : '' }} class="mb-2">
                     
                </div>
            </div>

            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">الخياران معا</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('show_my_movies_and_all',$event.target.checked)" {{ $data->show_my_movies_and_all ? 'checked' : '' }} class="mb-2">
                     
                </div>
            </div>
 
        </div>
    </div>


    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">طريقة عرض المسلسلات</div>
        </div>
 
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">عرض مسلسلاتي فقط</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('show_series_only',$event.target.checked)" {{ $data->show_series_only ? 'checked' : '' }} class="mb-2">
                </div>
            </div>


            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">عرض كل المسلسلات</div>
                <div>
                    <input type="checkbox" wire:click="updateCard( 'show_series_all',$event.target.checked)" {{$data->show_series_all ? 'checked' : '' }} class="mb-2">
                </div>
            </div>


            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">الخياران معا</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('show_my_series_and_all',$event.target.checked)" {{ $data->show_my_series_and_all ? 'checked' : '' }} class="mb-2">
                </div>
            </div>
 
        </div>
    </div>

    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">Card 2</div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Notification</div>
                <div>
                    <input type="checkbox" wire:click="updateCard('notification',$event.target.checked)" {{ $data->notification ? 'checked' : '' }} class="mb-2">

                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Active</div>
                <div>
                    <input type="checkbox" wire:click="updateCard( 'active',$event.target.checked)" {{$data->active ? 'checked' : '' }} class="mb-2">

                </div>
            </div>
        </div>
    </div>
</div>
</x-filament::page>







{{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">اعدادات واجهة الافلام</div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Movies All</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_movies_all" wire:change="updateCard1('show_movies_all', $event.target.checked)">
                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Series Only</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_series_only" wire:change="updateCard1('show_series_only', $event.target.checked)">
                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Series All</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_series_all" wire:change="updateCard1('show_series_all', $event.target.checked)">
                </div>
            </div>
        </div>
    </div>


    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">إعدادات واجهة المسلسلات</div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Movies All</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_movies_all" wire:change="updateCard1('show_movies_all', $event.target.checked)">
                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Series Only</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_series_only" wire:change="updateCard1('show_series_only', $event.target.checked)">
                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Show Series All</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card1.show_series_all" wire:change="updateCard1('show_series_all', $event.target.checked)">
                </div>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-center items-center p-6 bg-indigo-500 text-black">
            <div class="uppercase tracking-wide text-lg font-bold">إعدادات أخرى</div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Notification</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card2.notification" wire:change="updateCard2('notification', $event.target.checked)">
                </div>
            </div>
            <div class="flex justify-between items-center mb-4 p-2 border border-gray-300 rounded">
                <div class="text-black">Active</div>
                <div>
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" wire:model="card2.active" wire:change="updateCard2('active', $event.target.checked)">
                </div>
            </div>
        </div>
    </div>
</div> --}}
