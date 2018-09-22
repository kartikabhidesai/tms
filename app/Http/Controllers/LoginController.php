<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

class LoginController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //echo "hi";exit;
        //$this->middleware('guest', ['except' => 'logout']);
    }

    public function checkAuth(Request $request) {

        if (auth()->guard('admin')->user()) {
            return redirect()->route('admin-dashboard');
        } else if (auth()->guard('customer')->user()) {
            return redirect()->route('customer-dashboard');
        } else if (auth()) {
            return redirect()->route('worker-dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function auth(Request $request) {

        $this->resetGuard();

//        if(Auth::guard('admin')){
//            return redirect(route('admin-dashboard'));
//        }else if(Auth::guard('customer')){
//            return redirect(route('customer-dashboard'));
//        }else if(Auth::guard('web')){
//            return redirect(route('user-dashboard'));
//        }else{
//            return view('auth.login');
//        }

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'staffnumber' => 'required',
                'password' => 'required',
            ]);
            
            if (Auth::attempt(['staffnumber' => $request->input('staffnumber'), 'password' => $request->input('password'), 'type' => 'WORKER'])) {
                $loginData = array(
                    'name' => Auth::guard('web')->user()->name,
                    'staffnumber' => Auth::guard('web')->user()->staffnumber,
                    'type' => Auth::guard('web')->user()->type,
                    'id' => Auth::guard('web')->user()->id
                );
                Session::push('logindata', $loginData);
                 Session::flash('flash_message', 'Worker Login successfully.');
                // $return['status'] = 'success';
                // $return['message'] = 'User Login successfully.';
                // $return['redirect'] = route('user-dashboard');
                // print_r($return);exit;
               return redirect()->route('worker-dashboard');
            } else if (Auth::guard('customer')->attempt(['staffnumber' => $request->input('staffnumber'), 'password' => $request->input('password'), 'type' => 'SUPERVISOR'])) {
                $loginData = array(
                    'name' => Auth::guard('customer')->user()->name,
                    'staffnumber' => Auth::guard('customer')->user()->staffnumber,
                    'type' => Auth::guard('customer')->user()->type,
                    'id' => Auth::guard('customer')->user()->id
                );
                Session::push('logindata', $loginData);
                Session::flash('flash_message', 'Supervisor Login successfully.');
                // $return['status'] = 'success';
                // $return['message'] = 'Customer Login successfully.';
                // $return['redirect'] = route('customer-dashboard');
                return redirect()->route('customer-dashboard');
            } else if (Auth::guard('admin')->attempt(['staffnumber' => $request->input('staffnumber'), 'password' => $request->input('password'), 'type' => 'ADMIN'])) {
                //echo "admin";exit;
                $loginData = array(
                    'name' => Auth::guard('admin')->user()->name,
                    'staffnumber' => Auth::guard('admin')->user()->staffnumber,
                    'type' => Auth::guard('admin')->user()->type,
                    'id' => Auth::guard('admin')->user()->id
                );
                Session::flash('flash_message', 'Admin Login successfully.');
                Session::push('logindata', $loginData);
                $return['status'] = 'success';
                $return['message'] = 'Admin Login successfully.';
                $return['redirect'] =   route('admin-dashboard');
               return redirect()->route('admin-dashboard');
            } else if (Auth::guard('agent')->attempt(['staffnumber' => $request->input('staffnumber'), 'password' => $request->input('password'), 'type' => 'AGENT'])) {

                $loginData = array(
                    'name' => Auth::guard('agent')->user()->name,
                    'staffnumber' => Auth::guard('agent')->user()->staffnumber,
                    'type' => Auth::guard('agent')->user()->type,
                    'id' => Auth::guard('agent')->user()->id
                );
                Session::push('logindata', $loginData);
                // $return['status'] = 'success';
                // $return['message'] = 'Agent Login successfully.';
                // $return['redirect'] = route('agent-dashboard');
                return redirect()->route('agent-dashboard');
            } else {
                // $return['status'] = 'error';
                // $return['message'] = 'your username and password are wrong';
                $request->session()->flash('session_error', 'Your staffnumber or password is wrong. Please login with correct credential...!!');

                $data['error'] = 'Your staffnumber and password are wrong. Please login with correct credential...!!';
               return view('auth.login', $data);
               dd('your staffnumber and password are wrong.');
            }
            // echo json_encode($return);
            // exit;
        }
        $data['css'] = array();
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('login.js');
        $data['funinit'] = array('Login.loginInit()');
        return view('auth.login', $data);
    }

    public function getLogout() {
        $this->resetGuard();
        //return Redirect::to('login'); 
        return redirect()->route('login');
    }

    public function resetGuard() {
        Auth::logout();
        Auth::guard('admin')->logout();
        Auth::guard('customer')->logout();
        Session::forget('logindata');
    }

}