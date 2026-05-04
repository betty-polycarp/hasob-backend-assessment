<?php

namespace DMO\SavingsBond\Notifications;

use DMO\SavingsBond\Models\BrokerStaff;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BrokerStaffDeletedNotification extends Notification
{
    use Queueable;

    public $brokerStaff;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(BrokerStaff $brokerStaff)
    {
        $this->brokerStaff = $brokerStaff;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('BrokerStaff deleted successfully')
            ->markdown(
                'mail.brokerStaffs.deleted',
                ['brokerStaff' => $this->brokerStaff]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
