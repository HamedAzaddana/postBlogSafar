<?php

namespace App\Controllers;

use App\HQ\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = factory_model_instance('user');
    }

    public function showLogin()
    {
        return view("auth/login", [], "layout", "Login Page");
    }

    public function showRegister()
    {
        return view("auth/register", [], "layout", "Register Page");
    }

    public function login()
    {
        $errors = [];
        if (!(!empty(request('csrf_token')) && validate_csrf_token(request('csrf_token'), 'form_login'))) {
            $errors[] = "داده های شما منقضی شده اند !";
        }

        $username = request('username');
        $password = request('password');
        $user = $this->userModel->getUserByUsername($username);

        if (count($errors) == 0) {
            if ($user && password_verify($password, $user['password'])) {
                session_put('user', $user);
                return redirect("/posts");
            } else {
                session_put('errors', ["نام کاربری یا رمز عبور صحیح نیست !"]);
                return redirect("/login");
            }
        } else {
            session_put('errors', $errors);
            return redirect("/login");
        }
    }

    public function register()
    {
        set_old_app();
        $username = request('username');
        $email = request('email');
        $password = request('password');
        $password_confirmation = request('password_confirmation');
        $this->userModel->getUserByUsername($username);
        $errors = [];
        if (!(!empty(request('csrf_token')) && validate_csrf_token(request('csrf_token'), 'form_register'))) {
            $errors[] = "داده های شما منقضی شده اند !";
        }
        if (!$username  ||  !$email || !$password || !$password_confirmation) {
            $errors[] = "تمامی ورودی ها اجباری اند !";
        }
        if (strlen($password) <= 4) {
            $errors[] = "رمز عبور حداقل 4 کاراکتر باید داشته باشد !";
        }
        if ($password && $password_confirmation && $password != $password_confirmation) {
            $errors[] = "رمز عبور با تکرار رمز عبور برابر نیست !";
        }
        if ($this->userModel->getUserByEmail($email) || $this->userModel->getUserByUsername($username)) {
            $errors[] = "کاربری با این نام کاربری یا ایمیل وجود دارد !";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "ایمیل وارد شده صحیح نیست !";
        }
        if (count($errors) == 0) {
            $this->userModel->createUser($username, $email, $password, 'user');
            session_put('success', "با موفقیت ثبت نام شدید !");
            return redirect("/login");
        } else {
            session_put('errors', $errors);
            return redirect("/register");
        }
    }

    public function logout()
    {
        session_put('user', null);
        return redirect("/login");
    }
}
