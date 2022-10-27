<?php

namespace App\DataFixtures;

use App\Entity\Adherent;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdherentFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {       
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(PersistenceObjectManager $manager): void
    {
        $adherent = new Adherent();
        $adherent->setNom("Dupont");
        $adherent->setPrenom("Henri");
        $adherent->setAdresseRue("14 avenue de Foch");
        $adherent->setTelephone("0645789645");
        $adherent->setCodePostal("69001");
        $adherent->setEMail(strtolower($adherent->getNom())."@gmail.com");
        $adherent->setPassword($this->passwordHasher->hashPassword($adherent, $adherent->getNom()));
        $this->manager->persist($adherent);          
        //creer admin
        $adherentAdmin = new Adherent();
        $adherentAdmin->setNom("Dafson");
        $adherentAdmin->setPrenom("Ousmane");
        $adherentAdmin->setAdresseRue("81, Rue de Valmy");
        $adherentAdmin->setTelephone("0648776017");
        $adherentAdmin->setCodePostal("69009");
        $adherentAdmin->setEMail("o.daffe@yahoo.fr");
        $adherentAdmin->setPassword($this->passwordHasher->hashPassword($adherentAdmin, $adherentAdmin->getNom()));
        $roleAdmin[] = Adherent::ROLE_ADMIN;
        $adherentAdmin->setRoles($roleAdmin);
        $this->manager->persist($adherentAdmin);        
        $this->manager->flush();  
        //creer adherent Manager
        $adherentManager = new Adherent();
        $adherentManager->setNom("Lajoie");
        $adherentManager->setPrenom("Sofie");
        $adherentManager->setAdresseRue("141, Rue de Republique");
        $adherentManager->setTelephone("0648778015");
        $adherentManager->setCodePostal("69001");
        $adherentManager->setEMail("o.sofie@yahoo.fr");
        $adherentManager->setPassword($this->passwordHasher->hashPassword($adherentManager, $adherentManager->getNom()));     
        $roleManager[] = Adherent::ROLE_MANAGER;
        $adherentManager->setRoles($roleManager);
        $this->manager->persist($adherentManager);        
        $this->manager->flush();   
        
    }
}
