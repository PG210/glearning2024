<?php

namespace App\Http\Controllers\RegController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
Use Session;
use DB;
use App\User;

use App\Services\MicrosoftGraphService; 



class SesController extends Controller
{

    protected $tokenGlobal;

    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

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
        //return $request;
        
      $validar = DB::table('users')->where('email', $request->email)->count();
        if($validar != 0){
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();

            // Enviar el correo de recuperación de contraseña
           /* $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
            
                Session::flash('errorInicio','¡Revisa tu correo! Recibiras un link para cambiar tu contraseña.');
                return back();
            }*/

              // Generar token
            $token = Password::broker()->createToken($user);

            $link = url(route('resetpass', ['token' => $token, 'email' => $user->email], false));
           
            $subject = 'Restablece tu contraseña';
            $content = "
                Hola {$user->firstname},<br><br>
                Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:<br><br>
                <a href='{$link}'>Restablecer contraseña</a><br><br>
                Si no solicitaste este cambio, puedes ignorar este mensaje.
            ";

            // Enviar con Microsoft Graph
            $result = $this->graphService->sendMail($subject, $content, $user->email);
           
            Session::flash('errorInicio','¡Revisa tu correo! Recibiras un link para cambiar tu contraseña.');
            return back();
        }

        Session::flash('errorInicio','¡Lo sentimos! Dirección de correo no encontrada.');
        return back();

    }

    //cambiar contraseña
    public function resetPassword($token, $email){
        $this->tokenGlobal = $token;
        
        return view('auth.passwords.reset')->with('token', $token)->with('email', $email);
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
