<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;

    public function __construct($bookingData)
    {
        $this->bookingData = $bookingData;
    }

    public function build()
    {
        return $this->from('no-reply@yogintra.com', 'Yogintra Support')
            ->subject('Your Event Booking Confirmation')
            ->view('emails.booking_confirmation');
    }
}
