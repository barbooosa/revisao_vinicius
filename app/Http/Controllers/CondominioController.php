<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\CondominioRequest; // Mantemos o Request para tipagem, mas o usamos indiretamente
use App\Services\CondominioService;
use Illuminate\Http\Request; // Usamos Request para validar dentro do Controller

class CondominioController extends Controller
{
    protected $service;

    public function __construct(CondominioService $service)
    {
        $this->service = $service;
    }

    public function create(CondominioRequest $request) // Mantemos CondominioRequest para validações que já existam
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ], [
            'nome.required' => 'O nome do condomínio é obrigatório para o cadastro.',
        ]);
        

        $condominio = $this->service->create($request);
        
        return ['status' => true, 'message' => Geral::CONDOMINIO_CADASTRADO, 'condominio' => $condominio];
    }

    public function list(Request $request)
    {
        $condominio = $this->service->list($request);

        return ['status' => true, 'message' => Geral::CONDOMINIO_ENCONTRADO, 'condominio' => $condominio];
    }

    public function search(Request $request)
    {
        $condominio = $this->service->search($request);

        return ['status' => true, 'message' => Geral::CONDOMINIO_ENCONTRADO, 'condominio' => $condominio];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}