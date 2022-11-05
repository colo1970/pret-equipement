<?php
namespace App\Serializer;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\Equipement;

final class EquipementContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        if ($resourceClass === Equipement::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_MANAGER') && true === $normalization) {
            if($request->getMethod()=== REQUEST::METHOD_POST){
                 $context['groups'][] = 'put_manager';
            }
        }
        
        if ($resourceClass === Equipement::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && false === $normalization) {
            if($request->getMethod()=== REQUEST::METHOD_PUT){
              $context['groups'][] = 'get_put_admin';
            }
           
        }

        return $context;
    }
}