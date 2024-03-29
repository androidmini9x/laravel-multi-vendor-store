<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;


    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $billing = $this->order->billingAddress;
        
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    ->from('no-reply@store.store', 'Customer Service')
                    ->greeting("Hi, {$notifiable->name}")
                    ->line("A new order #{$this->order->number} created by {$billing->name} from {$billing->country_name}.")
                    ->action('View', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $billing = $this->order->billingAddress;

        return [
            'body' => "A new order #{$this->order->number} created by {$billing->name} from {$billing->country_name}.",
            'icon' => "fas fa-file",
            'url' => url('dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $billing = $this->order->billingAddress;
        return new BroadcastMessage([
            'body' => "A new order #{$this->order->number} created by {$billing->name} from {$billing->country_name}.",
            'icon' => "fas fa-file",
            'url' => url('dashboard'),
            'order_id' => $this->order->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
