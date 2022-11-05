<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Pret;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class PretSubscriber implements EventSubscriberInterface
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['ajouterPret', EventPriorities::PRE_WRITE],
        ];
    }

    public function ajouterPret(ViewEvent $event): void
    {
        $pret = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $adherent = $this->token->getToken()->getUser();
        if ($pret instanceof Pret) {
            if(Request::METHOD_POST == $method){
                $pret->setAdherent($adherent);
                if($pret->getDateRetourReelle() === null){
                   $pret->getEquipement()->setDisponibilite(false);
                }else{
                    $pret->getEquipement()->setDisponibilite(true);
                }
            }
        }

        return;
    }
}