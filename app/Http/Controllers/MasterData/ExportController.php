<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function export_preparation($slug)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $user = auth()->user();
        $userId = $user->id == 1 ? request('user_id') : $user->id;

        $richText = new RichText();

        $preparation = DB::table('preparations')
                        ->join('mountains', 'mountains.id', '=', 'preparations.mountain_id')
                        ->where('preparations.slug', $slug)
                        ->select(
                            'mountains.name as mountain_name',
                            'mountains.elevation',
                            'mountains.location',
                            'preparations.departure_date',
                            'preparations.return_date',
                            'preparations.budget_estimate'
                        )
                        ->first();

        // Bagian pertama: Judul (bold + font-size 12)
        $title = $richText->createTextRun("Gunung " . $preparation->mountain_name . "\n");
        $title->getFont()->setBold(true);
        $title->getFont()->setSize(12);

        // Format detail
        $details = [
            number_format($preparation->elevation, 0, ',', '.') . ' Mdpl',
            $preparation->location,
            \Carbon\Carbon::parse($preparation->departure_date)->translatedFormat('d F') .
            ' - ' .
            \Carbon\Carbon::parse($preparation->return_date)->translatedFormat('d F Y'),
            'Total Budget: Rp' . number_format($preparation->budget_estimate, 0, ',', '.'),
        ];

        // Tambahkan ke richText
        foreach ($details as $line) {
            $text = $richText->createTextRun("$line\n");
            $text->getFont()->setSize(10);
        }

        // Set rich text ke cell
        $sheet->setCellValue('B2', $richText);

        // Merge & wrap text
        $sheet->mergeCells('B2:I6');
        $sheet->getStyle('B2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('B2')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        $headers = ['Equipment', 'Check', 'Quantity', 'Status', 'Urgency', 'Category', 'Price', 'Group?'];
        $sheet->fromArray($headers, NULL, 'B8');

        // Styling header
        $sheet->getStyle('B8:I8')->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('B8:I8')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('B8:I8')->getAlignment()->setVertical('center');

        $data = DB::table('preparations')
                    ->leftJoin('preparation_items', 'preparation_items.preparation_id', '=', 'preparations.id')
                    ->join('types', 'types.id', '=', 'preparation_items.type_id')
                    ->join('categories', 'categories.id', '=', 'preparation_items.category_id')
                    ->where('preparations.slug', $slug)
                    ->where('preparation_items.is_selected', 1)
                    ->select(
                        'types.name as name_type',
                        'preparation_items.quantity as quantity',
                        'preparation_items.status_gear as status',
                        'preparation_items.category_gear as urgency',
                        'categories.name as category',
                        'preparation_items.price',
                        DB::raw("IF(preparation_items.is_group = 1, 'Yes', 'No') as is_group")
                    )
                    ->get()
                    ->map(function ($item) {
                        // Decode urgency jika string JSON
                        if (is_string($item->urgency) && str_starts_with($item->urgency, '[')) {
                            $urgencies = json_decode($item->urgency, true);
                        } elseif (is_array($item->urgency)) {
                            $urgencies = $item->urgency;
                        } else {
                            $urgencies = [$item->urgency]; // fallback satu string biasa
                        }

                        // Capitalize tiap item urgency
                        $urgency = implode(', ', array_map(function ($u) {
                            return ucwords(str_replace('_', ' ', $u));
                        }, $urgencies));

                        // Format status (snake_case → Capitalized)
                        $status = ucwords(str_replace('_', ' ', $item->status));

                        // Format harga
                        $price = 'Rp' . number_format($item->price, 0, ',', '.');

                        return [
                            $item->name_type,
                            '',
                            $item->quantity,
                            $status,
                            $urgency,
                            $item->category,
                            $price,
                            $item->is_group,
                        ];
                    })
                    ->toArray();

        $sheet->fromArray($data, NULL, 'B9');

        // Styling body
        $lastRow = 8 + count($data);
        $sheet->getStyle("B9:I$lastRow")->getFont()->setSize(10);
        $sheet->getStyle("B9:I$lastRow")->getAlignment()->setHorizontal('left');
        $sheet->getStyle("B9:I$lastRow")->getAlignment()->setVertical('top');

        // Border
        $sheet->getStyle("B8:I$lastRow")->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );

        // Row height
        for ($row = 8; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Auto width
        foreach (range('B', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Export response
        $writer = new Xlsx($spreadsheet);
        $filename = 'pendakian_detail.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
