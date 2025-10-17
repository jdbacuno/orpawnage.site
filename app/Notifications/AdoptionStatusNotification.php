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
            'to be scheduled' => 'Selected for Adoption - Schedule Your Visit',
            'adoption on-going' => 'Scheduled for Visit',
        ];

        $customSubject = $statusSubjectMap[$status] ?? ucwords($status);

        $petName = $application->pet->pet_name ?? 'your selected pet';

        $mailMessage = (new MailMessage)
            ->subject("Adoption Application - {$customSubject} - Transaction #{$transactionNumber}")
            ->greeting('Hello ' . $application->user->full_name . ',')
            ->line('**Transaction #:** ' . $transactionNumber);

        if ($application->pet->pet_name) {
            $mailMessage->line('**Pet Name:** ' . $application->pet->pet_name);
        }

        $mailMessage->line('**Application Date:** ' . $application->created_at->format('F j, Y'));

        switch ($application->status) {
            case 'to be confirmed':
                $mailMessage
                    ->line('í°¾ Thank you for submitting your adoption application!')
                    ->line('**Action Required:** Please confirm your application within **24 hours** to proceed.')
                    ->action('Confirm Application', URL::signedRoute('adoption.confirm', ['application' => $application->id]))
                    ->line('âš ï¸ Failure to confirm within 24 hours will automatically cancel your application.')
                    ->line('After confirmation, our team will review your application. Priority is given to Angeles City residents.');
                break;

            case 'confirmed':
                $mailMessage
                    ->line('âœ… Your application has been **confirmed**!')
                    ->line('Our team is now reviewing your application along with others.')
                    ->line('')
                    ->line('**What happens next:**')
                    ->line('â€¢ We conduct background reviews of all confirmed applications')
                    ->line('â€¢ Priority is given to Angeles City residents')
                    ->line('â€¢ If multiple applicants are confirmed, we select based on background check and residency')
                    ->line('')
                    ->line('If you are selected, you will receive a scheduling email.')
                    ->line('Thank you for your patience and for choosing to adopt!');
                break;

            case 'to be scheduled':
                $mailMessage
                    ->line('í¾‰ Congratulations! You have been **selected** to move forward with the adoption' . ($application->pet->pet_name ? ' of **' . $application->pet->pet_name . '**' : '') . '!')
                    ->line('')
                    ->line('**Action Required:** You must schedule your visitation date within **48 hours**. Failure to respond will cancel your application.')
                    ->line('')
                    ->line('**Available visitation dates:** Within the next 7 business days')
                    ->line('**Available time slots:** 8:00 AM to 4:00 PM, Monday to Friday')
                    ->line('')
                    ->line('**On your scheduled visit, please bring:**')
                    ->line('â€¢ Valid government ID (matching the one you submitted)')
                    ->line('â€¢ Your transaction number: **' . $transactionNumber . '**')
                    ->line('')
                    ->line('**During your visit, we will:**')
                    ->line('â€¢ Discuss the pet\'s needs, vaccination, and other care requirements')
                    ->line('â€¢ Answer any questions you may have')
                    ->line('â€¢ Complete the final adoption paperwork')
                    ->line('')
                    ->line('**Good news:** Kittens/puppies 3 months or younger can usually go home immediately as they don\'t require additional taming.')
                    ->action('Schedule Your Visit', url('/transactions/adoption-status'))
                    ->line('**Note:** Other applicants will be notified that a candidate has been selected.');
                break;

            case 'adoption on-going':
                $petNameText = $application->pet->pet_name ?? 'your selected pet';
                $mailMessage
                    ->line('í¿  Your visit has been scheduled!')
                    ->line('')
                    ->line('**Scheduled Visit Date:** ' . $application->pickup_date->format('F j, Y'))
                    ->line('**Location:** Orpawnage Angeles Main Office')
                    ->line('')
                    ->line('**Please bring on your visit:**')
                    ->line('â€¢ Valid government-issued ID (matching the one you submitted)')
                    ->line('â€¢ Your transaction number: **' . $transactionNumber . '**')
                    ->line('')
                    ->line('**During your visit:**')
                    ->line('â€¢ We\'ll discuss **' . $petNameText . '**\'s needs, vaccination, and other care requirements')
                    ->line('â€¢ You can ask any questions you may have')
                    ->line('â€¢ We\'ll complete the adoption paperwork')
                    ->line('â€¢ If **' . $petNameText . '** is 3 months or younger, you may take them home the same day')
                    ->line('')
                    ->line('í³¸ Upon successful pickup, we\'ll take an official photo of you with your new pet. This will be featured on our Facebook page and website for documentation.')
                    ->line('')
                    ->line('âš ï¸ If you cannot make your scheduled visit, please contact us immediately to reschedule.');
                break;

            case 'picked up':
                $petNameText = $application->pet->pet_name ?? 'your new pet';
                $mailMessage
                    ->line('í¾Š Congratulations! Your adoption is now **complete**.')
                    ->line('')
                    ->line('**Completion Date:** ' . $application->updated_at->format('F j, Y'))
                    ->line('')
                    ->line("Thank you for providing a loving home to **{$petNameText}**!")
                    ->line('')
                    ->line('**Important Reminders:**')
                    ->line('â€¢ If **' . $petNameText . '** has health or behavioral issues, you may need to return for follow-up visits')
                    ->line('â€¢ Keep your contact information updated in case we need to reach you')
                    ->line('')
                    ->line('í²š We would love to see how your new pet is doing! Share updates on our [Facebook page](https://www.facebook.com/orpawnage/).')
                    ->line('')
                    ->line('Your official adoption photo will soon be featured on [official website](https://orpawnage.site/featured-adoptions/) and our social media platforms.');
                break;

            case 'rejected':
                $petNameText = $application->pet->pet_name ?? 'the pet';
                $rejectReason = $application->reject_reason ?? 'No reason provided';

                // Check if rejection is due to another applicant being selected
                if ($rejectReason === 'Another applicant has been selected to move forward with the adoption process.') {
                    $mailMessage
                        ->line('Thank you for your interest in adopting **' . $petNameText . '**.')
                        ->line('')
                        ->line('We regret to inform you that another applicant has been selected to move forward with the adoption process for this pet.')
                        ->line('')
                        ->line('**This doesn\'t mean your application wasn\'t good!** We carefully review all applications and sometimes must make difficult decisions when multiple qualified applicants apply for the same pet.')
                        ->line('')
                        ->line('**Background reviews are based on:**')
                        ->line('â€¢ Residency (priority given to Angeles City residents)')
                        ->line('â€¢ Background check results')
                        ->line('â€¢ Application completeness and accuracy')
                        ->line('')
                        ->line('We encourage you to:')
                        ->line('â€¢ Browse our other available pets - there are many wonderful animals waiting for homes')
                        ->line('â€¢ Submit a new application for a different pet')
                        ->line('â€¢ Check back regularly as new pets become available')
                        ->action('Browse Available Pets', url('/services/adopt-a-pet'))
                        ->line('Thank you for choosing to adopt and giving a rescued animal a second chance at life!');
                } else {
                    $mailMessage
                        ->line('We regret to inform you that your adoption application has been **rejected**.')
                        ->line('')
                        ->line('**Reason:** ' . $rejectReason)
                        ->line('')
                        ->line('We encourage you to:')
                        ->line('â€¢ Review our adoption requirements');

                    // Only show this line if there's an actual reason provided
                    if ($application->reject_reason && $application->reject_reason !== 'No reason provided') {
                        $mailMessage->line('â€¢ Address any concerns mentioned in the rejection reason');
                    }

                    $mailMessage
                        ->line('â€¢ Consider applying for other available pets')
                        ->action('Browse Available Pets', url('/services/adopt-a-pet'))
                        ->line('If you have questions about this decision, please contact us and reference your transaction number.');
                }
                break;
        }

        return $mailMessage
            ->line('For any questions, please contact us at orpawnagedevelopers@gmail.com and reference your **transaction number**.')
            ->salutation("Thank you,\nOrpawnage Team");
    }
}
