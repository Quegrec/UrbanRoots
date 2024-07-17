<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    
    #[Route('/api/site-info', name: 'api_site_info')]
    public function getSiteInfo(): JsonResponse
    {
        $siteName = 'UrbanRoot';
        $data = ['siteName' => $siteName];
        
        return new JsonResponse($data);
    }

}