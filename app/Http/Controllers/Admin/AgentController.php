<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;

class AgentController extends Controller
{
    public function AllAgents(){
        $agents = Agent::latest()->get();
        return view('admin.agents.index',compact('agents'));
    }

    public function AddAgent()
    {
        return view('admin.agents.add');
    }

    // Single Agent Creation
    public function StoreAgent(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => ['required', 'unique:agents,phone', 'regex:/^[0-9]{10}$/'],
                
            ], [
                'phone.regex' => 'Phone number must be exactly 10 digits.',
            ]);
            
    
            //Store the agent
            $agent = new Agent();
            $agent->name = $request->name;
            $agent->phone = $request->phone;
            $agent->save();

            return redirect()->back()->with('success','Agent saved successfully');
        }catch(ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'agentNewModal');
        }catch (\Exception $e) {
            // Log exception and reopen modal
            return redirect()->back()->with('modal', 'agentNewModal');
        }
        // Validate inputs
        

        // Flash session to indicate the modal should stay open
        // return redirect()->back()->with('modal', 'agentNewModal');

        // Redirect back without showing the modal since it's a successful save
        // return redirect()->back()->with('success', 'Agent saved successfully!');
    }


    public function ShowAgent($id)
    {
        $agent = Agent::find($id);
        return view('admin.agents.show.agent',compact('agent'));
    }

    public function EditAgent($id)
    {
        $agent = Agent::find($id);
        return view('admin.agents.edit', compact('agent'));
    }

    public function UpdateAgent(Request $request)
    {
        $agent = Agent::find($request->id);

        $request->validate([
            // 'name' => 'required|unique:agents,name,' . $agent->id,
            'name' => 'required',
            'phone' => 'required|unique:agents,name,' . $agent->id,
        ]);

        $agent->name = $request->name;
        $agent->slug = str_replace(' ','-',strtolower($agent->name));
        $agent->update();

        return redirect()->back('success', 'Agent updated successfully');
    }

    public function DeleteAgent($id)
    {
        $agent = Agent::find($id);

        // Check if the agent has any agents
        // if ($agent->agents()->count() > 0) {
        //     return redirect()->back()->with('error', 'Agent cannot be deleted because it has agents.');
        // }

        // Delete the agent
        $agent->delete();

        return redirect()->back()->with('success', 'Agent deleted successfully!');
    }

}
