<?php

namespace App\Orchid\Screens;

use App\Models\Appointment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;

class AppointmentListScreen extends Screen
{

        /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'appointments' => Appointment::all()
        ];
    }

        /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Расписания';
    }


    public function commandBar(): array
    {
        return [
            Link::make('Добавить расписание')
                ->icon('plus')
                ->route('platform.appointment.edit')
        ];
    }

        /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('appointments', [
                TD::make('client.name', 'Клиент')
                ->sort()
                ->render(function (Appointment $appointment) {
                    return Link::make($appointment->client->name)
                        ->route('platform.appointment.edit', $appointment);
                }),
                TD::make('groomer.name', 'Грумер')
                ->sort()
                ->render(function (Appointment $appointment) {
                    return Link::make($appointment->groomer->name)
                        ->route('platform.appointment.edit', $appointment);
                }),
                TD::make('service.name', 'Услуга')
                ->sort()
                ->render(function (Appointment $appointment) {
                    return Link::make($appointment->service->name)
                        ->route('platform.appointment.edit', $appointment);
                }),
                TD::make('appointment_time', 'Время записи')->sort(),
                TD::make('status', 'Статус')->sort()
            ]),
        ];
    }
}
