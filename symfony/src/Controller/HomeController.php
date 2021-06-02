<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController  extends AbstractController
{
    
    /**
     * @Route("/",name="home")
     */
    public function home()
    {   
        return $this->redirect('/api');
    }

}