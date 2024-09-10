<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Domain\UseCase\Forum\Topic\FindTopic;
use Domain\Request\Topic\FindTopicRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    #[Route(path:"/forum", name:"forum_home")]
    public function index(TopicRepository $topicRepository): Response
    {
        $findTopics = new FindTopic($topicRepository);
        $findTopicRequest = new FindTopicRequest();

        $topics = $findTopics->execute($findTopicRequest)->getTopics();

        return $this->render("forum/topic_list.html.twig", [
            "topics"=> $topics
        ]);
    }

    // /**
    //  * @Route("/forum/topic/{id}", name="forum_topic")
    //  */
    // public function showTopic(int $id, Request $request, EntityManagerInterface $em): Response
    // {
    //     // Fetch the topic by its ID
    //     $topic = $em->getRepository(Topic::class)->find($id);

    //     // If topic doesn't exist, show 404 page
    //     if (!$topic) {
    //         throw $this->createNotFoundException('Topic not found');
    //     }

    //     // Handle new post submission (create eco-friendly forms by keeping them simple)
    //     $post = new Post();
    //     $form = $this->createForm(PostType::class, $post);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $post->setTopic($topic);
    //         $post->setAuthor($this->getUser());
    //         $post->setCreatedAt(new \DateTime());

    //         $em->persist($post);
    //         $em->flush();

    //         // Redirect back to the topic to avoid resubmitting form on refresh
    //         return $this->redirectToRoute('forum_topic', ['id' => $id]);
    //     }

    //     // Render the topic view with existing posts and the form to add new posts
    //     return $this->render('forum/show.html.twig', [
    //         'topic' => $topic,
    //         'posts' => $topic->getPosts(),
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/forum/new-topic", name="forum_new_topic")
    //  * @IsGranted("ROLE_USER")
    //  */
    // public function newTopic(Request $request, EntityManagerInterface $em): Response
    // {
    //     // Create a new topic form
    //     $topic = new Topic();
    //     $form = $this->createForm(TopicType::class, $topic);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $topic->setAuthor($this->getUser());
    //         $topic->setCreatedAt(new \DateTime());

    //         $em->persist($topic);
    //         $em->flush();

    //         return $this->redirectToRoute('forum_home');
    //     }

    //     return $this->render('forum/new_topic.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}
