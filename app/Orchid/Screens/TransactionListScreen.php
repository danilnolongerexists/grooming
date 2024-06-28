<?php

namespace App\Orchid\Screens;

use App\Models\Transaction;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class TransactionListScreen extends Screen
{
        /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'transactions' => Transaction::all()
        ];
    }

        /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Транзакции';
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить транзакции')
            ->icon('plus')
                ->route('platform.transaction.edit')
        ];
    }
    public function layout(): array
    {
        return [
            Layout::table('transactions', [
                TD::make('type', 'Тип')
                ->sort()
                ->render(function (Transaction $transaction) {
                    return Link::make($transaction->type)
                        ->route('platform.transaction.edit', $transaction);
                }),
                TD::make('amount', 'Сумма')->sort(),
                TD::make('description', 'Описание')->sort(),
                TD::make('date', 'Дата')->sort(),
            ]),
        ];
    }
}
