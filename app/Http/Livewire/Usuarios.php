<?php

namespace App\Http\Livewire;

use App\Models\mall;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Usuarios extends Component
{
    public $data, $name, $email, $id_mall, $selected_id, $password;
    public $updateMode = false;

    public function render()
    {
        $this->data = DB::connection('mysql')->select(DB::raw('SELECT us.id, us.name, us.email, us.email_verified_at, us.password, us.remember_token, us.created_at, us.updated_at, us.role_id, ma.nombre
        FROM users us
        join malls ma on us.id_mall = ma.id'));
        $mall = mall::all();
        return view('livewire.usuarios', compact('mall'));
    }

    private function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->id_mall = null;
        $this->password = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email:rfc,dns',
            'id_mall' => 'required',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'id_mall' => $this->id_mall,
            'password' => bcrypt($this->password)
        ]);

        $this->resetInput();
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);

        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->id_mall = $record->id_mall;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required|min:5',
            'email' => 'required|email:rfc,dns',
            'id_mall' => 'required|numeric',
        ]);

        if ($this->selected_id) {
            $record = User::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'email' => $this->email,
                'id_mall' => $this->id_mall,
            ]);

            $this->resetInput();
            $this->updateMode = false;
        }
    }
    public function destroy($id)
    {
        if($id){
            $record = User::where('id', $id);
            $record->delete();
        }
    }
}
