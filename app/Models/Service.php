<?php

// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Service extends Model
{

    use HasFactory;
    use AsSource;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration'
    ];

    // Одна услуга может быть предоставлена в множество записей (appointments)
    public function appointments()
    {
    return $this->hasMany(Appointment::class);
    }
}
