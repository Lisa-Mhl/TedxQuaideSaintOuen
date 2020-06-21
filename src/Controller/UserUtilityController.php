<?php


namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserUtilityController extends AbstractController
{
    /**
     * @Route("/admin/utility/tags", name="admin_utility_tags" , methods="GET")
     */
    public function getTagsApi(TagRepository $tagRepository, Request $request)
    {
        $tags = $tagRepository->findAllMatching($request->query->get('query'));

        return $this->json([
            'tags' => $tags
        ], 200, [], ['groups' => ['search']]);
    }
}