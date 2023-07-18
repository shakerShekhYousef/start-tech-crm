<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendpaymentinfoemail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $payment, $span;
    public function __construct($payment, $span)
    {
        $this->payment = $payment;
        $this->span = $span;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->span == 1) {
            return $this->subject('Upcomming payment after 1 month')
                ->markdown('mail')
                ->with([
                    'property' =>  $this->payment->property,
                    'paymentdate' =>  $this->payment->date_of_payment,
                    'paymentamount' =>  $this->payment->payment_amount
                ]);
        }
        else if($this->span == 2)
        {
            return $this->subject('Upcomming payment after two weeks')
            ->markdown('mail')
            ->with([
                'property' =>  $this->payment->property,
                'paymentdate' =>  $this->payment->date_of_payment,
                'paymentamount' =>  $this->payment->payment_amount
            ]);
        }
    }
}
