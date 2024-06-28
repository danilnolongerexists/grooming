<?php

namespace App\Orchid\Screens;

use App\Models\Transaction;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class TransactionEditScreen extends Screen
{

    public $transaction;

     /**
    * Fetch data to be displayed on the screen.
    *
    * @return array
    */
    public function query(Transaction $transaction): array
    {
        return [
            'transaction' => $transaction
        ];
    }

            /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->transaction->exists ? 'Отредактировать транзакцию' : 'Создать новую транзакцию';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать транзакцию')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->transaction->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->transaction->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->transaction->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('transaction.type')
                    ->title('Тип')
                    ->placeholder('Введите тип транзакции (Доход/Расход)')
                    ->required(),

                Input::make('transaction.amount')
                    ->title('Сумма')
                    ->type('number')
                    ->step(0.01)
                    ->placeholder('Введите сумму транзакции')
                    ->required(),

                Input::make('transaction.description')
                    ->title('Описание')
                    ->placeholder('Введите описание транзакции'),

                DateTimer::make('transaction.date')
                    ->title('Дата')
                    ->required()
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->transaction->fill($request->get('transaction'))->save();

        Alert::info('Вы сохранили транзакцию!');

        return redirect()->route('platform.transaction.list');
    }

    public function remove()
    {
        $this->transaction->delete();

        Alert::info('Вы удалили транзакцию.');

        return redirect()->route('platform.transaction.list');
    }
}
