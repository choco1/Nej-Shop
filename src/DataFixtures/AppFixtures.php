<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{

    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }



    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
    $faker = Faker\Factory::create("fr_FR");

        $user = new User();
        $user->setEmail('najwa.ciesielczyk@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'najwa1234'));
        $user->setUsername('Nej');
        $user->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-0', $user);
        $manager->persist($user);



        for($i = 1; $i < 30; $i++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, '12345678'));
            $user->setUsername($faker->userName);
            $user->setRoles(['ROLE_USER']);
            $this->addReference('user-'.$i, $user);
            $manager->persist($user);
        }



    for($i = 0; $i < 8; $i++){
        $comment = new Comment();
        $comment->setName($faker->name);
        $comment->setCreatedAt(new \DateTime());
        $comment->setNote(rand(0, 5));
        $comment->setMessage($faker->text(200));

        $manager->persist($comment);
        $this->addReference('commentaire-'.$i, $comment);
    }

    for($i = 0; $i < 7; $i++){
        $color = new Color();
        $color->setNameOfCalor($faker->colorName);

        $manager->persist($color);
        $this->addReference('couleur-'.$i, $color);
    }

    for($i = 0; $i < 5; $i++){
        $category = new Category();
        $category->setName($faker->name);

        $manager->persist($category);
        $this->addReference('category-'.$i, $category);
    }

        for($i = 0; $i < 20; $i++){
            $product = new Product();
                $product->setImage("https://picsum.photos/600/400");//$faker->imageUrl(600,400)
                $product->setName($faker->name);
                $product->setCategory($this->getReference('category-'.rand(0, 4)));

                for($j = 0; $j < 3; $j++){
                 $product->addColor($this->getReference('couleur-'.rand(0, 6)));
                }
                $product->setDescription($faker->text(300));
                $product->setDate(new \DateTime());
                $product->setPrice($faker->numberBetween(99, 4000));
                $product->setFavorit($faker->boolean(60));
                for($n = 0; $n < 6; $n++){
                $product->addComment($this->getReference('commentaire-'.rand(0, 6)));
                }
            $manager->persist($product);
        }

        $manager->flush();
    }
}
