<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Livewire\WithPagination;


class UserManagement extends Component
{
    use WithPagination;

    public $name,$email,$password,$password_confirmation,$role_id;
    public $search;
    public $adminpage=1;
    public $salepage=1;
    public $itpage= 1;
    public $user_id;
    public $edit = false;
    public $editpass = false; 

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role_id, [0, 1])) {
            abort(403, 'Unauthorized');
        }
        $adminUsers = User::where('role_id', 1)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(5, ['*'], 'adminpage');

        $saleUsers = User::where('role_id', 2)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(5, ['*'], 'salepage');

        $itUsers = User::where('role_id', 3)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate(5, ['*'], 'itpage');

        $roles = Role::where('id', '!=', 0)->get();

        return view('livewire.user-management', compact('adminUsers', 'saleUsers', 'itUsers', 'roles'));
    }
   
    public function addUser()
    {
        $validatedData = Validator::make($this->all(), [
            'name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',      
            'role_id'  => 'required'  
        ])->validate();

    // Create and save user
    $user = new User();
    $user->name = ucwords($validatedData['name']);
    $user->email = $this->email;
    $user->role_id = $this->role_id;
    $user->password = Hash::make($validatedData['password']);
    $user->save();
   
    $this->reset();
        session()->flash('message1', 'User added succesfully');
    }
    
    public function edituser($id)
    {   
        $this->editpass = false;
        $this->edit = true;
        $this->user_id = $id;

        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user -> name;
        $this->email = $user -> email;
        $this->role_id = $user -> role_id; 
    }

    public function resetpage()
    {
        $this->reset();
    }

    public function deleteuser($id)
    {
    $user = User::findOrFail($id);
    $user->delete();
    session()->flash('message1', 'User deleted successfully!');
    }

    public function updateuser()
    {
        $uniqueRule = 'unique:users,email,' . $this->user_id;
        $validatedData = Validator::make($this->all(), [
            'name'  => 'required|string|max:255',
            'email'      =>  ['required', 'email', $uniqueRule],     
            'role_id'  => 'required'  
        ])->validate();

        User::where('id', $this->user_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id
        ]);
   
    $this->reset();
        session()->flash('message1', 'User updated succesfully');
    }

    public function setpassword($id)
    {   
        $this->edit = false;
        $this->editpass = true;
        $this->user_id = $id;

        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        
    }

    public function updatepassword()
    {
       
        $validatedData = Validator::make($this->all(), [
            'password'  => 'required|string|min:8|confirmed'
        ])->validate();
        User::where('id', $this->user_id)->update([
            'password' => Hash::make($validatedData['password'])
        ]);
        $this->reset();
        session()->flash('message1', 'Password updated succesfully');
    }
}
