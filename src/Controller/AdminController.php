<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }
}
