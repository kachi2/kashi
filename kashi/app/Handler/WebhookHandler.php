<?php 
namespace App\Handler;


use \Spatie\WebhookClient\ProcessWebhookJob;

class WebhookHandler extends ProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

      logger($this->webhookCall);
    }
}

?>
