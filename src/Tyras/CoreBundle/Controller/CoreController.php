<?php

namespace Tyras\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('TyrasCoreBundle:Default:index.html.twig');
    }

    public function galleryAction()
    {
        return $this->render('TyrasCoreBundle:Default:gallery.html.twig');
    }
}