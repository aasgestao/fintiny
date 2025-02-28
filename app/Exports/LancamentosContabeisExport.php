<?php
namespace App\Exports;

use App\Models\ContasModel;
use App\Models\LancamentosContabeisModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LancamentosContabeisExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        
         return LancamentosContabeisModel::when($this->request->filled("busca"), function ($query) {
            $query->where("historico", "like", "%" . $this->request->input("busca") . "%");
        })
        ->when($this->request->filled("busca"), function ($query) {
            $query->where("conta_debito", "like", "%" . $this->request->input("busca") . "%");
        })
        ->when($this->request->filled("busca"), function ($query) {
            $query->where("conta_credito", "like", "%" . $this->request->input("busca") . "%");
        })
        ->when($this->request->filled("busca"), function ($query) {
            $query->where("id_tiny", "like", "%" . $this->request->input("busca") . "%");
        })
        ->when($this->request->filled("busca"), function ($query) {
            $query->where("valor", $this->request->input("busca"));
        })
        
        ->when($this->request->filled("data_inicial"), function ($query) {
            $query->where("data", ">=", $this->request->input("data_inicial"));
        })
        ->when($this->request->filled("data_final"), function ($query) {
            $query->where("data", "<=", $this->request->input("data_final"));
        });

        
    }

    public function headings(): array
    {
        return ["ID", "Empresa", "Data", "Valor", "Debito", "Credito", "Historico","Criado em", "Atualizado em"];
    }
}
