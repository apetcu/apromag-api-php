<?php


namespace App\Http\Routes\Order\Mail;


use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\Vendor\Models\Vendor;
use Doctrine\DBAL\Types\StringType;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChangeMail extends Mailable {
    use Queueable, SerializesModels;

    protected $order;
    protected $newStatus;
    protected $remarks;
    protected $vendor;

    public function __construct(Order $order, Vendor $vendor, String $newStatus, $remarks) {
        $this->order = $order;
        $this->newStatus = $newStatus;
        $this->remarks = $remarks ? $remarks : '';
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $statusTitle = $this->getTitle($this->newStatus);
        $statuAction = $this->getAction($this->newStatus);
        return $this->subject('Comanda #'.$this->order->id.' a fost actualizata')
            ->markdown('emails.html.order.status-update')
            ->with([
                'order' => $this->order,
                'vendor' => $this->vendor,
                'title' => $statusTitle,
                'action' => $statuAction,
                'remarks' => $this->remarks,
                'currency' => 'RON'
            ]);
    }
    
    private function getAction($status){
        switch ($status) {
            case 'IN_PROGRESS':
                return "Comanda ta a fost confirmată!";
            case 'SHIPPED':
                return "Comanda este in drum spre tine!";
            case 'COMPLETED':
                return "Comanda a fost anulata!";
            case 'CANCELED':
                return "Comanda a fost finalizată!";
            default:
                return "Comanda a fost modificată";
        }
    }    
    
    private function getTitle($status){
        switch ($status) {
            case 'IN_PROGRESS':
                return "a confirmat";
            case 'SHIPPED':
                return "a expediat";
            case 'COMPLETED':
                return "a finalizat";
            case 'CANCELED':
                return "a anulat";
            default:
                return "a modificat";
        }
    }
}