public function toMail($notifiable)
{
    // **Important Pet Details**
    $speciesLabel = $this->pet->species === 'feline' ? 'Cat' : 'Dog';
    $petNumber = $this->pet->pet_number;
    $petName = $this->pet->pet_name && strtolower($this->pet->pet_name) !== 'n/a'
        ? "**{$this->pet->pet_name} (#{$petNumber})**"
        : "**Pet #{$petNumber}**";

    $ageDescription = $this->pet->age
        ? "**{$this->pet->age}-year-old**"
        : "";

    $adoptionDate = now()->format('F j, Y');

    $mail = (new MailMessage)
        ->subject("í¾‰ {$speciesLabel} #{$petNumber} Has Found a Loving Home!")
        ->greeting('**Great News!**')
        ->line("We're thrilled to announce that our {$ageDescription} {$speciesLabel}, {$petName}, has been **successfully adopted!**")
        ->line("This sweet {$speciesLabel} found their **forever home** on **{$adoptionDate}**.")
        ->line("**Thank you** to everyone who supported this {$speciesLabel}'s journey and considered giving them a home.")
        ->line("**Stay tuned** for more adoption success stories!")
        ->action("**View Our Available Pets**", url('/services/adopt-a-pet'))
        ->line("**Together, we're making a difference** in these animals' lives.")
        ->salutation("**With gratitude,**\nThe Orpawnage Team");

    // âœ… Attach the pet image
    if ($this->pet->image_path && file_exists(storage_path('app/public/' . $this->pet->image_path))) {
        $mail->attachFromStorageDisk('public', $this->pet->image_path, 'pet-image.jpg');
    }

    return $mail;
}
