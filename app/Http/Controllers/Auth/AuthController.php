<?php
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
  
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email','=',$request->email)->get();
            Session::put('userid', $user[0]['id']);
            // if($user[0]['user_type']==1){
                return redirect()->intended('dashboard')
                            ->withSuccess('You have Successfully loggedin');
            /* }
            else{                
                return redirect()->intended('dashboard')
                ->withSuccess('You have Successfully loggedin');
            } */
        }
  
        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
           
        $data = $request->all();
        $user = $this->create($data);
            
        Auth::login($user); 

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){            
            $datadrug = array();
            return view('dashboard', compact('datadrug'));
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    
    public function searchdrug()
    {
        $datadrug = array();
        return view('searchdruglist', compact('datadrug'));
    }

    
    public function finddrug(Request $request)
    {
        $response = Http::get('https://rxnav.nlm.nih.gov/REST/drugs.json', [
        'name' => $request->namedrug,
        ]);

        // Get the response data
        $data_drug = $response->json();

        $datadrug = array();

        foreach ($data_drug['drugGroup']['conceptGroup'] as $group) {
            if (isset($group['conceptProperties'])) {
                foreach ($group['conceptProperties'] as $concept) {
                    $rxcui = $concept['rxcui'];

                    $response_add = Http::get("https://rxnav.nlm.nih.gov/REST/rxcui/{$rxcui}/historystatus.json");

                    $historyData_baseName = $historyData_doseFormGroupName = '';
                    
                    if ($response_add->successful()) {

                        $historyData = $response_add->json();

                        $historyData_baseName = $historyData['rxcuiStatusHistory']['definitionalFeatures']['ingredientAndStrength'][0]['baseName'] ?? '';
                        
                        if (!empty($historyData['rxcuiStatusHistory']['definitionalFeatures']['doseFormGroupConcept'])) {
                            foreach ($historyData['rxcuiStatusHistory']['definitionalFeatures']['doseFormGroupConcept'] as $concept_s) {
                                $historyData_doseFormGroupName .= $concept_s['doseFormGroupName'] . ', ';
                            }

                            // Remove trailing comma and space
                            $historyData_doseFormGroupName = rtrim($historyData_doseFormGroupName, ', ');
                        }

                    } 
                    
                    array_push($datadrug,array('id'=>$rxcui,'name'=>$concept['name'],'baseName'=>$historyData_baseName, 'doseFormGroupName'=> $historyData_doseFormGroupName));
                }
            }
        }

        
        
        return view('searchdruglist', compact('datadrug'));
    }

    
    public function userfinddrug(Request $request)
    {
        $response = Http::get('https://rxnav.nlm.nih.gov/REST/drugs.json', [
        'name' => $request->namedrug,
        ]);

        // Get the response data
        $data_drug = $response->json();

        $datadrug = array();

        foreach ($data_drug['drugGroup']['conceptGroup'] as $group) {
            if (isset($group['conceptProperties'])) {
                foreach ($group['conceptProperties'] as $concept) {
                    $rxcui = $concept['rxcui'];

                    $response_add = Http::get("https://rxnav.nlm.nih.gov/REST/rxcui/{$rxcui}/historystatus.json");

                    $historyData_baseName = $historyData_doseFormGroupName = '';
                    
                    if ($response_add->successful()) {

                        $historyData = $response_add->json();

                        $historyData_baseName = $historyData['rxcuiStatusHistory']['definitionalFeatures']['ingredientAndStrength'][0]['baseName'] ?? '';
                        
                        if (!empty($historyData['rxcuiStatusHistory']['definitionalFeatures']['doseFormGroupConcept'])) {
                            foreach ($historyData['rxcuiStatusHistory']['definitionalFeatures']['doseFormGroupConcept'] as $concept_s) {
                                $historyData_doseFormGroupName .= $concept_s['doseFormGroupName'] . ', ';
                            }

                            // Remove trailing comma and space
                            $historyData_doseFormGroupName = rtrim($historyData_doseFormGroupName, ', ');
                        }

                    } 
                    
                    array_push($datadrug,array('id'=>$rxcui,'name'=>$concept['name'],'baseName'=>$historyData_baseName, 'doseFormGroupName'=> $historyData_doseFormGroupName));
                }
            }
        }

        
        
        return view('dashboard', compact('datadrug'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
