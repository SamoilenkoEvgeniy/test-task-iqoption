<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'user_id',
        'operation_costs',
        'operation_status',
        'work_status'
    ];
    protected $operationStatuses = [
        'hold',
        'accepted',
        'refused'
    ];

    /**
     * @param string $status
     */
    public function setStatus($status = '')
    {
        if (in_array($status, $this->operationStatuses)) {
            $this->operation_status = $status;
        } else {
            // @todo make handler
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getHoldSum($user_id)
    {
        return self::whereUserId($user_id)->whereOperationStatus('hold')->where('operation_costs', '<',
            0)->sum('operation_costs');
    }

}
