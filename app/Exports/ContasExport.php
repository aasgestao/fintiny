<?php
namespace App\Exports;

use App\Models\ContasModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContasExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        return ContasModel::when($this->request->filled("conta"), function ($query) {
            $query->where("conta", "like", "%" . $this->request->input("conta") . "%");
        })
        ->when($this->request->filled("empresa"), function ($query) {
            $query->where("empresa", "like", "%" . $this->request->input("empresa") . "%");
        })
        ->when($this->request->filled("contato"), function ($query) {
            $query->where("contato", "like", "%" . $this->request->input("contato") . "%");
        })
        ->when($this->request->filled("historico"), function ($query) {
            $query->where("historico", "like", "%" . $this->request->input("historico") . "%");
        })
        ->when($this->request->filled("tipo"), function ($query) {
            $query->where("tipo", $this->request->input("tipo"));
        })
        ->when($this->request->filled("categoria"), function ($query) {
            $query->where("categoria", "like", "%" . $this->request->input("categoria") . "%");
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
        return ["ID", "Empresa", "Data", "Categoria", "Histórico", "Tipo", "Valor", "ID_Tiny", "Cliente/Contato", "CNPJ/CPF","Marcadores","Conta", "Nro_Docto","Criado em", "Atualizado em"];
    }
}
