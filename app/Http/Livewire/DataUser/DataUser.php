<?php

namespace App\Http\Livewire\DataUser;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class DataUser extends Component
{
	use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $name, $email, $role_id;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	public function mount()
	{
		$this->name = '';
        $this->email = '';
        $this->role_id = '';
	}

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->role_id = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }


    public function render()
    {
		$searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;

		$data = User::select('users.id', 'users.name', 'users.email', DB::raw('roles.name AS nama_role'))
				->join('role_user', 'role_user.user_id', 'users.id')
				->join('roles', 'roles.id', 'role_user.role_id')
				->where('users.name', 'LIKE', $searchTerm)
				->orWhere('users.email', 'LIKE', $searchTerm)
				->orWhere('roles.name', 'LIKE', $searchTerm)
				->orderBy('roles.name', 'ASC')
				->paginate($lengthData);

        return view('livewire.data-user.data-user', compact('data'))
		->extends('layouts.apps', ['title' => 'Data User']);
    }

	public function store()
	{
		$validate = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
		
		$user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
		$user->attachRole($this->roleUser);
		event(new Registered($user));
		$this->resetInputFields();
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',  
            'message' => 'Successfully!', 
            'text' => 'Data Berhasil Dibuat!.'
        ]);
        $this->emit('dataStore');
	}

	public function edit($id)
    {
        $this->updateMode = true;
        $data = User::select('id', 'name', 'email', 'role_id')->join('role_user', 'role_user.user_id', 'users.id')->where('id',$id)->first();
        $this->dataId = $id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->role_id = $data->role_id;
    }

    public function update()
    {
        $validate = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        if ($this->dataId) {
			if( $this->role_id == "admin" )
			{
				$this->role_id = 1;
			}elseif( $this->role_id == "desainer" )
			{
				$this->role_id = 2;
			}elseif( $this->role_id == "produksi" )
			{
				$this->role_id = 3;
			}
            $data = User::findOrFail($this->dataId);
            $data->update([
                'name'   => $this->name,
                'email'  => $this->email,
            ]);
			$roleUser = DB::table('role_user')->where('user_id', $this->dataId)->update(array('role_id' => $this->role_id));
            $this->updateMode = false;
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Successfully!', 
                'text' => 'Data Updated Successfully!.'
            ]);
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }
	
	public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal');
    }

    public function delete()
    {
        $data = User::findOrFail($this->idRemoved);
        $data->delete();
        
        $roleUser = DB::table('role_user')->where('user_id', $this->idRemoved)->delete();
    }

}
