<?php
/**
 * Custom Artisan Command to send registration invite for application
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\RegistrationInviteCreated;
use App\Models\RegistrationInvite;
use Illuminate\Support\Str;

class SendRegisterInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:send
                            {emails* : array of emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send registration invitation to specified email addresses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->argument('emails');

        foreach ($emails as $email) {
            do {
                $token = Str::random(40);
            } while (RegistrationInvite::where('token', $token)->first());
    
            // insert invite in the database 
            $invite = RegistrationInvite::firstOrCreate([
                'email' => $email
            ],
            [
                'token' => $token,
            ]);
            
            // Dispatch event to send the email
            $res = event(new RegistrationInviteCreated($invite));
            $link = $res[0];

            // Print info message with generated registration link
            $this->info("Sent register invite to: {$email} \n[invitation url: {$link}] \n");
        }
    }
}
