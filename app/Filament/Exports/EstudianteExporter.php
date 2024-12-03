<?php

namespace App\Filament\Exports;

use App\Models\Estudiante;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EstudianteExporter extends Exporter
{
    protected static ?string $model = Estudiante::class;

    public static function getColumns(): array
    {
        $columns = [
            ExportColumn::make('cedula')
                ->label('Cédula'),
            ExportColumn::make('last_name')
                ->label('Apellidos'),
            ExportColumn::make('first_name')
                ->label('Nombres'),
            ExportColumn::make('age')
                ->label('Edad'),
            ExportColumn::make('representante.nombre_completo')
                ->label('Representante'),
            ExportColumn::make('representante.cedula')
                ->label('Cédula del Representante'),
            ExportColumn::make('tipo_entrega')
                ->label('Tipo de Entrega'),
            ExportColumn::make('cdc.name')
                ->label('Centro de Desarrollo Comunal'),
            ExportColumn::make('cdi.name')
                ->label('Centro de Desarrollo Infantil'),
            ExportColumn::make('parroquia.name')
                ->label('Parroquia'),
            ExportColumn::make('barrio.name')
                ->label('Barrio'),                
        ];

        return $columns;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your estudiante export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
