<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to TechTought 🚀')
            ->html("
        <div style='background-color:#f4f6f9;padding:40px 0;font-family:Arial,Helvetica,sans-serif;'>
            <div style='max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,0.05);'>

                <!-- Header -->
                <div style='background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);padding:30px;text-align:center;color:#ffffff;'>
                    <h1 style='margin:0;font-size:28px;'>Welcome to TechTought 🚀</h1>
                    <p style='margin:10px 0 0;font-size:14px;opacity:0.9;'>Think Smart. Build Smart.</p>
                </div>

                <!-- Body -->
                <div style='padding:40px 30px;color:#333;'>
                    <h2 style='margin-top:0;'>Hello {$this->user->name}, 👋</h2>

                    <p style='font-size:15px;line-height:1.7;color:#555;'>
                        We're excited to have you on board! Your registration was successful,
                        and now you’re officially part of the <strong>TechTought</strong> community.
                    </p>

                    <p style='font-size:15px;line-height:1.7;color:#555;'>
                        Start exploring courses, enhance your skills, and level up your tech journey with us.
                    </p>

                    <!-- Button -->
                    <div style='text-align:center;margin:35px 0;'>
                        <a href='#' style='background:#2c5364;color:#ffffff;text-decoration:none;
                           padding:14px 28px;border-radius:8px;font-weight:bold;
                           display:inline-block;font-size:14px;'>
                           Go to Dashboard
                        </a>
                    </div>

                    <p style='font-size:13px;color:#888;'>
                        If you have any questions, feel free to contact our support team anytime.
                    </p>
                </div>

                <!-- Footer -->
                <div style='background:#f1f1f1;padding:20px;text-align:center;font-size:12px;color:#777;'>
                    © " . date('Y') . " TechTought. All rights reserved.
                </div>

            </div>
        </div>
        ");
    }
}
