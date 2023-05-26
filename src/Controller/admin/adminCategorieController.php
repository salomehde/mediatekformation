<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\Categorie;
use App\Form\CategorieType;

const PAGE_ADMIN_CATEGORIES = "admin/admin.categories.html.twig";
const ADMIN_CATEGORIES = 'admin.categories';

/**
 * Description of adminCategorieController
 *
 * @author houde
 */
class adminCategorieController extends AbstractController {
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("/admin/categories", name="admin.categories")
     * @return Response
     */
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(PAGE_ADMIN_CATEGORIES, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    
    /**
     * @Route("/admin/suppr/categorie/{id}", name="admin.categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie) : Response{
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute(ADMIN_CATEGORIES);
    }

    /**
     * @Route("/admin/ajout/categorie", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);
        if($formCategorie->isSubmitted() && $formCategorie->isValid()){
            $this->categorieRepository->add($categorie, true);
            return $this->redirectToRoute(ADMIN_CATEGORIES); 
        }
        return $this->render("admin/admin.categorie.ajout.html.twig", [ 
            'categorie' => $categorie,
            'formCategorie' => $formCategorie->createView() 
        ]);
    }
    
}
