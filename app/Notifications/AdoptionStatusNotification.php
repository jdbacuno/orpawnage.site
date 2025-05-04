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
            ->subject("Adoption Application - " . ucwords($this->application->status) . " - Transaction #{$this->application->transaction_number}")
            ->greeting('Hello ' . $this->application->user->full_name . ',')
            ->line('Transaction #: ' . $this->application->transaction_number)
            ->line('Pet Name: ' . $this->application->pet->pet_name)
            ->line('Application Date: ' . $this->application->created_at->format('F j, Y'));

        switch ($this->application->status) {
            case 'to be confirmed':
                $mailMessage
                    ->line('🎉 We have received your application!')
                    ->line('Please confirm within 24 hours to proceed with the adoption.')
                    ->action('Confirm Application', url('/confirm-application/' . $this->application->id))
                    ->line('Failure to confirm within 24 hours will automatically cancel your application.')
                    ->line('We look forward to helping you adopt a pet!');
                break;
            case 'confirmed':
                $mailMessage
                    ->line('✅ Your adoption application has been confirmed!')
                    ->line('We are now preparing the pet for adoption. This may take 3–5 business days.')
                    ->line('You will receive another email once your pickup schedule is ready.')
                    ->line('Thank you for your patience and for choosing to adopt!');
                break;
            case 'to be picked up':
                $mailMessage
                    ->line('📅 Your adoption pickup schedule is now available!')
                    ->line('Scheduled Pickup Date: ' . $this->application->pickup_date->format('F j, Y'))
                    ->line('Location: Angeles City Veterinary Office')
                    ->action('Confirm Pickup Date', url('/transactions/adoption-status'))
                    ->line('Please confirm this date within 48 hours. No response will result in automatic cancellation.')
                    ->line('On your pickup day, bring:')
                    ->line('- A valid government-issued ID')
                    ->line('- Your transaction confirmation email')
                    ->line('Failure to pick up within 3 business days after your scheduled date will cancel the adoption.')
                    ->line('We’ll take an official photo of you and your new pet during the pickup.');
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
