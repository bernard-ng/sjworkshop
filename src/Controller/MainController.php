<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class MainController extends AbstractController
{

    /**
     * @Route(name="app_home", path="", methods={"GET"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(): Response
    {
        return $this->render("pages/home.html.twig");
    }

    /**
     * @Route(name="app_contact", path="/contact", methods={"GET", "POST"})
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function contact(): Response
    {
        return $this->render("pages/contact.html.twig");
    }
}
