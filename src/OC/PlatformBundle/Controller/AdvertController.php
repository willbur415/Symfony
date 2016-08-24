<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdvertController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $listAdverts = array(
            array(
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime())
        );

        return $this->render('OCPlatformBundle:Advert:index.html.twig', array('listAdverts' => $listAdverts));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert)
        {
            throw new NotFoundHttpException("l'annonce d'id ".$id."n'existe pas.");
        }

        $listApplication = $em->getRepository('OCPlatformBundle:Application')
            ->findBy(array('advert' => $advert));

        return $this->render('@OCPlatform/Advert/view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplication
        ));
    }

    public function addAction(Request $request)
    {
        //Advert
        $advert = new Advert();
        $advert->setDate(new \DateTime());
        $advert->setTitle("Recherche développeur Symfony.");
        $advert->setAuthor("William");
        $advert->setContent("Nous recherchons un développeur Symfony.");
        $advert->setDate(new \DateTime());

        $image = new Image();
        $image->setUrl("test.png");
        $image->setAlt("test");
        $advert->setImage($image);

        //Applications
        $application1 = new Application();
        $application1->setAuthor("George");
        $application1->setContent("J'ai 8000 raisons d'être engagé");

        $application2 = new Application();
        $application2->setAuthor("Jeanne");
        $application2->setContent("j'ai 8000 + 1 raisons d'être engagé");

        $application1->setAdvert($advert);
        $application2->setAdvert($advert);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($advert);
        $em->persist($application1);
        $em->persist($application2);

        $em->flush();

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');

            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('@OCPlatform/Advert/add.html.twig');

        return $this->render('@OCPlatform/Advert/add.html.twig');
    }

    public function editAction($id, Request $request)
    {
            $advert = array(
                'title' => 'Recherche développeur Symfony',
                'id' => $id,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Québec.',
                'date' => new \DateTime()
            );
        return $this->render('@OCPlatform/Advert/edit.html.twig', array('advert' => $advert));
    }
    
    public function deleteAction($id)
    {
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }
    
    public function menuAction($limit)
    {
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));

    }
}