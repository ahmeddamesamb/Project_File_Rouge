<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource(

    collectionOperations:
    [
        "catalogue"=>[
            "method"=>"get",
            "path"=>"/catalogue",
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
