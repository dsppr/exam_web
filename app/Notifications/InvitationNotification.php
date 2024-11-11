<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Project;
use App\Models\User;

class InvitationNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $sender;

    public function __construct(Project $project, User $sender = null)
    {
        $this->project = $project;
        $this->sender = $sender ?? new User(); // Memberikan default User jika null
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("You have been invited to join the project: {$this->project->name}")
            ->action('View Project', url("/projects/{$this->project->id}"))
            ->line("Invited by: {$this->sender->name}");
    }

    public function toArray($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'sender_name' => $this->sender->name,
            'message' => "You have been invited to join the project: {$this->project->name}",
        ];
    }
}
