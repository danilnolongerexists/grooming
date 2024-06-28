<?php

// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Transaction extends Model
{

    use HasFactory;
    use AsSource;
    protected $fillable = [
        'type',
        'amount',
        'description',
        'date'
    ];

// В модели Transaction нет прямых отношений с другими моделями в данном примере
}
