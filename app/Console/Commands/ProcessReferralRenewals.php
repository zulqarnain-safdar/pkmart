<?php

namespace App\Console\Commands;

use App\Services\ReferralService;
use Illuminate\Console\Command;

class ProcessReferralRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referrals:process-renewals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process monthly referral code renewals';

    /**
     * Execute the console command.
     */
    public function handle(ReferralService $referralService)
    {
        $this->info('Processing referral code renewals...');
        
        $renewedCount = $referralService->processMonthlyRenewals();
        
        $this->info("Successfully processed {$renewedCount} referral code renewals.");
        
        return 0;
    }
}