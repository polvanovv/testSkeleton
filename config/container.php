<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection;
use Symfony\Component\Routing;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use App\Handler\MainHandler;
use Twig\Environment;

$containerBuilder = new DependencyInjection\ContainerBuilder();
$routes           = include __DIR__."/routes.php";
$doctrine         = include __DIR__."/common/doctrine.php";
$twigLoader       = include __DIR__."/common/twig.php";

$containerBuilder->setParameter('em.config', $doctrine['config']);
$containerBuilder->setParameter('em.conn', $doctrine['conn']);
$containerBuilder->setParameter('routes', $routes);
$containerBuilder->setParameter('twig.loader', $twigLoader);

$containerBuilder->register('context', Routing\RequestContext::class);
$containerBuilder->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments(['%routes%', new Reference('context')]);

$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);
$containerBuilder->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$containerBuilder->register('entity_manager')->setFactory([EntityManager::class, 'create'])
    ->setArguments(['%em.conn%', '%em.config%']);

$containerBuilder->register('app', MainHandler::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference('controller_resolver'),
        new Reference('argument_resolver'),
    ]);

$containerBuilder->register('twig', Environment::class)
    ->setArguments(['%twig.loader%']);

return $containerBuilder;