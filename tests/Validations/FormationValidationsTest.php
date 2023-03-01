<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Validations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Formation;

/**
 * Description of FormationValidationsTest
 *
 * @author houde
 */
class FormationValidationsTest extends KernelTestCase {
    
    public function getFormation(): Formation {
        return (new Formation())
                ->setTitle("Nouvelle formation");
    }
    
    public function assertErrors(Formation $formation, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testValidPublishedAtFormation(){
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getFormation()->setPublishedAt($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($plustot), 0, "plus tôt devrait réussir");
    }

    public function testNonValidPublishedAtFormation(){
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getFormation()->setPublishedAt($plustard), 1, "plus tard devrait échouer");
    }
}
