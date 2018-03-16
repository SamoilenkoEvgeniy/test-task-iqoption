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
        return $this->hasOne(User::class);
    }

}
