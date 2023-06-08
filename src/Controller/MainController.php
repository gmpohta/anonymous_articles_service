<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\File;
use App\Type\ArticleType;

class MainController extends AbstractController
{
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name:'create_new_article')] 
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($article);
            $this->em->flush();
            return $this->redirectToRoute('render_article', ['id' => $article->getId()]);
        }

        return $this->render('new-page.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'render_article', requirements: ['id' => '\d+'])] 
    public function renderAction(int $id)
    {
        $article = $this->em
            ->getRepository(Article::class)
            ->findOneBy(['id' => $id]);

        if (!$article) {
            throw $this->createNotFoundException(sprintf('Article with id "%s" not found.', $id));
        }

        $mayEdit = false;//

        return $this->render('page.html.twig', [
            'article' => $article,
            'mayEdit' => $mayEdit
        ]);
    }

     #[Route('/upload', name:'upload_file')]
    public function uploadFileAction(Request $request): JsonResponse
    {
        $files = $request->files->all();
        if (empty($files)) {
            return new JsonResponse(
                [], 400
            );
        }

        $fileToUpload = new File();
        dump($files[0]);
        $fileToUpload->setFile($files[0]);
        $this->em->persist($fileToUpload);
        $this->em->flush();

        return new JsonResponse(
            $fileToUpload->getPath(), 200
        );
    }
}