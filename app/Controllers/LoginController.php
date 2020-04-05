<?php

namespace App\Controllers;

use Core\Auth;
use Core\View;

class LoginController
{
    public function auth()
    {
        if (Auth::isAuth()) {
            header("Location: /");
            die;
        }

        $error = '';
        if (!empty($_POST)) {
            if (Auth::login($_POST['email'], $_POST['password'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Sign in successfully'];
                header("Location: /");
                die;
            } else {
                $error = 'Invalid credentials.';
            }
        }

        View::render('login', ['error' => $error]);
    }

    public function logout()
    {
        Auth::logout();
        header("Location: /");
        die;
    }
}
