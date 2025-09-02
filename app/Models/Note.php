<?php

namespace App\Models;

use App\Application\Note\Enum\NoteStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    // Локальный скоуп для выборки записей со статусом Allowed
    #[Scope]
    protected function allowed(Builder $query): void
    {
        $query->where('status', NoteStatusEnum::ALLOWED->value);
    }
}
