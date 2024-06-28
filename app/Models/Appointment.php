<?php

// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Appointment extends Model
{

    use HasFactory;
    use AsSource;

    protected $fillable = [
        'client_id',
        'groomer_id',
        'service_id',
        'appointment_time',
        'status'
    ];

    // Каждая запись (appointment) относится к одному клиенту (client)
    public function client()
    {
    return $this->belongsTo(Client::class);
    }

    // Каждая запись (appointment) относится к одному грумеру (groomer)
    public function groomer()
    {
    return $this->belongsTo(User::class, 'groomer_id');
    }

    // Каждая запись (appointment) связана с одной услугой (service)
    public function service()
    {
    return $this->belongsTo(Service::class);
    }
}
