<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'borrowed_at',
        'returned_at',
        'due_date',
        'user_id',
        'book_id',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class)->orderBy('created_at','desc');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
