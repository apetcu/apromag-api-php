<?php


namespace App\Http\Routes\Order\Mail;


use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\Vendor\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable {
    use Queueable, SerializesModels;

    protected $order;
    protected $type;
    protected $vendor;

    public function __construct(String $type, Order $order, Vendor $vendor) {
        $this->order = $order;
        $this->vendor = $vendor;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Comanda #'.$this->order->id.' pe APROZi')
            ->markdown('emails.html.order.'.$this->type.'-created')
            ->with([
                'order' => $this->order,
                'vendor' => $this->vendor,
                'currency' => 'RON'
            ]);
    }
}