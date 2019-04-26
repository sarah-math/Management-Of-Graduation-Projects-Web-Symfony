<?php

/**
 * Created by PhpStorm.
 * User: Trad Ala
 * Date: 06/02/2017
 * Time: 12:50
 */

namespace GestionPfeBundle\Redirection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router) { $this->router = $router; }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // // Tranform this list in array
        $rolesTab = array_map(function($role){ return $role->getRole(); }, $roles);
        // If is a admin or super admin we redirect to the backoffice area

        if (in_array('ROLE_ADMIN', $rolesTab, true) )
            $redirection = new RedirectResponse($this->router->generate('gestion_pfe_admin'));
        else
            if (in_array('ROLE_ENTREPRISE', $rolesTab, true) )
            $redirection = new RedirectResponse($this->router->generate('gestion_pfe_entreprisehomepage'));
        else
            if (in_array('ROLE_ENSEIGNANT', $rolesTab, true) )
            $redirection = new RedirectResponse($this->router->generate('gestion_pfe_enseignanthomepage'));
        else
            $redirection = new RedirectResponse($this->router->generate('gestion_pfe_user'));

        return $redirection;
    }


}