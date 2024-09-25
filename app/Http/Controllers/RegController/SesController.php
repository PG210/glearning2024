<?php

namespace App\Http\Controllers\RegController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
Use Session;
use DB;



class SesController extends Controller
{
    protected $tokenGlobal;

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
       
       // $credentials = $request->only('username', 'password');

        $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            $userauth = Auth::user()->admin; //know rol of user
            $userestado = Auth::user()->estado; //know estado of user

           if($userestado != 0){
                if($userauth == 1) {
                    return redirect('/backdoor');
                }else {
                   if( $userauth == 2){
                        return redirect('/admin/reporte');
                    }else{

                        return redirect('/home'); // valor es cero
                    }
                }

           }else{
               Session::flash('errorInicio','Lo sentimos! Tu usuario ha sido deshabilitado');
               return redirect('/login');
           }
            
        }

        // Autenticación fallida
        Session::flash('errorInicio','Lo sentimos! Tu usuario o contraseña son incorrectos');
        return redirect('/login');
    }

    //eliminar la sesion
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    //enviar a la vista de recuperar password
    public function forgotPassword()
    {
        return view("auth.passwords.email");
    }

    // enviar correo de recuperacion
    public function sendemail(Request $request){
        
        $validar = DB::table('users')->where('email', $request->email)->count();
        if($validar != 0){
            $request->validate(['email' => 'required|email']);

            // Enviar el correo de recuperación de contraseña
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
            
                Session::flash('errorInicio','¡Revisa tu correo! Recibiras un link para cambiar tu contraseña.');
                return back();
            }
        }

        Session::flash('errorInicio','¡Lo sentimos! Dirección de correo no encontrada.');
        return back();

    }

    //cambiar contraseña
    public function resetPassword($token){
        $this->tokenGlobal = $token;
       
        return view('auth.passwords.reset')->with('token', $token);
    }

    public function passupdate(Request $request){
     
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $validar = DB::table('users')->where('email', $request->email)->count();
        if($validar != 0){
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                }
            );

         if ($status === Password::PASSWORD_RESET) {
            //logearse si cambia el password
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
    
                $userauth = Auth::user()->admin; //know rol of user
                $userestado = Auth::user()->estado; //know estado of user
    
               if($userestado != 0){
                    if($userauth == 1) {
                        return redirect('/backdoor');
                    }else {
                       if( $userauth == 2){
                            return redirect('/admin/reporte');
                        }else{
    
                            return redirect('/home'); // valor es cero
                        }
                    }
    
               }else{
                   Session::flash('errorInicio','Lo sentimos! Tu usuario ha sido deshabilitado');
                   
               }
                
            }
        }
       } //end validacion de existencia correo
        Session::flash('errorInicio','Lo sentimos!, ha ocurrido un error al reestablecer tu contraseña.');
        return back();
      
    }
}
