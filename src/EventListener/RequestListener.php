<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Listens on every request and sets the "Access-Control-Allow-Origin" & other headers.
 */
class RequestListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $this->setCorsHeaders($event);
    }

    private function setCorsHeaders(ResponseEvent $event)
    {
        // Don't do anything if it's not the main request
        if (!$event->isMainRequest()) {
            return;
        }

        $response = $event->getResponse();

        $response->headers->add([
            "Content-Type" => "application/json",
            "Access-Control-Allow-Origin" => $_ENV["ALLOWED_ORIGIN"]
        ]);
    }

}
