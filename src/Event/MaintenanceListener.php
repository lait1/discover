<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class MaintenanceListener
{
    private Environment $twig;

    private string $maintenance;

    public function __construct(Environment $twig, string $maintenance)
    {
        $this->maintenance = $maintenance;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $isMaintenance = \filter_var($this->maintenance ?? '0', \FILTER_VALIDATE_BOOLEAN);

        if ($isMaintenance) {
            $event->setResponse(
                new Response(
                    $this->twig->render('maintenance.html.twig'),
                    Response::HTTP_SERVICE_UNAVAILABLE,
                )
            );
            $event->stopPropagation();
        }
    }
}
