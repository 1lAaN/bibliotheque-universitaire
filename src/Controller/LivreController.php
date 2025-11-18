<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
class LivreController extends AbstractController
{
    private array $livres = [
        1 => [
            'id' => 1,
            'titre' => 'Introduction aux Algorithmes',
            'auteur' => 'Thomas H. Cormen',
            'isbn' => '978-2100545261',
            'genre' => 'informatique',
            'annee_publication' => 2010,
            'nombre_pages' => 1200,
            'disponible' => true,
            'nombre_exemplaires' => 3,
            'resume' => 'Manuel de référence couvrant les algorithmes fondamentaux et les structures de
               données.',
            'editeur' => 'Dunod',
            'cote' => 'INF.004.COR'
        ],
        2 => [
            'id' => 2,
            'titre' => 'Le Rouge et le Noir',
            'auteur' => 'Stendhal',
            'isbn' => '978-2070360024',
            'genre' => 'litterature',
            'annee_publication' => 1830,
            'nombre_pages' => 720,
            'disponible' => false,
            'nombre_exemplaires' => 0,
            'resume' => 'Roman emblématique du XIXe siècle suivant les ambitions de Julien Sorel.',
            'editeur' => 'Gallimard',
            'cote' => 'LIT.840.STE'
        ],
        3 => [
            'id' => 3,
            'titre' => 'Physique Quantique - Fondements et Applications',
            'auteur' => 'Michel Le Bellac',
            'isbn' => '978-2759807802',
            'genre' => 'sciences',
            'annee_publication' => 2013,
            'nombre_pages' => 450,
            'disponible' => true,
            'nombre_exemplaires' => 2,
            'resume' => 'Introduction moderne à la mécanique quantique avec applications pratiques.',
            'editeur' => 'EDP Sciences',
            'cote' => 'PHY.530.LEB'
        ]
    ];
    #[Route('/catalogue', name: 'app_catalogue_list')]
    public function index(): Response
    {
        return $this->render('/catalogue/index.html.twig', [
            'livres' => $this->livres
        ]);
    }

    /* ID */
    #[Route('/livre/{id}', name: 'app_catalogue_detail')]
    public function detail(int $id): Response
    {
        // verifie si l'id du livre existe si il marche pas il envoie une exception qui dit que le livre est pas trouvé sinon il rutrun les info du livre 
        if (!isset($this->livres[$id])) {
            throw $this->createNotFoundException('ERREUR 404 : Livre non trouvé');
        }
        return $this->render('catalogue/detail.html.twig', [
            'livre' => $this->livres[$id]
        ]);

    }

    /* GENRE */
    #[Route('/catalogue/genre/{genre}', name: 'app_catalogue_genre')]
    public function genre(string $genre): Response
    {
        $livresParGenre = []; // creer un tableau vide pour stocker les livres du genre demandé
        // parcourir tous les livres et vérifier leur genre
        foreach ($this->livres as $livre) {
            if ($livre['genre'] === $genre) {
                $livresParGenre[] = $livre;
            }
        }
        // si aucun livre n'a été trouvé pour le genre demandé, lancer une exception 404
        if (empty($livresParGenre)) {
            throw $this->createNotFoundException('ERREUR 404 : Genre non trouvé');
        }
        // sinon, rendre la vue avec les livres du genre demandé
        return $this->render('catalogue/genre.html.twig', [
            'livres' => $livresParGenre
        ]);

    }

    // API
    #[Route('/api/catalogue', name: 'api_livres_list')]
    public function apiCatalogue() : JsonResponse{
        return $this->json($this->livres);
    }

    // STATS
    #[Route('/statistique', name:'livres_stats')]
    public function statistiques(): Response
    {
        $nombreLivres = count($this->livres);
        $genres = [];
        foreach ($this->livres as $livre) {
            $genres[] = $livre['genre'];
        }
        $genres = array_count_values($genres);

        $livreDispo = [];
        foreach ($this->livres as $livre) {
            



        return $this->render('catalogue/statistiques.html.twig', [
            'nombre_livres' => $nombreLivres,
            'genres' => $genres
        ]);
    }

}