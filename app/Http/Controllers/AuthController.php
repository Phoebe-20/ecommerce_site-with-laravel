<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail ;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    
    public function login_admin () 
    {
        /*ddHash::make(12345678)
        return view('admin.auth.login');*/
        
        if(!empty(Auth::check()) && Auth::user())
        {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }


    public function auth_login_admin (Request $request) 
    {
        /*dd($request->all());*/

        $remember = !empty($request->remember) ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],
            $remember))
        {
            return redirect('admin/dashboard');
        }
        else 
        {
            return redirect()->back()->with('error', "Please enter correct email and password");
        }
    }


 
   public function logout_admin()
    {
        Auth::logout();
        return redirect(url(''));
        //return redirect('admin');
    }


    public function auth_login(Request $request)
    {
        $remember = !empty($request->is_remember) ? true : false;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],
            $remember))
        {
            if (!empty(Auth::user()->email_verified_at)) 
            {
                $json['status'] = true;
                $json['message'] = 'Bienvenue !';
            }
            else
            {
                $save = User::getSingle(Auth::user()->id);
                Mail::to($save->email)->send(new RegisterMail($save));
                Auth::logout();

                $json['status'] = false;
                $json['message'] = "Votre compte mail n'est pas vérifié !  
                                    Veuillez consulter votre boîte de réception et vérifié";
            }
            
        }
        else 
        {
            $json['status'] = false;
            $json['message'] = 'Veuillez entrer un mot de passe et une addresse mail correct';
        }

        echo json_encode($json);
    }

    public function auth_register(Request $request)
    {
        $checkEmail = User::checkEmail($request->email);
        if(empty($checkEmail))
        {
            $save = new User;
            $save->name = $request->name;
            $save->email = $request->email;
            $save->password = Hash::make( $request->password);
            $save->save();

            Mail::to($save->email)->send(new RegisterMail($save));

            $json['status'] = true;
            $json['message'] = "Votre Compte a été enregistré !
                                
                                Vérifiez s'il-vous-plait votre adresse mail.";

        }
        else 
        {
            $json['status'] = false;
            $json['message'] = "Cette Adresse Mail est déjà enregistrer. Veillez entrer s'il-vous-plait une autre Adresse";
        }

        echo json_encode($json);

    }


    public function activate_email($id)
    {
        $id = base64_decode($id);
        $user = User::getSingle($id); 
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect(url(''))->with('success', 'Email vérifié avec success');
    }

    public function forgot_password()
    {
        $data['meta_title'] = 'Mot de Passe Oublié';
        return view('auth.forgot', $data);
    }

    public function auth_forgot_password(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!empty($user)) 
        {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Veuillez vérifier votre boîte de réception et réinitialiser le mot de passe');
        }
        else
        {
            return redirect()->back()->with('error', 'Adresse mail introuvable');
        }
    }

    public function reset($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) 
        {
            $data['user'] = $user;
            $data['meta_title'] = 'Réinitialiser le mot de passe';
            return view('auth.reset', $data);
        }
        else
        {
            abort(404);
        }
    }

    public function auth_reset($token, Request $request) 
    {
        if($request->password == $request->cpassword)
        {
            $user = User::where('remember_token', '=', $token)->first();
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();

            return redirect(url(''))->with('success', 'Mot de passe réinitialisé avec success');
        }
        else 
        {
            return redirect()->back()->with('error', 'Le mot de passe et la confirmation ne correspondent pas');
        }
    }
}



