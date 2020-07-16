<?php 

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Mail;

class UserController extends Controller
{

    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['edit', 'update', 'show']]);
    }

    /**
     * Show User Registration Form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Register User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password'))
        ]);

        return redirect('login')
            ->with('flash_notification.message', 'User registered successfully')
            ->with('flash_notification.level', 'success');
    }

    /**
     * Show User Profile
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view("edit_profile");
    }

    /**
     * Update User Profile
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        //dd(request()->all());

        //Validação dos dados
        $validator = Validator::make($request->all(),[ 
            "name" => "required|string|min:3|max:15",
            "avatar" => "sometimes|image|mimes:jpeg,png,jpg|max:2048",
        ]);
    
        if ($validator->fails()) { 
            return redirect("profile/edit")->withErrors($validator)->withInput(); 
        }

        $data = request()->all();

        $user = User::find(auth()->user()->id);

        if($request->avatar){
            if($user->avatar != "user_default.jpg"){
                unlink("upload/avatar/".$user->avatar);
            }
            $avatar = $request->avatar;
            $avatarNome = time()."_".$avatar->getClientOriginalName();
            $avatar->move("upload/avatar", $avatarNome);
            $user->avatar = $avatarNome;
        }

        $user->name = $data["name"];

        $user->save();

        session()->flash("success", "Perfil editado com sucesso");

        return redirect("profile");
    }

    public function show()
    {
        //Procura um utilizador que tenha o id pedido
        //$user = User::find($userId);

        //Fazer debug
        //dd($user);

        //return view('profile')->with('user', $user);

        //Se um visitante tentar aceder ao link do perfil é redirecionado para o login
        
        if(auth()->guest()){
            abort(403);
            //session()->flash("info", "Tem de se registar para aceder a esta página.");
            //return redirect('login');
        }

        $produtos_venda = Product::where('id_user', '=', auth()->user()->id)
        ->get();

        //dd($produtos_venda);
        
        return view('profile')->with('products', $produtos_venda);
    }

    public function passwordView(){

        return view('change_password');

    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(),[
            "password" => "required|string",
            "n_password" => 'required|string|min:8',
            "c_password" => 'required|same:n_password',
        ]);

        if ($validator->fails()) { 
            return redirect("profile/change_password")->withErrors($validator); 
        }

        $password_atual = auth()->user()->password;      

        //Verifica se a palavra-passe digitada é a mesma que está na base de dados
        if(Hash::check($request->password, $password_atual)){

          $user_id = auth()->user()->id;                       
          $user = User::find($user_id);
          $user->password = Hash::make($request->password);
          $user->save();

          session()->flash("success", "Palavra-passe editada com sucesso");
          return redirect("profile"); 
        }

        else{           
            session()->flash("fail", "A palavra-passe atual não é a correta");
            return redirect("profile/change_password");  
        }

    }

    public function emailView(){

        return view('change_email');

    }

    public function changeEmail(Request $request){

        //dd($request->email);

        $validator = Validator::make($request->all(),[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        if ($validator->fails()) { 
            return redirect("profile/change_email")->withErrors($validator); 
        }      

        $user_id = auth()->user()->id;                       
        $user = User::find($user_id);
        $user->email = request()->email;
        $user->save();

        $obj = new \stdClass();  
        $obj->email = $request->email;

        $data = array('content' => '', 'email' => $obj->email);

        //Enviar um email
        Mail::send("email", $data, function ($message) use ($obj){
            $message->from('fil40320@gmail.com', 'ecommerceApp');
            $message->to(request()->email)
                    ->subject('Mudar email');
        });

        //Caso haja erro ao enviar email
        if(count(Mail::failures()) > 0){
            session()->flash("fail", "Erro ao modificar email");
            return redirect('profile');
        }
        else{
            session()->flash("success", "Email modificado com sucesso");
            return redirect('profile');
        }

    }

}