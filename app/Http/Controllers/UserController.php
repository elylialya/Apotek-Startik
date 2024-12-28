<?php
 
namespace App\Http\Controllers;
 
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

     public function index()
    {
        return view('userprofile');
    }
     
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'confirm_password' => 'required_with:password|same:password',
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'profile_image' => 'image',
        ]);
  
        $input = $request->all();
          
        if ($request->hasFile('profile_image')) {
            $profile_imageName = time().'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('profil_images'), $profile_imageName);
  
            $input['profile_image'] = $profile_imageName;
        
        } else {
            unset($input['profile_image']);
        }
  
        if ($request->filled('password')) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
  
        auth()->user()->update($input);
    
        return back()->with('success', 'Profile updated successfully.');
    }
}
    


