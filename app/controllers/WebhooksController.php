<?php
use Laravel\Cashier\WebhookController;

class WebhooksController extends WebhookController{
    public function handleWebhook()
    {
        $webhook = json_decode(Request::getContent());
        switch ($webhook->type)
        {
            case 'invoiceitem.created':
                Event::fire('invoiceitem.created',$webhook);
        }
        return parent::handleWebhook();
    }
} 