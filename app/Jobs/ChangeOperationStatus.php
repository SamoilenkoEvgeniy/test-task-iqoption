<?php

namespace App\Jobs;

use App\Models\Operation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

class ChangeOperationStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $operation;
    private $config;
    private $user;

    /**
     * Create a new job instance.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->operation = Operation::find($this->config['operation_id']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::transaction(function () {
            try {
                $this->user = User::where('id', $this->config['user_id'])->lockForUpdate()->first();
                $method = $this->config['action'];
                $this->$method($this->operation);
            } catch (\Exception $e) {
                log::error($e->getMessage());
            }
        });
    }

    public function unHoldAccept($operation)
    {
        if ($operation->operation_costs > 0) {
            $this->user->balance += $operation->operation_costs;
            $this->user->save();
        }
        $operation->setStatus('accepted');
        $operation->save();
    }

    public function unHoldRefuse($operation)
    {
        if ($operation->operation_costs < 0) {
            $this->user->balance += +($operation->operation_costs * -1);
            $this->user->save();
        }
        $operation->setStatus('refused');
        $operation->save();
    }

}
