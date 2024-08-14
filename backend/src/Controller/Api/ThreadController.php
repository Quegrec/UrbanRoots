<?php

namespace App\Controller\Api;

use App\Entity\Thread;
use App\Entity\Message;
use App\Repository\ThreadRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ThreadController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/threads', name: 'list_threads', methods: ['GET'])]
    public function listThreads(ThreadRepository $threadRepository): Response
    {
        $threads = $threadRepository->findAll();
        return $this->json($threads);
    }

    #[Route('/threads/{id}', name: 'view_thread', methods: ['GET'])]
    public function viewThread(Thread $thread, MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findBy(['thread' => $thread]);
        return $this->json([
            'thread' => $thread,
            'messages' => $messages
        ]);
    }

    #[Route('/threads', name: 'create_thread', methods: ['POST'])]
    public function createThread(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $title = $request->request->get('title');
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }
        
        $thread = new Thread();
        $thread->setTitle($title);
        $thread->setAuthor($user);
        $em->persist($thread);
        $em->flush();
        return $this->json($thread, Response::HTTP_CREATED);
    }

    #[Route('/threads/{id}/messages', name: 'create_message', methods: ['POST'])]
    public function createMessage(Request $request, EntityManagerInterface $em, ThreadRepository $threadRepository, UserRepository $userRepository): Response
    {
        $threadId = $request->request->get('thread_id');
        $content = $request->request->get('content');
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $thread = $threadRepository->find($threadId);

        if (!$thread) {
            return $this->json(['error' => 'Thread not found'], Response::HTTP_NOT_FOUND);
        }

        $message = new Message();
        $message->setContent($content);
        $message->setThread($thread);
        $message->setAuthor($user);
        $em->persist($message);
        $em->flush();
        return $this->json($message, Response::HTTP_CREATED);
    }
}
