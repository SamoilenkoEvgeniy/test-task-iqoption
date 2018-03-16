<?php

namespace App\Jobs;

use App\Models\Operation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeOperationStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $operation;
    private $config;

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
        $this->$this->config['action']($this->operation);
    }

    public function unHoldAccept($operation)
    {
        $operation->setStatus('accepted');
        $operation->save();
    }

    public function unHoldRefuse($operation)
    {
        $user = $operation->user;
        $user->balance = $user->balance + $operation->operation_cost;
        $user->save();
        $operation->setStatus('refused');
        $operation->save();
    }

    /**
     * @param $operation
     */
    public function refuse($operation)
    {
        $user = $operation->user;
        $user->balance = $user->balance - $operation->operation_cost;
        $user->save();
        $operation->setStatus('refused');
        $operation->save();
    }
}
