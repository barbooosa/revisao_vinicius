<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\ApartamentoRequest;
use App\Services\ApartamentoService;
use Illuminate\Http\Request;
use App\Models\Apartamento; // Necessário para findOrFail

class ApartamentoController extends Controller
{
    protected $service;

    public function __construct(ApartamentoService $service)
    {
        $this->service = $service;
    }


    public function create(ApartamentoRequest $request)
    {
        $this->authorize('create', Apartamento::class);
        
        $apartamento = $this->service->create($request);

        if ($apartamento == true && $apartamento !== false) {
            return ['status' => true, 'message' => Geral::APARTAMENTO_CADASTRADO, 'apartamento' => $apartamento];
        } else {
            return ['status' => false, 'message' => Geral::APARTAMENTO_EXISTE, 'apartamento' => $apartamento];
        }
    }

    public function list()
    {
        $apartamento = $this->service->list();

        return ['status' => true, 'message' => Geral::APARTAMENTO_ENCONTRADO, 'apartamento' => $apartamento];
    }

    public function update(ApartamentoRequest $request, string $id)
    {
        $apartamento = Apartamento::findOrFail($id);
        
        $this->authorize('update', $apartamento);

        $apartamento = $this->service->update($request, $id);

        return ['status' => true, 'message' => Geral::APARTAMENTO_ATUALIZADO, "apartamento" => $apartamento];
    }

    public function destroy(string $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        $this->authorize('delete', $apartamento);

        $this->service->delete($apartamento); 
        return ['status' => true, 'message' => Geral::APARTAMENTO_EXCLUIDO];
    }
}