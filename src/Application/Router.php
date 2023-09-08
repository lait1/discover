<?php
declare(strict_types=1);

namespace App\Application;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class Router implements RouterInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function generate(string $name, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_URL): string
    {
        return 'https://discover-georgia.com/telegram/webhook';

        return $this->router->generate($name, $parameters, $referenceType);
    }

    public function setContext(RequestContext $context)
    {
        return $this->router->setContext($context);
    }

    public function getContext()
    {
        return $this->router->getContext();
    }

    public function getRouteCollection()
    {
        return $this->router->getRouteCollection();
    }

    public function match(string $pathinfo)
    {
        return $this->router->match($pathinfo);
    }
}
