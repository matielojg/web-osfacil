<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function search(Request $request)
    {
//        dd($request->all());
        $query = null;

        if ($request->search === '1') {
            session()->put('governanca', 1);
            session()->remove('manutencao');
            $query = $this->createQuery('name_service');
        }
        if ($request->search === '2') {
            session()->put('manutencao', 2);
            session()->remove('governanca');
            $query = $this->createQuery('name_service');
        }

        if ($query->count()) {
            foreach ($query as $serviceSector) {
                $name_service[] = $serviceSector->name_service;
            }
            $collect = collect($name_service);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }


        return response()->json($this->setResponse('fail', [], 'Ops, a busca não retornou nada!'));

//        var_dump($name_service);
//        $json['success'] = $teste;
//        return response()->json($json);
    }

    private function createQuery($field)
    {
        $governanca = session('governanca');
        $manutencao = session('manutencao');
        return DB::table('services')
            ->when($governanca, function ($query, $governanca) {
                return $query->where('sector', $governanca);
            })
            ->when($manutencao, function ($query, $manutencao) {
                return $query->where('sector', $manutencao);
            })
            ->get([$field]);
    }

    private function setResponse(string $status, array $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }
}
