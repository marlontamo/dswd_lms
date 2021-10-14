<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Auth\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DB;
use Maatwebsite\Excel\Concerns\WithStyles;
class ActivityReport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    private $headings = [
        'ACTIVITY_ID', 
        'EMAIL',
        'REPORTING_TO',
        'DIVISION',
        'ACTIVITY TITLE',
        'Proposed Date',
        'Proposed Venue',
        'FIELD_OFFICE',
        'CENTRAL OFFICE',
        'OBLIGATED AMOUNT',
        'male',
        'female',
        'municipality represented'
    ];
    /**
     *
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $full =  DB::table('activity_accomplishment_entry')
        ->join('activity_details_cbs', 'activity_accomplishment_entry.id','=','activity_details_cbs.activity_id')
        ->join('actual_number_of_participants','activity_accomplishment_entry.id', '=','actual_number_of_participants.Activity_id')
        ->join('reporting_to', 'reporting_to.id','=','activity_accomplishment_entry.reporting_to')
        //->join('activity_rating', 'activity_accomplishment_entry.id','=','activity_rating.Activity_id')
        ->where('activity_accomplishment_entry.id','=',)
        ->select('activity_accomplishment_entry.id',
        'activity_accomplishment_entry.email',
        'reporting_to.title',
        'activity_accomplishment_entry.division',
        'activity_details_cbs.Activity_Title',
        'activity_details_cbs.Proposed_date_of_conduct',
        'activity_details_cbs.proposed_venue',
        'activity_details_cbs.field_office',
        'activity_details_cbs.central_office',
        'activity_details_cbs.obligated_amount',
        'actual_number_of_participants.staff_FO_male',
        'actual_number_of_participants.staff_FO_female',
        'actual_number_of_participants.municipality_represented')
        ->get();
return $full;
    }
    public function headings(): array
    {
        return $this->headings;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }
    public function styles(Worksheet $sheet)
{
    return [
       // Style the first row as bold text.
       1    => ['font' => ['bold' => true]],
    ];
}     
    
}
