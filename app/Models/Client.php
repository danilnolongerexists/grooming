<?php

// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Client extends Model
{

    use HasFactory;
    use AsSource;

    protected $fillable = [
        'name',
        'contact_info',
        'preferences'
    ];

    // Один клиент может иметь много записей (appointments)
    public function appointments()
    {
    return $this->hasMany(Appointment::class);
    }


    public function getNameAttribute()
    {
    return $this->attributes['name'];
    }

    public function getContactInfoAttribute()
    {
    return $this->attributes['contact_info'];
    }

    public function getPreferencesAttribute()
    {
    return $this->attributes['preferences'];
    }
}
