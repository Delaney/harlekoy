<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\AttributeUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property array $attributes
 * @property bool $processed
 *
 * @method static unProcessed()
 */
final class UserAttributesUpdate extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'attributes',
        'processed',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attributes' => 'array',
        ];
    }

    protected static function booted()
    {
        static::created(function (UserAttributesUpdate $userAttributesUpdate) {
            event(new AttributeUpdated($userAttributesUpdate));
        });
    }

    /**
     * @param User $user
     * @param array $changes
     *
     * @return UserAttributesUpdate $userAttributesUpdate
     */
    public static function createUpdate(User $user, array $changes): self
    {
        return self::create([
            'email' => $user->email,
            'attributes' => $changes,
        ]);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeUnprocessed(Builder $query): void
    {
        $query->where('processed', false);
    }
}
