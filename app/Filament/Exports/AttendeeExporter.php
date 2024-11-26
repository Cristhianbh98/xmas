<?php

namespace App\Filament\Exports;

use App\Models\Attendee;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AttendeeExporter extends Exporter
{
    protected static ?string $model = Attendee::class;

    public static function getColumns(): array {
        $columns = [
            ExportColumn::make('name')
                ->label('Nombre'),
            ExportColumn::make('cedula')
                ->label('Cédula'),
            ExportColumn::make('phone')
                ->label('Teléfono'),
            ExportColumn::make('email')
                ->label('Correo'),
            ExportColumn::make('address')
                ->label('Dirección'),
            ExportColumn::make('parallel')
                ->label('Paralelo'),
            ExportColumn::make('comment')
                ->label('Observación'),
            ExportColumn::make('attendance')
                ->label('Asistencia'),
            ExportColumn::make('companions_count')
                ->counts('companions')
                ->label('Acompañantes')
        ];

        $maxCompanions = Attendee::withCount('companions')->get()->max('companions_count');

        for ($i = 0; $i < $maxCompanions; $i++) {
            $position = $i + 1;
            $columns[] = ExportColumn::make('companion_' . $position . '_name')
                ->label('Acompañante ' . $position . ' Nombre')
                ->state(function (Attendee $attendee) use ($i) {
                    return optional($attendee->companions[$i] ?? null)->name;
                });

            $columns[] = ExportColumn::make('companion_' . $position . '_cedula')
                ->label('Acompañante ' . $position . ' Cédula')
                ->state(function (Attendee $attendee) use ($i) {
                    return optional($attendee->companions[$i] ?? null)->cedula;
                });

            $columns[] = ExportColumn::make('companion_' . $position . '_email')
                ->label('Acompañante ' . $position . ' Correo')
                ->state(function (Attendee $attendee) use ($i) {
                    return optional($attendee->companions[$i] ?? null)->email;
                });

            $columns[] = ExportColumn::make('companion_' . $position . '_phone')
                ->label('Acompañante ' . $position . ' Teléfono')
                ->state(function (Attendee $attendee) use ($i) {
                    return optional($attendee->companions[$i] ?? null)->phone;
                });
        }

        return $columns;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your attendee export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
