<?php

namespace App\Tests\Entity;

use App\Entity\Stand;
use PHPUnit\Framework\TestCase;

class StandTest extends TestCase
{
    public function testStandEntity()
    {
        
        $stand = new Stand();

        // Utilisez les méthodes de l'entité pour définir ses propriétés
        $stand->setStandName('Nom du stand');
        $stand->setLocation('Emplacement du stand');

        
        $this->assertEquals('Nom du stand', $stand->getStandName());
        $this->assertEquals('Emplacement du stand', $stand->getLocation());
    }
}