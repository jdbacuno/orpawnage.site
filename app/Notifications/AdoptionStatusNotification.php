<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use App\Models\AdoptionApplication;

class AdoptionStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $applicationId;
    protected $oldPickupDate;

    protected $isUserLoggedIn;

    public function __construct(int $applicationId, $oldPickupDate = null, $isUserLoggedIn = false)
    {
        $this->applicationId = $applicationId;
        $this->oldPickupDate = $oldPickupDate;
        $this->isUserLoggedIn = $isUserLoggedIn;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $application = AdoptionApplication::with(['pet', 'user'])->findOrFail($this->applicationId);
        $status = $application->status;
        $transactionNumber = $application->transaction_number;

        // Map status to subject line
        $statusSubjectMap = [
            'picked up' => 'Adoption Completed',
            'to be confirmed' => 'Confirm Your Application',
            'to be scheduled' => 'Set a Pickup Date',
            'adoption on-going' => 'Scheduled for Pickup',
        ];

        $customSubject = $statusSubjectMap[$status] ?? ucwords($status); // fallback to default format

        $mailMessage = (new MailMessage)
            ->subject("Adoption Application - {$customSubject} - Transaction #{$transactionNumber}")
            ->greeting('Hello ' . $application->user->full_name . ',')
            ->line('**Transaction #:** ' . $transactionNumber)
            ->line('**Pet Name:** ' . $application->pet->pet_name)
            ->line('**Application Date:** ' . $application->created_at->format('F j, Y'));

        switch ($application->status) {
            case 'to be confirmed':
                $mailMessage
                    ->line('🎉 We have received your application!')
                    ->line('Please confirm within **24 hours** to proceed with the adoption.')
                    ->action('Confirm Application', URL::signedRoute('adoption.confirm', ['application' => $application->id]))
                    ->line('Failure to confirm within 24 hours will automatically cancel your application.')
                    ->line('We look forward to helping you adopt a pet!');
                break;

            case 'confirmed':
                $mailMessage
                    ->line('✅ Your adoption application has been **confirmed**!')
                    ->line('We are now preparing the pet for adoption. This may take **3–5 business days**.')
                    ->line('You will receive another email to select a schedule to bring your pet home.')
                    ->line('Thank you for your patience and for choosing to adopt!');
                break;

            case 'to be scheduled':
                $mailMessage
                    ->line('📅 You can now select a schedule to bring your pet home!')
                    ->line('Your application is now ready for **scheduling**.')
                    ->action('Select Schedule', url('/transactions/adoption-status'))
                    ->line('Please schedule within **48 hours** to avoid cancellation.')
                    ->line('**Available time slots:** 8:00 AM to 4:00 PM, Monday to Friday.')
                    ->line('**What to bring on your scheduled date:**')
                    ->line('- Valid government-issued ID')
                    ->line('- Copy of this confirmation');
                break;

            case 'adoption on-going':
                $mailMessage
                    ->line('📅 Your new pet is ready to welcome you home!')
                    ->line('**Scheduled Visit Date:** ' . $application->pickup_date->format('F j, Y'))
                    ->line('**Location:** Orpawnage Angeles Main Office')
                    ->line('**On your pickup day, bring:**')
                    ->line('- A valid government-issued ID')
                    ->line('- Your transaction confirmation email')
                    ->line('⚠️ Failure to visit after **3 business days** from your scheduled date will cancel the adoption.')
                    ->line('📸 We\'ll take an official photo of you and your new pet during the handover. The photo will be featured on Angeles City Information Office for documentation.');
                break;

            case 'picked up':
                $mailMessage
                    ->line('🏡 Congratulations! Your adoption is now **complete**.')
                    ->line('**Completion Date:** ' . $application->updated_at->format('F j, Y'))
                    ->line("Thank you for providing a loving home to **{$application->pet->pet_name}**!")
                    ->line('🐾 We would love to see how your new pet is doing! Share updates on our [Facebook page](https://www.facebook.com/ACVeterinaryOffice/).');
                break;

            case 'rejected':
                $mailMessage
                    ->line('We regret to inform you that your adoption application has been **rejected**.')
                    ->line('**Reason for Rejecting:** ' . $application->reject_reason)
                    ->line('We encourage you to:')
                    ->line('- Review our adoption requirements')
                    ->line('- Consider other available pets')
                    ->action('Browse Available Pets', url('/services/adopt-a-pet'));
                break;
        }

        return $mailMessage
            ->line('For any questions, please contact us at orpawnagedevelopers@gmail.com and reference your **transaction number**.')
            ->salutation("Thank you,\nOrpawnage Team");
    }
}
