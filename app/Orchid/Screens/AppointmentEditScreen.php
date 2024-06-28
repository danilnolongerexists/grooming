<?php

namespace App\Orchid\Screens;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class AppointmentEditScreen extends Screen
{

    public $appointment;

        /**
    * Fetch data to be displayed on the screen.
    *
    * @return array
    */
    public function query(Appointment $appointment): array
    {
        return [
            'appointment' => $appointment
        ];
    }

            /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->appointment->exists ? 'Отредактировать расписание' : 'Создать новое расписание';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать расписание')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->appointment->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->appointment->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->appointment->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Relation::make('appointment.client_id')
                    ->fromModel(Client::class, 'name')
                    ->title('Клиент')
                    ->required(),

                Relation::make('appointment.groomer_id')
                    ->fromModel(User::class, 'name')
                    ->title('Грумер')
                    ->required(),

                Relation::make('appointment.service_id')
                    ->fromModel(Service::class, 'name')
                    ->title('Услуга')
                    ->required(),

                DateTimer::make('appointment.appointment_time')
                    ->title('Время записи')
                    ->enableTime()
                    ->required(),

                Input::make('appointment.status')
                    ->title('Статус')
                    ->placeholder('Введите статус записи')
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->appointment->fill($request->get('appointment'))->save();

        Alert::info('Вы сохранили расписание!');

        return redirect()->route('platform.appointment.list');
    }

    public function remove()
    {
        $this->appointment->delete();

        Alert::info('Вы удалили расписание.');

        return redirect()->route('platform.appointment.list');
    }
}

