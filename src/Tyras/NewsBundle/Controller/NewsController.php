<?php

namespace Tyras\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tyras\NewsBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tyras\NewsBundle\Form\NewsType;

class NewsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listNews = $em->getRepository('TyrasNewsBundle:News')->findPublishedNews();

        return $this->render('TyrasNewsBundle:News:index.html.twig', array('listNews' => $listNews));
    }

    public function viewAction($id, $slug)
    {
        $em  = $this->getDoctrine()->getManager();

        $news = $em->getRepository('TyrasNewsBundle:News')->find($id);

        //$user = $this->getUser();

        $isAdmin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');

        if (null === $news)
            throw new NotFoundHttpException("Cet article n'existe pas.");
        if (!$isAdmin && (!$news->getEnabled() || new \DateTime() < $news->getDate()))
            throw new NotFoundHttpException("Cet article n'existe pas.");

        return $this->render('TyrasNewsBundle:News:show-news.html.twig', array('news' => $news));
    }

    public function addAction(Request $req)
    {
        $news = new News();

        $form = $this->createForm(NewsType::class, $news);

        if ($req->isMethod('POST') && $form->handleRequest($req)->isValid())
        {
            $em  = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('tyras_news_view', array('id' => $news->getId(), 'slug' => $news->getSlug()));
        }

        return $this->render('TyrasNewsBundle:News:write_news.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id, Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TyrasNewsBundle:News')->find($id);

        if (null === $news)
            throw new NotFoundHttpException("L'annonce d'ID: $id n'existe pas.");

        $form = $this->createForm(NewsType::class, $news);

        if ($req->isMethod('POST') && $form->handleRequest($req)->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('tyras_news_view', array('id' => $news->getId()));
        }
        return $this->render('TyrasNewsBundle:News:add.html.twig', array('news' => $news, 'form' => $form->createView()));
    }

    public function deleteAction($id, Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('TyrasNewsBundle:News')->find($id);

        if (null === $news)
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

        $form = $this->get('form.factory')->create();
        if ($req->isMethod('POST') && $form->handleRequest($req)->isValid())
        {
            $em->remove($news);
            $em->flush();
            return $this->redirectToRoute('tyras_news_admin_list');
        }

        return $this->render('TyrasNewsBundle:News:delete.html.twig', array('news' => $news, 'form' => $form->createView()));
    }

    public function listAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listNews = $em->getRepository('TyrasNewsBundle:News')->findAll();

        return $this->render('TyrasNewsBundle:News:list.html.twig', array('listNews' => $listNews));
    }

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$listNews = $em->getRepository('TyrasNewsBundle:News')->findBy(array('enabled' => true), array('date' => 'DESC'));
        $queryListNews = $em->getRepository('TyrasNewsBundle:News')->findPublishedNews('query');
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryListNews, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('TyrasNewsBundle:News:list-news.html.twig', array('listNews' => $pagination));
    }

    public function newsWidgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$dm = $this->get('doctrine_mongodb')->getManager();

        $listNews = $em->getRepository('TyrasNewsBundle:News')->findBy(array('enabled' => true), array('date' => 'DESC'), 4, 0); //4 dernières news
        //$listNews = $dm->getRepository('TyrasNewsBundle:News')->findBy(array('enabled' => true), array('date' => 'DESC'), 4, 0); //4 dernières news

        return $this->render('TyrasNewsBundle:News:news-widget.html.twig', array('listNews' => $listNews));
    }


}
