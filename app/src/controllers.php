<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', []);
})
->bind('homepage');

$app->get('/publications', function () use ($app) {
    $response = json_decode(file_get_contents('https://api.archives-ouvertes.fr/search/?wt=json&q=authIdHal_s:%22vincent-primault%22&sort=conferenceStartDate_s%20desc&fl=citationFull_s,docid,docType_s'), true); //https://api.archives-ouvertes.fr/search/?wt=json&q=authIdHal_s:%22vincent-primault%22&sort=conferenceStartDate_s%20desc&fl=authFullName_s,citationFull_s,conferenceTitle_s,conferenceStartDate_s,files_s,title_s,country_s,city_s,doiId_s,halId_s,docid,docType_s
    $publications = $response['response']['docs'];
    return $app['twig']->render('publications.html', compact('publications'));
})
->bind('publications');

$app->get('/software', function () use ($app) {
    return $app['twig']->render('software.html', []);
})
->bind('software');

$app->get('/teaching', function () use ($app) {
    return $app['twig']->render('teaching.html', []);
})
->bind('teaching');

$app->get('/teaching/dbm1', function () use ($app) {
    return $app['twig']->render('dbm1.html', []);
})
->bind('teaching_dbm1');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
