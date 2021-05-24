<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Dto\LogsOutput;
use App\Entity\Log;
use App\Entity\Session;

class LogOutputDataTransformer extends AbstractController  implements DataTransformerInterface
{
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct($const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }
 /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        dump("ok");
        //$output = new LogsOutput();
        //$output->session = $data->getSession();
        //$output->action = $data->getAction();
        return false;

    }
    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof CheeseListing && $to === CheeseListingOutput::class;
    }

}