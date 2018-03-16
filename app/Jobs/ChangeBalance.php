<?php

namespace App\Jobs;

use App\Models\Operation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $config;

    /**
     * Create a new job instance.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $operation = new Operation([
            'user_id' => $this->config['user_id'],
            'operation_costs' => $this->config['amount'],
        ]);

        try {
            $user = User::find($this->config['user_id']);
            $user->balance = $user->balance + $this->config['amount'];
            $user->save();
            $operationStatus = $this->config['isHold'] ? 'hold' : 'accepted';
            $operation->setStatus($operationStatus);
        } catch (\Exception $e) {
            $operation->setStatus('refused');
        }

        $operation->save();
    }
}
