<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\forms\LoginForm;
use app\forms\MemberRegisterForm;
use app\forms\PrivateProfessionalRegister;
use app\forms\PublicProfessionalRegister;
use app\models\account\UserAccount;
use app\models\User;
use app\models\user\professional\PrivateProfessional;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                if (Application::$app->user->isProfessional()) {
                    $response->redirect("/dashboard/offres");
                    exit;
                }
                $response->redirect("/");
                exit;
            }
        }
        return $this->render('auth/login', ['model' => $loginForm]);
    }

    public function register(Request $request)
    {
        $user = new UserAccount();

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash("success", "Your account has been created successfully");
                Application::$app->response->redirect('/');
                exit;
            }

            return $this->render('auth/register', [
                'model' => $user
            ]);
        }

        return $this->render('auth/register', [
            'model' => $user
        ]);
    }

    public function registerProfessional(Request $request, Response $response)
    {
        $proPublic  = new PublicProfessionalRegister();
        $proPrivate = new PrivateProfessionalRegister();

        if ($request->isPost() && $request->formName()=="public") {
            $proPublic->loadData($request->getBody());

            if ($proPublic->validate() && $proPublic->register()) {
                Application::$app->session->setFlash('success', "Bienvenue $proPublic->denomination. Votre compte à bien été crée !");
                Application::$app->mailer->send($proPublic->mail, "Bienvenue $proPublic->denomination", 'welcome', ['denomination' => $proPublic->denomination]);
                $response->redirect('/');
                exit;
            }
        }

        if ($request->isPost() && $request->formName()=="private") {
            if ($proPrivate->validate() && $proPrivate->register()) {
                Application::$app->session->setFlash('success', "Bienvenue $proPrivate->denomination. Votre compte à bien été crée !");
                Application::$app->mailer->send($proPrivate->mail, "Bienvenue $proPrivate->denomination", 'welcome', ['denomination' => $proPrivate->denomination]);
                $response->redirect('/');
                exit;
            }
        }

        return $this->render('auth/register-professional', ['proPublic' => $proPublic, 'proPrivate' => $proPrivate]);
    }

    public function registerMember(Request $request, Response $response)
    {
        $form = new MemberRegisterForm();

        if ($request->isPost()) {
            $form->loadData($request->getBody());
            
            echo '<pre>';
            var_dump($request->getBody());
            echo '</pre>';

            if ($form->validate() && $form->register()) {
                Application::$app->session->setFlash('success', "Bienvenue $form->pseudo. Votre compte à bien été crée !");
                Application::$app->mailer->send($form->mail, "Bienvenue $form->pseudo", 'welcome', ['pseudo' => $form->pseudo]);
                $response->redirect('/');
                exit;
            }
        }

        return $this->render('auth/register-member', ['model' => $form]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        Application::$app->session->setFlash('success', 'Vous avez été déconnecté.');
        $response->redirect('/');
    }

    public function profile() {
        if (Application::$app->user->isProfessional()) {
            $this->setLayout('back-office');
        }
        return $this->render('profile');
    }
}