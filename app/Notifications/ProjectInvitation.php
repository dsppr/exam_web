<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $inviter;

    /**
     * Buat instance notifikasi baru.
     *
     * @param  $project
     * @param  $inviter
     */
    public function __construct($project, $inviter)
    {
        $this->project = $project;
        $this->inviter = $inviter;
    }

    /**
     * Tentukan saluran pengiriman notifikasi.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Tentukan representasi notifikasi dalam email.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Anda Diundang ke Proyek ' . $this->project->name)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line($this->inviter->name . ' mengundang Anda untuk bergabung dalam proyek ' . $this->project->name . '.')
            ->action('Lihat Proyek', url('/projects/' . $this->project->id))
            ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Tentukan representasi notifikasi dalam basis data.
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
            'message' => $this->inviter->name . ' mengundang Anda ke proyek ' . $this->project->name,
        ];
    }
}
