<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ClientListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Клиенты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить клиента')
                ->icon('plus')
                ->route('platform.client.edit'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('clients', [
                TD::make('name', 'Название')
                ->sort()
                ->render(function (Client $client) {
                    return Link::make($client->name)
                        ->route('platform.client.edit', $client);
                }),
                TD::make('contact_info', 'Контактные данные')->sort(),
                TD::make('preferences', 'Предпочтения')->sort(),
            ]),
        ];
    }
}
