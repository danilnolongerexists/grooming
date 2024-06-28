<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class ServiceListScreen extends Screen
{

        /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'services' => Service::all()
        ];
    }

        /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Услуги';
    }


    public function commandBar(): array
    {
        return [
            Link::make('Добавить услугу')
                ->icon('plus')
                ->route('platform.service.edit')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('services', [
                TD::make('name', 'Название')
                ->sort()
                ->render(function (Service $service) {
                    return Link::make($service->name)
                        ->route('platform.service.edit', $service);
                }),

                TD::make('description', 'Описание')->sort(),
                TD::make('price', 'Цена')->sort(),
                TD::make('duration', 'Длительность (в минутах)')->sort(),
            ]),
        ];
    }
}

