<?php

namespace App\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultAdminController extends AbstractController
{
    /**
     * @Route("/admin/test", name="app_admin_index")
     */
    public function testAction(): Response
    {
        $this->getUser();

        return $this->render('admin/index.html.twig', ['last_username' => $this->getUser()->getUserIdentifier()]);
    }
}
