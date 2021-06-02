<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Dto\LinksOutput;

/**
 * @ApiResource(
 *      shortName="Links",
 *      collectionOperations={
 *          "get"={
 *              "output"=LinksOutput::class,
 *              "path"="/"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "controller"=NotFoundAction::class,
 *              "read"=false,
 *              "output"=false,
 *           }
 *      },
 *      formats={"json"}
 * )
 */
class ApiLinks
{
    /**
     * @ApiProperty(identifier=true)
     */
    public $id;
}
