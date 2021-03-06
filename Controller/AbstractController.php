<?php

namespace Akuma\Bundle\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AbstractController
 *
 * @package Akuma\Bundle\SocialBundle\Controller
 * @Route("")
 */
abstract class AbstractController extends Controller
{
    /**
     * @Route("/connect")
     *
     * @Method({"GET", "POST"})
     *
     * @throws \Symfony\Component\Intl\Exception\MethodNotImplementedException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connectAction()
    {
        throw new MethodNotImplementedException(__METHOD__);
    }
}
