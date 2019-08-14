<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomController extends AbstractController
{
    /**
     * @Route("/random/{max}", name="random", requirements={"max"="\d+"})
     */
    public function generateRandom(int $max = 6)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://nginx2/static");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $productCount = $repository->count([]);


        return new JsonResponse([
            'data' => rand(1, $max),
            'products' => $productCount,
            'bin' => \json_decode($output ?? '{}'),
        ]);
    }

    /**
     * @Route("/static", name="static")
     */
    public function generateStatic()
    {
        return new JsonResponse([
            'data' => 80
        ]);
    }
}
