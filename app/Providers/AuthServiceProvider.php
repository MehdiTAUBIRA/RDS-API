<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       /* VerifyEmail::toMAilUsing(
            function(object $notifiable, string $url)
        {
            $verificationCode = $this->generateVerificationCodeFor($notifiable);

            return (new MailMessage)
            ->subject('Activation du compte')
            ->from('administrator@iceb.com')
            ->view('mail.auth.verification', [
                "code_number" => str_split($verificationCode->code),
            ]);
        });

        VerifyEmail::createUrlUsing(function($notifiable){
            return'';
        });*/
    }
}
