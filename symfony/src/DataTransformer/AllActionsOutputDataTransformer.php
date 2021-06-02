<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\DataOutput;
use App\Entity\Action;
use App\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class AllActionsOutputDataTransformer extends AbstractController implements CollectionDataProviderInterface,  RestrictedDataProviderInterface
{
    private $em;
    private $repoAction;
    private $const_prefix;
    private $const_redis_link;
    private $const_short_expiration;
    private $const_long_expiration;

    public function __construct(EntityManagerInterface $em, ActionRepository $repoAction, $const_prefix, $const_redis_link, $const_short_expiration, $const_long_expiration)
    {
        $this->em = $em;
        $this->repoAction = $repoAction;
        $this->const_prefix = $const_prefix;
        $this->const_redis_link = $const_redis_link;
        $this->const_short_expiration = $const_short_expiration;
        $this->const_long_expiration = $const_long_expiration;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Action::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $output = new DataOutput();

        $skip = false;
        $redisLink = $this->const_redis_link;
        $expiration = $this->const_long_expiration;
        $cacheKey = 'AllActions';

        try {
            $cache = RedisAdapter::createConnection($redisLink);
            $cache->exists($cacheKey);
        } catch (Exception $e) {
            $skip = true;
        }
        if ($skip) {
            $msg = $this->queryData();
        } else {
            if (!$cache->exists($cacheKey)) {
                $msg = $this->queryData();
                if (!empty($msg) && !array_key_exists('err', $msg)) {
                    $redisMsg = json_encode($msg);
                    $cache->set($cacheKey, $redisMsg);
                    $cache->expire($cacheKey, $expiration);
                }
            } else {
                $msg = json_decode($cache->get($cacheKey), true);
            }
        }
        $output->setData($msg);
        yield $output;
    }

    private function queryData(): array
    {

        $msg = [];
        $data = $this->repoAction->findAll();

        $prefix = $this->const_prefix;

        foreach ($data as $value) {

            $actionLink = $prefix . "/api/action/" . $value->getId();
            $actionLinkArray = [
                'rel' => 'action_id',
                'href' => $actionLink
            ];

            $links = array($actionLinkArray);

            $dataSend = [
                "id" => $value->getId(),
                "name" => $value->getName(),
                "links" => $links
            ];

            array_push($msg, $dataSend);
        }
        return $msg;
    }
}
