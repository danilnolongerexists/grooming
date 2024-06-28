<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class ServiceEditScreen extends Screen
{

    public $service;

    /**
    * Fetch data to be displayed on the screen.
    *
    * @return array
    */
    public function query(Service $service): array
    {
        return [
            'service' => $service
        ];
    }

        /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->service->exists ? 'Отредактировать услугу' : 'Создать новую услугу';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create product')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->service->exists),

            Button::make('ОБновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->service->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->service->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('service.name')
                    ->title('Название услуги')
                    ->placeholder('Введите название услуги')
                    ->required(),

                Input::make('service.description')
                    ->title('Описание')
                    ->placeholder('Введите описание услуги'),

                Input::make('service.price')
                    ->title('Цена')
                    ->type('number')
                    ->step(0.01)
                    ->placeholder('Введите цену услуги')
                    ->required(),

                Input::make('service.duration')
                    ->title('Длительность (в минутах)')
                    ->type('number')
                    ->placeholder('Введите длительность услуги')
                    ->required()
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->service->fill($request->get('service'))->save();

        Alert::info('Вы сохранили услугу!');

        return redirect()->route('platform.service.list');
    }

    public function remove()
    {
        $this->service->delete();

        Alert::info('Вы удалили услугу.');

        return redirect()->route('platform.service.list');
    }
}
