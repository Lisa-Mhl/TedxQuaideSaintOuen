<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Entity\Team;
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

    /**
     * @Route("/utility/youtube_talk", name="youtube_talk")
     */
    public function getYoutubeVideoTalk(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Talk::class);
        $id = $request->query->get('id');
        $talk = $repository->find($id);

        return $this->redirect($talk->getVideo());
    }

    /**
     * @Route("/utility/youtube_article", name="youtube_article")
     */
    public function getYoutubeVideoArticle(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $id = $request->query->get('id');
        $article = $repository->find($id);

        return $this->redirect($article->getVideo());
    }

    /**
     * @Route("/utility/linkedin_speaker", name="linkedin_speaker")
     */
    public function getLinkedinSpeaker(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Speaker::class);
        $id = $request->query->get('id');
        $speaker = $repository->find($id);

        return $this->redirect($speaker->getLink());
    }

    /**
     * @Route("/utility/linkedin_team", name="linkedin_team")
     */
    public function getLinkedinTeam(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Team::class);
        $id = $request->query->get('id');
        $team = $repository->find($id);

        return $this->redirect($team->getLink());
    }
}