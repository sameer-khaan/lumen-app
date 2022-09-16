<?php
 
namespace App\Mail;
 
use App\Models\Users;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;
 
    /**
     * The user instance.
     *
     * @var \App\Models\Users
     */
    public $user;
 
    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Users  $user
     * @return void
     */
    public function __construct(Users $user)
    {
        $this->user = $user;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome')->with(['fullName' => $this->user->firstname]);
    }
}