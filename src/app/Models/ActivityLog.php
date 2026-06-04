<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ActivityLog – simple audit table for user actions.
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ActivityLog extends Model
{
    use HasFactory;

    // Table created by migration 2026_06_04_120000_create_activity_logs_table.php
    protected $table = 'activity_logs';

    // Mass‑assignable columns
    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    /** The user who performed the activity */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
