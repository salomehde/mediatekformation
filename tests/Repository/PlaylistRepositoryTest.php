<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\PlaylistRepository;
use App\Entity\Playlist;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author houde
 */
class PlaylistRepositoryTest extends KernelTestCase{
    
    /**
     * Récupère le repository de Playlist
     * @return PlaylistRepository
     */
    public function recupRepository() : PlaylistRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    public function newPlaylist(): Playlist {
        $playlist = (new Playlist())
                ->setName("Nouvelle playlist");
        return $playlist;
    }
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylists+1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderByName(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByName("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(27, $nbPlaylists);
    }
    
    public function testFindAllOrderByNbFormations(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(27, $nbPlaylists);
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "Nouvelle playlist");
        $nbPlaylists = count($playlists);
        $this->assertEquals(1, $nbPlaylists);
        $this->assertEquals("Nouvelle playlist", $playlists[0]->getName());
    }
}
