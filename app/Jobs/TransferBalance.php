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

class TransferBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $config;
    private $user_from;
    private $user_to;

    /**
     * Create a new job instance.
     *
     * @param $config
     */
    public function __construct($config)
    {
        log::error('here');
        $this->config = $config;
        $this->user_from = User::find($this->config['from']);
        $this->user_to = User::find($this->config['to']);

    }

    /**
     * Execute the job.
     * @todo add check balance user from
     * @return void
     */
    public function handle()
    {
        $operation_from = new Operation([
            'user_id' => $this->config['from'],
            'operation_costs' => $this->config['amount'] * -1,
        ]);

        \DB::transaction(function () use ($operation_from) {
            try {
                $this->user_from->balance -= $this->config['amount'];
                $this->user_to->balance += $this->config['amount'];
                $this->user_from->save();
                $this->user_to->save();
                $operation_from->setStatus('accepted');
                $operation_to = new Operation([
                    'user_id' => $this->config['to'],
                    'operation_costs' => $this->config['amount'],
                ]);
                $operation_to->setStatus('accepted');
                $operation_to->save();
            } catch (\Exception $e) {
                $operation_from->setStatus('refused');
                log::error($e->getMessage());
                \DB::rollBack();
            }
        });
        $operation_from->save();
    }
}
