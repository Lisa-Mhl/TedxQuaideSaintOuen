<?php

namespace App\Service;

use App\Entity\Speaker;
use App\Entity\Tag;
use App\Entity\Talk;
use Doctrine\ORM\EntityManagerInterface;

class Searcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function searchByTagSpeaker($data)
    {
        if ($data === null) {
            return $talk = $this->em->getRepository(Talk::class)->findAll();
        } else {
            $tag = $this->em->getRepository(Tag::class)->findOneBy(['name' => $data]);
            if ($tag === null) {
                $speaker = $this->em->getRepository(Speaker::class)->findOneBy(['name' => $data]);
                if ($speaker === null) {
                    return $talk = $this->em->getRepository(Talk::class)->findOneBy(['title' => $data]);
                } else {
                    return $talk = $speaker->getTalks();
                }
            } else {
                return $talk = $tag->getTalks();
            }
        }
    }
}

