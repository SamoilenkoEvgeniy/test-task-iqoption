<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeBalanceRequest;
use App\Http\Requests\ChangeOperationStatusRequest;
use App\Http\Requests\TransferBalanceRequest;
use App\Jobs\ChangeBalance;
use App\Jobs\ChangeOperationStatus;
use App\Jobs\TransferBalance;

class TaskController extends Controller
{
    /**
     * @param ChangeBalanceRequest $request
     */
    public function changeBalance(ChangeBalanceRequest $request)
    {
        ChangeBalance::dispatch($request->only([
            'amount', 'isHold', 'user_id'
        ]));
    }

    /**
     * @param ChangeOperationStatusRequest $request
     */
    public function changeOperationStatus(ChangeOperationStatusRequest $request)
    {
        ChangeOperationStatus::dispatch($request->only([
            'action', 'operation_id'
        ]));
    }

    /**
     * @param TransferBalanceRequest $request
     */
    public function transferBalance(TransferBalanceRequest $request)
    {
        TransferBalance::dispatch($request->only([
            'from',
            'to',
            'amount'
        ]));
    }
}
