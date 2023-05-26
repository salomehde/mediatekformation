<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\FormationRepository;
use App\Entity\Formation;
use DateTime;

/**
 * Description of FormationRepositoryTest
 *
 * @author houde
 */
class FormationRepositoryTest extends KernelTestCase {
    
    /**
     * Récupère le repository de Formation
     * @return FormationRepository
     */
    public function recupRepository() : FormationRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function newFormation(): Formation {
        $formation = (new Formation())
                ->setTitle("Nouvelle formation")
                ->setPublishedAt(new \DateTime('2023-02-02'));
        return $formation;
    }
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations+1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllOrderBy("title", "ASC");
        $nbFormations = count($formations);
        $this->assertEquals(237, $nbFormations);
    }
    
    public function testFindAllOrderByJoinTable(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllOrderByJoinTable("name", "ASC", "playlist");
        $nbFormations = count($formations);
        $this->assertEquals(237, $nbFormations);
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValue("title", "Nouvelle formation");
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
        $this->assertEquals("Nouvelle formation", $formations[0]->getTitle());
    }
    
    public function testFindByContainValueTable(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValueTable("name", "Programmation sous Python", "playlist");
        $nbFormations = count($formations);
        $this->assertEquals(19, $nbFormations);
    }
    
    public function testFindAllLasted(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $lastFormation = $repository->findAllLasted(1);
        $this->assertEquals(new DateTime('2023-02-02'), $lastFormation[0]->getPublishedAt());
    }
    
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findAllForOnePlaylist(3);
        $nbFormations = count($formations);
        $this->assertEquals(19,$nbFormations);
    }
}
