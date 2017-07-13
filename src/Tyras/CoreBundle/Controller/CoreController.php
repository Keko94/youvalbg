<?php

namespace Tyras\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tyras\CoreBundle\Form\GalleryType;
use Tyras\CoreBundle\Entity\Gallery;
use blackknight467\StarRatingBundle\Form\RatingType;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('TyrasCoreBundle:Default:index.html.twig');
    }

    public function galleryAction(Request $req)
    {
        $em  = $this->get('doctrine_mongodb')->getManager();

        $gallery = $em->getRepository('TyrasCoreBundle:Gallery')->findAll();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $noteForm = array();

        foreach ($gallery as $k => $image)
        {
            if (!$image->isUserVoted($currentUser)) {
                $noteForm[$k] = $this->createFormBuilder()
                    ->add('note', RatingType::class, array('label' => false))
                    ->add('imageId', HiddenType::class, array('data' => $image->getId()))
                    ->add('Valider', SubmitType::class, array('attr' => array('class' => 'nk-btn nk-btn-rounded nk-btn-color-main-1 nk-btn-hover-color-info')))
                    ->getForm();

                if ($req->isMethod('POST') && $noteForm[$k]->handleRequest($req)->isValid()) {
                    $datas = $noteForm[$k]->getData();
                    if ($datas['note'] > 0 && $datas['note'] <= 5) {
                        $image = $em->getRepository('TyrasCoreBundle:Gallery')->find($datas['imageId']);
                        if (!$image->isUserVoted($currentUser)) {
                            $image->setStars($image->getStars() + $datas['note']);
                            $image->addUsersVoted($currentUser);
                            $em->persist($image);
                            $em->flush($image);
                        }
                    }
                }
            }
        }

        return $this->render('TyrasCoreBundle:Default:gallery.html.twig', array('gallery' => $gallery, 'forms' => $noteForm));
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