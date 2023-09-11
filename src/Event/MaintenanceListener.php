<?php
declare(strict_types=1);

namespace App\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class MaintenanceListener
{
    private const API_PREFIX = '/api';
    private const ADMIN_PREFIX = '/admin';

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

        $request = $event->getRequest();
        if ($this->isAdminPath($request) || $this->isApiPath($request)) {
            return;
        }

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

    private function isApiPath(Request $request): bool
    {
        return 0 === strpos($request->getPathInfo(), self::API_PREFIX);
    }

    private function isAdminPath(Request $request): bool
    {
        return 0 === strpos($request->getPathInfo(), self::ADMIN_PREFIX);
    }
}
