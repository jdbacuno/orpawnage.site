<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdoptionApplication;

class AdoptionStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;
    protected $oldPickupDate;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdoptionApplication $application, $oldPickupDate = null)
    {
        $this->application = $application;
        $this->oldPickupDate = $oldPickupDate;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject("Adoption Application Update")
            ->greeting('Hello ' . $this->application->user->full_name . ',')
            ->line('Transaction #: ' . $this->application->transaction_number)
            ->line('Pet Name: ' . $this->application->pet->pet_name)
            ->line('Application Date: ' . $this->application->created_at->format('F j, Y'));

        switch ($this->application->status) {
            case 'to be confirmed':
                $mailMessage
                    ->line('🎉 We have received your application! Please confirm within 24 hours.')
                    ->line('Scheduled Pickup Date: ' . $this->application->pickup_date->format('F j, Y'))
                    ->line('Location: Angeles City Veterinary Office')
                    ->action('Confirm', url('/transactions/adoption-status'))
                    ->line('Failure to confirm within 24 hours will automatically reject your application.');
                break;
            case 'to be picked up':
                if (
                    $this->application->pickup_date &&
                    $this->oldPickupDate &&
                    $this->application->pickup_date != $this->oldPickupDate
                ) {
                    $mailMessage
                        ->line('📅 Your pet pickup schedule has been updated.')
                        ->line('New Pickup Date: ' . $this->application->pickup_date->format('F j, Y'))
                        ->line('Location: Angeles City Veterinary Office')
                        ->action('View Updated Details', url('/transactions/adoption-status'))
                        ->line('Please bring:')
                        ->line('- A valid government-issued ID');
                } else {
                    $mailMessage
                        ->line('🎉 Your adoption application has been approved!')
                        ->line('Scheduled Pickup Date: ' . $this->application->pickup_date->format('F j, Y'))
                        ->line('Location: Angeles City Veterinary Office')
                        ->action('View Adoption Details', url('/transactions/adoption-status'))
                        ->line('Please bring:')
                        ->line('- A valid government-issued ID');
                }
                break;

            case 'picked up':
                $mailMessage
                    ->line('🏡 Congratulations! Your adoption is now complete.')
                    ->line('Completion Date: ' . $this->application->updated_at->format('F j, Y'))
                    ->line("Thank you for providing a loving home to {$this->application->pet->name}!")
                    ->line('We would love to see how your new pet is doing! Share updates on our [Facebook page](https://www.facebook.com/ACVeterinaryOffice/).');
                break;

            case 'rejected':
                $mailMessage
                    ->line('We regret to inform you that your adoption application has been rejected.')
                    ->line('Reason: ' . $this->application->reject_reason)
                    ->line('We encourage you to:')
                    ->line('- Review our adoption requirements')
                    ->line('- Consider other available pets')
                    ->action('Browse Available Pets', url('/services/adopt-a-pet'));
                break;
        }

        return $mailMessage
            ->line('For any questions, please contact us at orpawnageteam@gmail.com and reference your transaction number.')
            ->salutation("Thank you,\nOrpawnage Team");
    }
}
