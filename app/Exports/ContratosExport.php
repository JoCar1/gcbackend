<?php

namespace App\Exports;

use App\Contrato;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;


class ContratosExport implements ShouldAutoSize, FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    private $id;
    private $dateinicio;
    private $datefin;

    public function __construct(int $id,string $dateinicio,string $datefin)
    {
        $this->id = $id;
        $this->dateinicio = $dateinicio;
        $this->datefin = $datefin;
    }


    public function headings(): array
    {
        return [
            'Nombre contrato',
            'Socio',
            'Creado por',
            'Categoria',
            'estado',
            'Telefono',
            'Descripcion',
            'Fecha inicio',
            'Fecha plazo de cancelacion',
            'Fecha fin',
            'Fecha prolongacion',
            'Responsable',
            'Unidad Organizativa',
            'Contacto adicional',
            'Fecha de creacion',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($contrato): array
    {
        return [
            $contrato->nombre,
            $contrato->socio->nombre,
            $contrato->user->nombre,
            $contrato->categoria->nombre,
            $contrato->estado,
            $contrato->telefono,
            $contrato->descripcion,
            $contrato->fecha_inicio,
            $contrato->fecha_plazo_cancelacion,
            $contrato->fecha_fin,
            $contrato->fecha_prolongacion,
            $contrato->responsablecontrato->nombre,
            $contrato->organizativaunidad->nombre,
            $contrato->contacto_adicional,
            $contrato->created_at,
            // Date::dateTimeToExcel($contrato->created_at),
        ];
    }
    public function collection()
    {
        $user = User::find($this->id);
        $ini = $this->dateinicio;
        $fin = $this->datefin;

        if($user->rol == 'visor'){
            return Contrato::where('organizativa_unidad_id',$user->organizativa_unidad_id)
            ->where(function($querydata) use($ini,$fin){
                if($ini && $fin){
                    $querydata->whereBetween('created_at',[$ini,$fin]);
                }
            })->get();
            
        }else{
            return Contrato::where(function($querydata) use($ini,$fin){
                if($ini && $fin){
                    $querydata->whereBetween('created_at',[$ini,$fin]);
                }
            })->get();
        }
        
        // return Contrato::where('organizativa_unidad_id',Auth::user()->organizativa_unidad_id)->get();
    }
}
