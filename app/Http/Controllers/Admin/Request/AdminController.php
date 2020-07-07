<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ScSchool;
use App\Models\ScStudent;
use App\User;
use Mail;
use PDF;

class AdminController extends Controller
{
    public function dashboard()
    {
    	$date = '2020';
    	$app['school'] = [
    		'year_' . $date => ScSchool::whereYear('created_at', $date)->count(),
    		'year_' . ($date + 1) => ScSchool::whereYear('created_at', $date + 1)->count(),
    		'year_' . ($date + 2) => ScSchool::whereYear('created_at', $date + 2)->count(),
    		'year_' . ($date + 3) => ScSchool::whereYear('created_at', $date + 3)->count(),
    		'year_' . ($date + 4) => ScSchool::whereYear('created_at', $date + 4)->count(),
    		'year_' . ($date + 5) => ScSchool::whereYear('created_at', $date + 5)->count(),
    		'year_' . ($date + 6) => ScSchool::whereYear('created_at', $date + 6)->count(),
    		'year_' . ($date + 7) => ScSchool::whereYear('created_at', $date + 7)->count(),
    		'year_' . ($date + 8) => ScSchool::whereYear('created_at', $date + 8)->count(),
    	];
    	$app['student'] = [
    		'year_' . $date => ScStudent::whereYear('created_at', $date)->count(),
    		'year_' . ($date + 1) => ScStudent::whereYear('created_at', $date + 1)->count(),
    		'year_' . ($date + 2) => ScStudent::whereYear('created_at', $date + 2)->count(),
    		'year_' . ($date + 3) => ScStudent::whereYear('created_at', $date + 3)->count(),
    		'year_' . ($date + 4) => ScStudent::whereYear('created_at', $date + 4)->count(),
    		'year_' . ($date + 5) => ScStudent::whereYear('created_at', $date + 5)->count(),
    		'year_' . ($date + 6) => ScStudent::whereYear('created_at', $date + 6)->count(),
    		'year_' . ($date + 7) => ScStudent::whereYear('created_at', $date + 7)->count(),
    		'year_' . ($date + 8) => ScStudent::whereYear('created_at', $date + 8)->count(),
    	];
    	return response()->json($app);
    }
    public function sending()
    {
    	$to_name = 'Ferdiansyah';
		$to_email = 'ferdisafina123@gmail.com';
		$data = array('name' => "Ferdiansyah", 'body' => "Testing");
		Mail::send('welcome', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name);
			$message->subject('Test Mail');
			$message->from('fer@lavosted','Test Mail');
		});
    }
    public function printPDF() {
        /*$data = [
          'title' => 'The result of ',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
          'user' => User::where('id', 1)->get(),  
        ];
        
        $pdf = PDF::loadView('pdf.template', $data);  
        return $pdf->download('report.pdf');*/
        $wordTest = new \PhpOffice\PhpWord\PhpWord();
        $newSection = $wordTest->addSection();
        $newSection->addText('Hasil Penilaian Ujian Semester 1', array('name' => 'Times New Roman', 'size' => 15));
        $desc1 = "The Portfolio details is a very useful feature of the web page. You can establish your archived details and the works to the entire web community. It was outlined to bring in extra clients, get you selected based on this details.";
        $newSection->addText($desc1, array('name' => 'Tahoma', 'size' => 15, 'color' => 'red'));
        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
        try {
        $objectWriter->save(storage_path('TestWordFile.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('TestWordFile.docx'));
    }
}
