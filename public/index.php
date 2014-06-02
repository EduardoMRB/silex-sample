<?php

require __DIR__ . '/bootstrap.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application;

$app['debug'] = true;
$app->register(new TwigServiceProvider, [
    'twig.path' => __DIR__ . '/views',
]);
$app->register(new SessionServiceProvider);

$app['entityManager'] = function () use ($entityManager) {
    return $entityManager;
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/signup', function () use ($app) {
    return $app['twig']->render('signup.html.twig');
});

$app->post('/auth', function (Request $request) use ($app) {

});

$app->post('/user', function (Request $request) use ($app) {
    $user = new Seguranca\Entity\User;
    $user->setEmail($request->get('email'))
        ->setPassword($request->get('password'));

    $em = $app['entityManager'];
    $em->persist($user);
    $em->flush();

    $app['session']->getFlashBag()->add('success', 'Usuário criado com sucesso');
    return $app->redirect('/', 302);
});

$app->run();
