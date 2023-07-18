<?php

namespace App\Jobs;

use App\Mail\sendpaymentinfoemail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class sendpaymentinfojob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $payment, $user, $span;
    public function __construct($payment, $user, $span)
    {
        $this->payment = $payment;
        $this->user = $user;
        $this->span = $span;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->bcc("test1@wowproperties.ae", "info")->send(new sendpaymentinfoemail($this->payment, $this->span));
        $this->sendsms($this->payment, $this->span);
    }

    public function sendsms($payment, $span)
    {
        try {
            $account_sid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
            $auth_token = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $twilio_number = config('app.twilio')['TWILIO_NUMBER'];

            $client = new Client($account_sid, $auth_token);
            if ($span == 1) {
                $client->messages->create(
                    "+971506704560",
                    array(
                        'from' => $twilio_number,
                        'body' => "Upcomming payment after 1 month, " . "property: " . $payment->property .
                            " -paymentdate: " . $payment->date_of_payment .
                            " -paymentamount: " . $payment->payment_amount
                    )
                );
            }
            if ($span == 2) {
                $client->messages->create(
                    "+971506704560",
                    array(
                        'from' => $twilio_number,
                        'body' => "Upcomming payment after two weeks, " . "property: " . $payment->property .
                            " -paymentdate: " . $payment->date_of_payment .
                            " -paymentamount: " . $payment->payment_amount
                    )
                );
            }
            return response()->json(['success' => true, 'message' => 'success']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }
}
