<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Domain\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private ClientService $clientService;

    public function __construct(
        ClientService $clientService
    ) {
        $this->clientService = $clientService;
    }

    /**
     * @Route("/client/get-clients", methods={"GET"})
     */
    public function getClientsAction(): Response
    {
        return $this->json($this->clientService->getAllClients());
    }
}
