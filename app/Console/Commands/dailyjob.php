<?php

namespace App\Console\Commands;

use App\Jobs\sendpaymentinfojob;
use App\Mail\sendpaymentinfoemail;
use App\Models\Payment;
use App\Models\User;
use DateTime;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Exception;

class dailyjob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email and sms before 1 month of upcomming payment, before two months of upcomming payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // send email before 1 month
        $payments = Payment::all();
        $users = User::all();
        foreach ($payments as $key => $payment) {
            $paymentdate = Carbon::parse($payment->date_of_payment);
            $user = $users->where('id', $payment->buyer_id)->first();
            $today = Carbon::now();
            $days = $paymentdate->diffInDays($today);
            if ($days == 30) {
                $span = 1;
                sendpaymentinfojob::dispatch($payment, $user, $span);
            } else if ($days == 14) {
                $span = 2;
                sendpaymentinfojob::dispatch($payment, $user, $span);
            }
        }
    }
}
