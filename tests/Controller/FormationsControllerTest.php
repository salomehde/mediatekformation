<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author houde
 */
class FormationsControllerTest extends WebTestCase{
    
    public function testTriFormationASC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    public function testTriFormationDESC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/DESC');
        $this->assertSelectorTextContains('h5', 'UML : Diagramme de paquetages');
    }
    
    public function testTriPlaylistASC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°74 - POO : collections');
    }
    
    public function testTriPlaylistDESC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/DESC/playlist');
        $this->assertSelectorTextContains('h5', 'C# : ListBox en couleur');
    }
    
    public function testTriCategorie(){
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Python'
        ]);
        $this->assertSelectorTextContains('h5', "Python n°18 : Décorateur singleton");
    }
    
    public function testTriDateASC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/ASC');
        $this->assertSelectorTextContains('h5', "Cours UML (1 à 7 / 33) : introduction et cas d'utilisation");
    }
    
    public function testTriDateDESC(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/DESC');
        $this->assertSelectorTextContains('h5', "Eclipse n°8 : Déploiement");
    }
    
    public function testFiltreFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/title');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'UML : Diagramme de classes'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la formation correspond à la recherche
        $this->assertSelectorTextContains('h5', 'UML : Diagramme de classes');
    }
    
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET','/formations/recherche/name/playlist');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours'
        ]); 
        $this->assertCount(27, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Cours Merise/2 extensions');
    }
    
    public function testLinkFormation(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations');
        //clic sur un lien
        $client->clickLink('miniature formation');
        //récupération du résultat du clic
        $response = $client->getResponse();
        //contrôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        //récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/1', $uri);
        $this->assertSelectorTextContains('h4', 'Eclipse n°8 : Déploiement');
    }
}
