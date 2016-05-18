<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdvertController extends Controller
{
    public function indexAction()
    {
        return $this->render('@OCPlatform/Advert/index.html.twig');
    }

    public function viewAction($id)
    {
        return new Response("Affichage de l'annonce avec l'id: ".$id);
    }

    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response("File name: ".$slug.".".$_format." date :".$year);
    }
}