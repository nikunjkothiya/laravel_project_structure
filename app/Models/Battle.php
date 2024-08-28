<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Battle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int>
     */
    protected $fillable = [
        'monsterA',
        'monsterB',
        'winner',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the monster A that owns the battle.
     */
    public function monsterA(): BelongsTo
    {
        return $this->belongsTo(Monster::class, 'monsterA');
    }

    /**
     * Get the monster B that owns the battle.
     */
    public function monsterB(): BelongsTo
    {
        return $this->belongsTo(Monster::class, 'monsterB');
    }

    /**
     * Get the winner of the battle.
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(Monster::class, 'winner');
    }
}
