<?php

namespace App\Controller;

use App\Entity\VideoLabel;
use Doctrine\ORM\EntityManagerInterface;

class VideoLabelController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function __invoke(EntityManagerInterface $em, VideoLabel $data, $id)
    {
        $videoLabel = $this->em->getRepository(VideoLabel::class)->find($id);

        $description = $data->getDescription();
        $label = $data->getLabel();

        if(!is_null($description)){
            $videoLabel->setDescription($description);
        }
        if(!is_null($label)){
            $videoLabel->setLabel($label);
        }

        return $videoLabel;
    }
}
