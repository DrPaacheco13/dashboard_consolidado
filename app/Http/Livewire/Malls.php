<?php

namespace App\Http\Livewire;

use App\Models\mall;
use Livewire\Component;

class Malls extends Component
{
    public $data, $nombre, $selected_id;
    public $updateMode = false;

    public function render()
    {
        $this->data = mall::all();
        return view('livewire.malls');
    }

    private function resetInput()
    {
        $this->nombre = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:5',
        ]);

        mall::create([
            'nombre' => $this->nombre,
        ]);

        $this->resetInput();
    }

    public function edit($id)
    {
        $record = mall::findOrFail($id);

        $this->selected_id = $id;
        $this->nombre = $record->nombre;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'nombre' => 'required|min:5'
        ]);

        if ($this->selected_id) {
            $record = mall::find($this->selected_id);
            $record->update([
                'nombre' => $this->nombre
            ]);

            $this->resetInput();
            $this->updateMode = false;
        }
    }
    public function destroy($id)
    {
        if($id){
            $record = mall::where('id', $id);
            $record->delete();
        }
    }
}
