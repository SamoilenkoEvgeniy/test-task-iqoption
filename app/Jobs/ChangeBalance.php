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
        $this->user = User::find($this->config['user_id']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $isHold = array_key_exists('isHold', $this->config) ? $this->config['isHold'] : false;
        $operation = new Operation([
            'user_id' => $this->config['user_id'],
            'operation_costs' => $this->config['amount'],
        ]);

        \DB::transaction(function () use ($operation, $isHold) {
            try {
                $this->user->balance = $this->user->balance + $this->config['amount'];
                $this->user->save();
                $operationStatus = $isHold ? 'hold' : 'accepted';
                $operation->setStatus($operationStatus);
            } catch (\Exception $e) {
                $operation->setStatus('refused');
                log::error($e->getMessage());
                \DB::rollBack();
            }
        });

        $operation->save();
    }
}
