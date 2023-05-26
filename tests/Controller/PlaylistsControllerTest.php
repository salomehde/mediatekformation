<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author houde
 */
class PlaylistsControllerTest extends WebTestCase{
    
    public function testTriPlaylistASC(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    public function testTriPlaylistDESC(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
    }
    
    public function testTriCategorie(){
        $client = static::createClient();
        $client->request('GET', '/playlists/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Java'
        ]);
        $this->assertSelectorTextContains('h5', "Eclipse et Java");
    }
    
    public function testTriNbFormationsASC(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/nbformations/ASC');
        $this->assertSelectorTextContains('h5', 'Cours Informatique embarquée');
    }
    
    public function testTriNbFormationsDESC(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/nbformations/DESC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET','/playlists/recherche/name');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours'
        ]); 
        $this->assertCount(11, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Cours Composant logiciel');
    }
    
    public function testLinkPlaylist(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists');
        $client->clickLink('Voir détail');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4', 'Bases de la programmation (C#)');
    }
}
