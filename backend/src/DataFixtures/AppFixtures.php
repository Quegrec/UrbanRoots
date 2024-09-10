<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Profile;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use App\Repository\ProfileRepository;
use Domain\UseCase\User\RegisterUser;
use Doctrine\Persistence\ObjectManager;
use Domain\Validator\Entity\UserValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Domain\UseCase\Forum\Topic\CreateTopic;
use Domain\Request\Topic\CreateTopicRequest;
use Domain\Request\User\RegisterUserRequest;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->registerUser(
            $manager->getRepository(User::class),
            $manager->getRepository(Profile::class)
        );
        $this->createTopics(
            $manager->getRepository(Topic::class),
            $manager->getRepository(User::class)
        );        
    }

    private function registerUser(UserRepository $userRepository, ProfileRepository $profileRepository): void
    {
        $registerUser = new RegisterUser(
            new UserValidator(),
            $userRepository,
            $profileRepository,
        );

        $registerUserRequests = [];
        $registerAdmin = new RegisterUserRequest(
            username: 'admin',
            email: 'admin@racineurbaine.fr',
            password:'mdpsecurise',
            role: ['ROLE_ADMIN']
        );

        $registerUserRequests[] = $registerAdmin;
        $registerUser1 = new RegisterUserRequest(
            username: 'Nono',
            email: 'arnaud@reflectiv.com',
            password:'RoyalOBar',
        );

        $registerUserRequests[] = $registerUser1;
        $registerUser2 = new RegisterUserRequest(
            username: 'Paul',
            email: 'paulux@mail.com',
            password:'liverpool',
        );
        $registerUserRequests[] = $registerUser2;
        $registerUser3 = new RegisterUserRequest(
            username: 'Melinda',
            email: 'stichfan@42.com',
            password:'Stitch4life',
        );

        $registerUserRequests[] = $registerUser3;
        $registerUser4 = new RegisterUserRequest(
            username: 'TechLeaderOfTechMaster',
            email: 'remi@dev.com',
            password:'Bidibuleking',
        );
        $registerUserRequests[] = $registerUser4;

        foreach ($registerUserRequests as $registerUserRequest) {
            $registerUser->execute($registerUserRequest);
        }
    }

    private function createTopics(TopicRepository $topicRepository, UserRepository $userRepository): void
    {
        $createTopics = new CreateTopic(
            $topicRepository,
            $userRepository,
        );

        $createTopicsRequests = [];
        
        $createTopic1 = new CreateTopicRequest(
            title: 'Astuces pour un jardinage éco-responsable',
            description: 'Partagez vos conseils pour un jardinage respectueux de l\'environnement : compostage, permaculture, recyclage des eaux, etc.'
        );
        
        $createTopicsRequests[] = $createTopic1;
        $createTopic2 = new CreateTopicRequest(
            title: 'Créer un potager en permaculture : par où commencer ?',
            description: 'Conseils pour débuter un jardin en permaculture, en mettant l\'accent sur les pratiques écologiques et durables.'
        );

        $createTopicsRequests[] = $createTopic2;
        $createTopic3 = new CreateTopicRequest(
            title: 'Comment améliorer la biodiversité dans votre jardin partagé ?',
            description: 'Idées pour attirer les pollinisateurs, favoriser la diversité des plantes et animaux, et promouvoir des écosystèmes sains.'
        );

        $createTopicsRequests[] = $createTopic3;
        $createTopic4 = new CreateTopicRequest(
            title: 'Échange de graines et de plants entre jardiniers',
            description: 'Un espace pour organiser des échanges de graines, de plants et partager des variétés locales ou anciennes.'
        );

        $createTopicsRequests[] = $createTopic4;
        $createTopic5 = new CreateTopicRequest(
            title: 'Réussir un jardin communautaire en milieu urbain : vos expériences',
            description: 'Partagez vos expériences et les défis de créer et entretenir un jardin communautaire en ville (espace, pollution, entraide...).'
        );

        $createTopicsRequests[] = $createTopic5;

        foreach ($createTopicsRequests as $createTopicRequest) {
            $createTopics->execute($createTopicRequest);
        }
    }
}