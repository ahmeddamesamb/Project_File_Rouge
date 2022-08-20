<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(

    collectionOperations:
    [
        "catalogue"=>[
            "method"=>"get",
            "path"=>"/catalogue",
            // "normalization_context" =>['groups'=>["catalogue"]]
        ]
        ],
        itemOperations:[
            
        ]
        ,
        normalizationContext:
        [
            "groups"=>[
                "catalogue:read"
            ]
        ]
)]
class Catalogue
{

}
