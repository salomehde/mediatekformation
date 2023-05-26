<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;

/**
 * Description of CategorieRepositoryTest
 *
 * @author houde
 */
class CategorieRepositoryTest extends KernelTestCase{
    
    /**
     * Récupère le repository de Categorie
     * @return CategorieRepository
     */
    public function recupRepository() : CategorieRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function newCategorie(): Categorie {
        $categorie = (new Categorie())
                ->setName("Nouvelle catégorie");
        return $categorie;
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories+1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $categories = $repository->findAllForOnePlaylist(13);
        $nbCategories = count($categories);
        $this->assertEquals(2, $nbCategories);
        $this->assertEquals("C#",$categories[0]->getName());
    }
    
    public function testFindAll(){
        $repository = $this->recupRepository();
        $categories = $repository->findAll();
        $nbCategories = count($categories);
        $this->assertEquals(9, $nbCategories);
    }
}
