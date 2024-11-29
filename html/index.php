<?php

use app\controllers\AuthController;
use app\controllers\ApiController;
use app\controllers\DashboardController;
use app\controllers\OfferController;
use app\core\Application;
use app\controllers\SiteController;
use app\models\account\UserAccount;


require_once __DIR__ . '/../vendor/autoload.php';

// Setup env variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Setup hot reload
//if ($_ENV['APP_ENVIRONMENT'] === 'dev') {
//    new HotReloader\HotReloader('//localhost:8080/phrwatcher.php');
//}

// Setup config
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

// Setup app
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->post('/', [SiteController::class, 'home']);
$app->router->get('/storybook', [SiteController::class, 'storybook']);
$app->router->get('/recherche', [SiteController::class, 'research']);

// Offer routes
$app->router->get('/offres/creation', [OfferController::class, 'create']);
$app->router->post('/offres/creation', [OfferController::class, 'create']);
$app->router->get('/offres/<pk:int>', [OfferController::class, 'detail']);
$app->router->post('/offres/<pk:int>', [OfferController::class, 'detail']);
$app->router->get('/offres/<pk:int>/modification', [OfferController::class, 'update']);
$app->router->post('/offres/<pk:int>/modification', [OfferController::class, 'update']);
$app->router->get('/offres/<pk:int>/payment', [OfferController::class, 'payment']);

// dashboard pro
$app->router->get('/dashboard', function () {
    if (Application::$app->user->isProfessional()) {
        Application::$app->response->redirect('/dashboard/offres');
    } else {
        Application::$app->response->redirect('/');
    }
});
$app->router->get('/dashboard/offres', [DashboardController::class, 'offers']);
$app->router->post('/dashboard/offres', [DashboardController::class, 'offers']);
$app->router->get('/dashboard/avis', [DashboardController::class, 'avis']);
$app->router->get('/dashboard/factures', [DashboardController::class, 'invoices']);

// Auth routes
$app->router->get('/connexion', [AuthController::class, 'login']);
$app->router->post('/connexion', [AuthController::class, 'login']);
$app->router->get('/inscription', [AuthController::class, 'register']);
$app->router->post('/inscription', [AuthController::class, 'register']);
$app->router->get('/inscription/professionnel', [AuthController::class, 'registerProfessional']);
$app->router->post('/inscription/professionnel', [AuthController::class, 'registerProfessional']);
$app->router->get('/inscription/membre', [AuthController::class, 'registerMember']);
$app->router->post('/inscription/membre', [AuthController::class, 'registerMember']);
$app->router->get('/comptes/modification', [AuthController::class, 'updateAccount']);
$app->router->post('/comptes/modification', [AuthController::class, 'updateAccount']);
$app->router->get('/comptes/reset-password', [AuthController::class, 'resetPassword']);
$app->router->post('/comptes/reset-password', [AuthController::class, 'resetPassword']);
$app->router->get('/deconnexion', [AuthController::class, 'logout']);
$app->router->get('/comptes/<pk:int>', [AuthController::class, 'profile']);
$app->router->get('/users', [SiteController::class, 'users']);

// Api routes
$app->router->get('/api/auth/user', [ApiController::class, 'user']);
$app->router->get('/api/offers', [ApiController::class, 'offers']);
$app->router->get('/api/opinions', [ApiController::class, 'opinions']);
$app->router->post('/api/opinions/<opinion_pk:int>', [ApiController::class, 'opinionUpdate']);

$app->router->get('/test/pdf', [SiteController::class, 'testPdf']);


$app->run();