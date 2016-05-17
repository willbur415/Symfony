<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCPlatformBundle:Advert:index.html.twig');
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