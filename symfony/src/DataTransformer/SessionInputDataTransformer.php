<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Log;
use App\Entity\Session;
use App\Entity\Action;
use App\Entity\Video;
use App\Entity\AccountLabel;
use App\Entity\Label;
use App\Entity\Capture;
use App\Service\MessageService;


final class SessionInputDataTransformer extends AbstractController  implements DataTransformerInterface
{
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;
    private $messageService;

    public function __construct(MessageService $messageService, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
        $this->messageService = $messageService;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $em = $this->getDoctrine()->getManager();

        $email = $data->email;

        $newSession = new Session();
        $newSession->setId($data->id);

        $accountSearch = $this->getDoctrine()
            ->getRepository(AccountLabel::class)
            ->findOneBy(["email" => $data->email]);

        if (!is_null($accountSearch)) {
            $newSession->setAccountLabel($accountSearch);
        }

        $em->persist($newSession);

        return $newSession;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Session) {
            return false;
        }

        return Session::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
