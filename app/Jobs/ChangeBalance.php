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
    protected $operationStatus;
    protected $isHold;

    /**
     * Create a new job instance.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->user = User::find($this->config['user_id']);
        $this->isHold = array_key_exists('isHold', $this->config) ? $this->config['isHold'] : false;
        $this->operationStatus = $this->isHold ? 'hold' : 'accepted';
    }

    /**
     * Execute the job.
     * @todo add test for this
     * @return void
     */
    public function handle()
    {
        $operation = new Operation([
            'user_id' => $this->config['user_id'],
            'operation_costs' => $this->config['amount'],
        ]);

        \DB::transaction(function () use ($operation) {
            try {
                if ($this->isHold) {
                    if ($this->config['amount'] < 0 && $this->user->canDoOperation($this->config['amount'])) {
                        $this->user->balance = $this->user->balance + $this->config['amount'];
                    } elseif ($this->config['amount'] < 0) {
                        $this->operationStatus = 'refused';
                    }
                } else {
                    if (
                        ($this->config['amount'] < 0 && $this->user->canDoOperation($this->config['amount'])) ||
                        ($this->config['amount'] > 0)
                    ) {
                        $this->user->balance = $this->user->balance + $this->config['amount'];
                    } else {
                        $this->operationStatus = 'refused';
                    }
                }
                $this->user->save();
                $operation->setStatus($this->operationStatus);
            } catch (\Exception $e) {
                $operation->setStatus('refused');
                log::error($e->getMessage());
                \DB::rollBack();
            }
        });

        $operation->save();
    }
}
