<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('這是一封密碼重置郵件，如果是您本人操作，請點擊以下按鈕繼續:')
            ->action('重置密碼', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('如果您並沒有執行此操作，您可以選擇忽略此郵件。');
    }
}