<?php

namespace Tyras\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tyras\CoreBundle\Form\GalleryType;
use Tyras\CoreBundle\Entity\Gallery;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('TyrasCoreBundle:Default:index.html.twig');
    }

    public function galleryAction()
    {
        $em  = $this->get('doctrine_mongodb')->getManager();

        $gallery = $em->getRepository('TyrasCoreBundle:Gallery')->findAll();

        return $this->render('TyrasCoreBundle:Default:gallery.html.twig', array('gallery' => $gallery));
    }

    public function uploadAction(Request $req)
    {
        $gallery = new Gallery();

        $form = $this->createForm(GalleryType::class, $gallery);

        if ($req->isMethod('POST') && $form->handleRequest($req)->isValid())
        {
            $em  = $this->get('doctrine_mongodb')->getManager();

            $gallery->setSize($gallery->getImageFile()->getSize());
            $gallery->setType($gallery->getImageFile()->getMimeType());

            $user = $em->getRepository('TyrasUserBundle:User')->findOneBy(array('token' => ($gallery->getToken())));

            $gallery->setOwner($user);

            $em->persist($gallery);
            $em->flush();

            return new JsonResponse(array('success' => 'File uploaded'));

            //return $this->redirectToRoute('tyras_news_view', array('id' => $news->getId(), 'slug' => $news->getSlug()));
        }

        return $this->render('TyrasCoreBundle:Default:upload.html.twig', array('form' => $form->createView()));
    }
}