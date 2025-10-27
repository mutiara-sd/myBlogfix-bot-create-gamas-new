<?php

namespace App\Models\Assurance\Bot;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BotCreateGamas extends Model
{
    protected $connection = 'assurance';

    protected $table = 'BOT_BINDING_GAMAS';

    public $incrementing = false;

    protected $primaryKey = null;

    public $timestamps = false;

    protected $fillable = ['agent_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public static function homeQuery()
    {
        return self::where('status', 'VALID')->whereNull('agent_id');
    }

    public static function inbox(User $user)
    {
        return self::where('agent_id', $user->id)
            ->whereNull('perbaikan')
            ->whereBetween(DB::raw("DATE_FORMAT(time_update, '%Y%m%d')"), [
                now()->subDays(6)->format('Ymd'),
                now()->format('Ymd'),
            ])
            ->orderByDesc('time_update');
    }

    public static function allList($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->subDays(30)->format('Ymd');
        $endDate = $endDate ?? now()->format('Ymd');

        return self::whereBetween(DB::raw("DATE_FORMAT(time_update, '%Y%m%d')"), [
            $startDate,
            $endDate,
        ])
            ->orderByDesc('time_update');
    }
}
