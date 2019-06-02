<?php

namespace App\DataFixtures;

use App\Entity\Article;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
	
	/**
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		$faker  =  Faker\Factory::create('fr_FR');
		
		$nbInCat = count(CategorieFixtures::CATEGORIES) - 1;
		
		for ($i=0; $i < 51; $i++) {
			$article = new Article();
			$article->setTitle(mb_strtolower($faker->title));
			$article->setContent(mb_strtolower($faker->text(500)));
			$article->setCategorie($this->getReference('categorie_' . rand(0, $nbInCat)));
			$manager->persist($article);
			
		}
		$manager->flush();
	}
	
	/**
	 * This method must return an array of fixtures classes
	 * on which the implementing class depends on
	 *
	 * @return array
	 */
	public function getDependencies()
	{
		return [CategorieFixtures::class];
	}
}