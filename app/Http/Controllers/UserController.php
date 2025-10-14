<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    private const TIPO_USUARIO_ADMIN = 1;
    private const TIPO_USUARIO_PROPRIETARIO = 2;
    private const TIPO_USUARIO_INQUILINO = 3;


    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = $this->service->me($request);

        return ['status' => true, 'message' => Geral::USUARIO_ENCONTRADO, "usuario" => $user];
    }

    public function create(UserRequest $request)
    {
        $data = $request->validated();
        
        $data['tipo_usuario_id'] == 1 ==  self::TIPO_USUARIO_ADMIN;
        $data['tipo_usuario_id'] == 2 ==  self::TIPO_USUARIO_PROPRIETARIO;
        $data['tipo_usuario_id'] == 3 ==  self::TIPO_USUARIO_INQUILINO;

        $user = $this->service->create($data);

        return ['status' => true, 'message' => Geral::USUARIO_CADASTRADO, "usuario" => $user];
    }

    public function store(Request $request)
    {
        // ...
    }

    public function edit(string $id)
    {
        // ...
    }

    public function update(Request $request, string $id)
    {
        // ...
    }

    public function destroy(string $id)
    {
        // ...
    }
}