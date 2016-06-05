<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Game extends Entity
{
    protected $_accessible = [
        'title' => true,
        'image_path' => true,
    ];
}
