<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\ExpressionLanguage\Expression;


class DefaultController extends Controller {

	/**
	 * @Route("/login")
	 */
	public function loginAction() {

		// Autenticacion
		$authenticationUtils = $this->get('security.authentication_utils');
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render(
			'default/login.html.twig',
			array(
				// last username entered by the user
				'last_username' => $lastUsername,
				//Mensaje de error en caso de falla al logging
				'error' => $error
			)
		);
	}

	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction(Request $request) {

		$authChecker = $this->get('security.authorization_checker');
        $requestUri = $request->getRequestUri();

        if($authChecker->isGranted('ROLE_ADMIN')){
        	return $this->redirect($requestUri.'backend');
        }else{
        	return $this->render('default/index.html.twig');
        }
	}

	/**
	 * @Route("/backend")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function indexAdminAction() {
		return $this->render('default/index.html.twig');
	}
}
