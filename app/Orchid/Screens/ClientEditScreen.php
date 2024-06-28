<?php

namespace App\Orchid\Screens;

use App\Models\Client;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Support\Facades\Toast;

class ClientEditScreen extends Screen
{
    public $client;
    /**
    * Fetch data to be displayed on the screen.
    *
    * @return array
    */
    public function query(Client $client): array
    {
        return [
            'client' => $client
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->exists ? 'Отредактировать клиента' : 'Создать нового клиента';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать клиента')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->client->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->client->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->client->exists),
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
            Layout::rows([
                Input::make('client.name')
                    ->title('Имя')
                    ->placeholder('Введите имя клиента')
                    ->required(),

                Input::make('client.contact_info')
                    ->title('Контактные данные')
                    ->placeholder('Введите контактные данные клиента')
                    ->required(),

                TextArea::make('client.preferences')
                    ->title('Предпочтения')
                    ->rows(3)
                    ->placeholder('Введите предпочтения клиента (порода животного, тип услуги и т. д.)'),
            ]),
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->client->fill($request->get('client'))->save();

        Alert::info('Вы сохранили клиента!');

        return redirect()->route('platform.client.list');
    }

    public function remove()
    {
        $this->client->delete();

        Alert::info('Вы удалили клиента.');

        return redirect()->route('platform.client.list');
    }
}
