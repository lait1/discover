<?php

namespace App\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultAdminController extends AbstractController
{
    /**
     * @Route("/admin/{vueRouting}", name="app_admin_index")
     */
    public function indexAction(): Response
    {
        $this->getUser();

        return $this->render('admin/index.html.twig');
    }
}
