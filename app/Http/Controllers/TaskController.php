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
    public function changeBalance(ChangeBalanceRequest $request)
    {
        $user_id = $request->input('user_id');
        $isHold = $request->has('isHold');
        $amount = $request->has('amount') ? $request->input('amount') : 1;
        ChangeBalance::dispatch([
            'user_id' => $user_id,
            'amount' => $amount,
            'isHold' => $isHold
        ]);
    }

    public function changeOperationStatus(ChangeOperationStatusRequest $request)
    {
        $operation_id = $request->input('operation_id');
        // @todo make validator for actions
        $action = $request->input('action');
        ChangeOperationStatus::dispatch([
            'operation_id' => $operation_id,
            'action' => $action
        ]);
    }

    public function transferBalance(TransferBalanceRequest $request)
    {
        TransferBalance::dispatch($request->only([
            'from',
            'to',
            'amount'
        ]));
    }
}
