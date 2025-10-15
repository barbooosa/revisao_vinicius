<?php

namespace App\Repositories;

use App\Models\Apartamento;
use Illuminate\Support\Facades\Auth; // É bom usar o Facade Auth para clareza

class ApartamentoRepository
{
    public function find($id)
    {
        return Apartamento::find($id);
    }

    public function create($data)
    {
        $proprietarioId = Auth::id();

        return Apartamento::create([
            'numero' => $data['numero'],
            'bloco_id' => $data['bloco'],
            'user_morador' => $data['morador'],
            'user_proprietario' => $proprietarioId 
        ]);

    }

    public function list()
    {
        $query = $this->query();

        return $query->paginate(10);
    }

    private function query()
    {
        return Apartamento::with(
            'morador',
            'proprietario',
            'bloco.condominio.user',
            'bloco.condominio.endereco.cidade.estado'
        );
    }

    public function update()
    {
        //
    }
}