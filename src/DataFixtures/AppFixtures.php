<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Comment;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
    $faker = Faker\Factory::create("fr_FR");

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
