<?php


namespace App\Controller;

use App\Repository\SpeakerRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserUtilityController extends AbstractController
{
    /**
     * @Route("/utility/tags", name="utility_tags" , methods="GET")
     */
    public function getTagsApi(TagRepository $tagRepository, Request $request)
    {
        $tags = $tagRepository->findAllMatching($request->query->get('query'));

        return $this->json([
            'tags' => $tags
        ], 200, [], ['groups' => ['search']]);
    }

    /**
     * @Route("/utility/speakers", name="utility_speakers" , methods="GET")
     */
    public function getSpeakersApi(SpeakerRepository $speakerRepository, Request $request)
    {
        $speakers = $speakerRepository->findAllMatching($request->query->get('query'));

        return $this->json([
            'speakers' => $speakers
        ], 200, [], ['groups' => ['search']]);
    }
}