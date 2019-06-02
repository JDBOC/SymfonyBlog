<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

class CategorieFixtures extends Fixture
{
	const CATEGORIES = ['PHP', 'Java', 'Javascript', 'Ruby', 'DevOps', 'BrainFuck'];
	
	public function load(ObjectManager $manager)
	{
		foreach (self::CATEGORIES as $key => $values) {
			$categorie = new categorie();
			$categorie->setName($values);
			$manager->persist($categorie);
			$this->addReference('categorie_' . $key, $categorie);
		}
		$manager->flush();
	}

}