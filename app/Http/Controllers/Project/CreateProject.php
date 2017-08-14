<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Project;
use App\Client;

class CreateProject extends BaseController
{
    protected $project;

    protected $request;

    protected $message;

    protected $code = '200';

    public function __construct(Project $project,Request $request,Client $client)
    {
        $this->middleware(['auth','free-plan']);
        $this->request = $request;
        $this->project = $project;
        $this->client = $client;
    }

    public function __invoke()
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->message = 'Failed To Create Client';
            $this->code = 400;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }

        $this->createProject();
        $clients = $this->getAuth()->clients;
        return response()->json(['message' => $this->message, 'project' => $this->project, 'clients' => $clients], $this->code);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
            'client_name' => 'required|max:60',
            'newclient' => 'boolean',
            'user_name' => 'sometimes|required|max:60',
            'user_email' => 'sometimes|required|email',
            'user_password' => 'sometimes|required|max:60',
        ];
        
    }

    private function messages(){
        return [
            'client_name.required' => 'Describe Your Client',
            'client_name.max' => 'Client Description Too Long (60) Max',
            'newclient.boolean' => 'Value of Existing Should be Boolean',
            'user_name.required' => 'Client Name Is Required',
            'user_name.max' => 'Client Name Too Long (60) Max',
            'user_email.required' => 'Email is Required',
            'user_email.email' => 'Email is Invalid Format',
            'user_password.required' => 'Password Required',
            'user_password.max' => 'Password Too Long (60) Max'
        ];
    }

    private function createProject()
    {
        $this->addName();
        if($this->request->newclient === true){
            $this->createNewClient();
            $this->project->client_id = $this->client->id;
            $this->getAuth()->clients()->save($this->client);
        }else{
            $this->addClientIfAny();
        }
        
        $this->manageProjectsByTenant();
        $this->saveByTenant();
        
    }

    private function addName()
    {
       
        $this->project->name = $this->request->client_name;
    }

    private function createNewClient()
    {
        $this->client->name = $this->request->user_name;
        $this->client->email = $this->request->user_email;
        $this->client->password = $this->request->user_password;
        $this->client->tenant_id = $this->getAuth()->id;
        $this->client->save();
        
        

    }
    private function addClientIfAny()
    {
        if(isset($this->request->client_id['id']))
        {
            $tenant_clients = $this->getAuth()->clients->pluck('id')->toArray();
            $client_id = $this->request->client_id['id'];
            if(in_array($client_id,$tenant_clients))
            {
            $this->project->client_id = $client_id;
            }
        }
    }

    private function manageProjectsByTenant()
    {
        $this->getAuth()->manageProjects()->save($this->project);
    }

    private function saveByTenant()
    {
        $project = $this->getAuth()->projects()->save($this->project);
        if(!$project){
        $this->message = 'Client Creation Failed';
        }
        $this->message = 'Client Created!';
    }
}