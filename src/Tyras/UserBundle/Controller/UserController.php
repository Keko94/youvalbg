<?php

namespace Tyras\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tyras\UserBundle\Entity\User;

class UserController extends Controller
{
    public function loginAction(Request $req)
    {
        if ($req->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('TyrasUserBundle:User')->findOneBy(array('username' => $req->request->get('username'),
                                                                                'password' => $req->request->get('password')
                                                                                ), null);

            if (null !== $user)
                return $this->render('TyrasUserBundle:Default:login.html.twig', array('success' => $user->getUsername().' connected successfully !'));

            return $this->render('TyrasUserBundle:Default:login.html.twig', array('error' => 'Username or password incorrect.'));
        }
        return $this->render('TyrasUserBundle:Default:login.html.twig');
    }

    public function registerAction(Request $req)
    {
        if ($req->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

        }

        return $this->render('TyrasUserBundle:Default:register.html.twig');
    }
}
