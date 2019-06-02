<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

class CategorieFixtures extends Fixture
{
	const CATEGORIES = ['PHP', 'Java', 'Javascript', 'Ruby', 'DevOps', 'BrainFuck'];
	
	/**
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		foreach (self::CATEGORIES as $key => $categoryName) {
			$categorie = new categorie();
			$categorie->setName($categoryName);
			$this->addReference('categorie_' . $key, $categorie);
			$manager->persist($categorie);
		}
		$manager->flush();
	}

}