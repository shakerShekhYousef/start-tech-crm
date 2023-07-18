<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\ImportingDataFinishedNotification;
use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\uploadedFile;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ImportExcelController extends Controller
{
    protected  $rowscount = 0;
    public function index()
    {
        return view('import');
    }

    public function importFile($pathToExcel, $filename)
    {
        try {
            (new FastExcel())->import($pathToExcel, function ($row) use ($filename) {
                $row = array_values($row);

                // $textval = "Hello, regarding the web services. https://www.alifouad91.com";

                $phone = trim($row[10]);
                $mobile = trim($row[16]);
                $secondarymobile = trim($row[17]);

                // $phoneStringVal = "https://web.whatsapp.com/send?phone=" . $phone . "&text=" . $textval;
                // $mobileStringVal = "https://web.whatsapp.com/send?phone=" . $mobile . "&text=" . $textval;
                // $secondaryMobileStringVal = "https://web.whatsapp.com/send?phone=" . $secondarymobile . "&text=" . $textval;
                $phoneStringVal = "https://web.whatsapp.com/send?phone=" . $phone;
                $mobileStringVal = "https://web.whatsapp.com/send?phone=" . $mobile;
                $secondaryMobileStringVal = "https://web.whatsapp.com/send?phone=" . $secondarymobile;

                $mapLocations = explode(',', $row[34]);
                try {
                    $allData = Data::updateOrCreate(
                        [
                            'UNIQUE' =>  $row[0],
                            'PHONE' =>  trim($row[10]),
                            'EMAIL' =>  trim($row[11]),
                        ],
                        [
                            'UNIQUE' =>  $row[0],
                            'P_NUMBER' =>  $row[1],
                            'AREA' => $row[2] == '' ? '-' : $row[2],
                            'USAGE' =>  $row[3] == '' ? '-' : $row[3],
                            'TOTAL_AREA' => $row[4] == '' ? '-' : $row[4],
                            'PLOT_NUMBER' =>  $row[5] == '' ? '-' : $row[5],
                            'EMIRATE' =>  $row[6] == '' ? '-' : $row[6],
                            'NAME' => $row[7] == '' ? '-' : $row[7],
                            'AREA_OWNED' => $row[8] == '' ? '-' : $row[8],
                            'ADDRESS' =>  $row[9] == '' ? '-' : $row[9],
                            'PHONE' =>  trim($row[10]),
                            // 'phone_whatsup' =>  $row[10] == '' ? '-' : $phoneStringVal,
                            'EMAIL' =>  trim($row[11]),
                            'FAX' =>  $row[12] == '' ? '-' : $row[12],
                            'PO_BOX' =>  $row[13] == '' ? '-' : $row[13],
                            'GENDER' => $row[14] == '' ? '-' : $row[14],
                            'DOB' =>  $row[15] == '' ? '-' : Carbon::parse($row[15])->toDateString(),
                            'MOBILE' =>  $row[16] == '' ? '-' : $row[16],
                            // 'MOBILE_whatsup' =>  $row[16] == '' ? '-' : $mobileStringVal,
                            'SECONDARY_MOBILE' => $row[17] == '' ? '-' : $row[17],
                            // 'SECONDARY_MOBILE_wahtsup' => $row[17] == '' ? '-' : $secondaryMobileStringVal,
                            'PASSPORT' => $row[18] == '' ? '-' : $row[18],
                            'ISSUE_DATE' =>  $row[19] == '' ? '-' : Carbon::parse($row[19])->toDateString(),
                            'EXPIRY_DATE' => $row[20] == '' ? '-' : Carbon::parse($row[20])->toDateString(),
                            'PLACE_OF_ISSUE' =>  $row[21] == '' ? '-' : $row[21],
                            'EMIRATES_ID_NUMBER' =>  $row[22] == '' ? '-' : $row[22],
                            'EMIRATES_ID_EXPIRY_DATE' => $row[23] == '' ? '-' : Carbon::parse($row[23])->toDateString(),
                            'RESIDENCE_COUNTRY' =>  $row[24] == '' ? '-' : $row[24],
                            'NATIONALITY' =>  $row[25] == '' ? '-' : $row[25],
                            'Master_Project' =>  $row[26] == '' ? '-' : $row[26],
                            'Project' =>  $row[27] == '' ? '-' : $row[27],
                            'Building_Name' =>  $row[28] == '' ? '-' : $row[28],
                            'Agents' =>  $row[29] == '' ? '-' : $row[29],
                            'Flat_Number' => $row[30] == '' ? '-' : $row[30],
                            'No_of_Beds' => $row[31] == '' ? '-' : $row[31],
                            'Floor' =>  $row[32] == '' ? '-' : $row[32],
                            'registration_number' =>  $row[33] == '' ? '-' : $row[33],
                            'lat' =>  $row[34] == '' ? '' : $mapLocations[0],
                            'lng' =>  $row[34] == '' ? '' : $mapLocations[1],
                            'Source' => $filename,
                            'file' => $filename,
                        ]
                    );
                    if ($allData->wasRecentlyCreated) {
                        $this->rowscount += 1;
                    }
                } catch (Exception $ex) {
                    // dd($ex);
                }
            });
        } catch (Exception $ex) {
            Log::channel('crm_logs')->info($ex->getMessage());
        }
    }

    public function tempSplit($pathToCSV, $chunkSize = 30000)
    {
        setlocale(LC_ALL, 'ar_AE.utf8');
        $tmp_folder_name = 'temp_' . rand(10000, 999999);
        $tmp_dir_path = "uploadedFiles/$tmp_folder_name";
        mkdir($tmp_dir_path);


        $in = fopen($pathToCSV, 'r');

        $rowCount = 0;
        $fileCount = 1;
        $out = 0;
        $files = [];
        $header = false;
        while (!feof($in)) {
            if (($rowCount % $chunkSize) == 0) {
                if ($rowCount > 0) {
                    fclose($out);
                }
                $new_file = $tmp_dir_path . '/' . $fileCount++ . '.csv';
                $files[] = $new_file;
                $out = fopen($new_file, 'w');
                if ($header) {
                    fputcsv($out, $header);
                }
            }
            $data = fgetcsv($in);
            if ($data) {
                if (!$rowCount)
                    $header = $data;
                fputcsv($out, $data);
            }
            $rowCount++;
        }

        fclose($out);
        return [
            'folder' => $tmp_dir_path,
            'files' => $files
        ];
    }

    public function import(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv',
            ]
        );
        $validator->validate();

        try {
            $Authuserimportstatus = Auth::user()->getcurrentproccessstatus();
            $Userimportingdata = Auth::user()->getuserimportingdata();
            if ($Userimportingdata == 0 || $Userimportingdata == Auth::user()->id) {
                if ($Authuserimportstatus == 2 || $Authuserimportstatus == 1) {
                    $file = $request->file;

                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    report::create([
                        'currentuser' => Auth::user()->id,
                        'proccessname' => 'Import excel file',
                        'state' => config('importstatus.import_status.in_progress'),
                        'description' => $filename
                    ]);

                    $extention = $file->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extention;
                    $request->file->move(public_path('uploadedFiles'), $fileNameToStore);

                    $pathToExcel = 'uploadedFiles/' . $fileNameToStore;
                    $xx = $this->tempSplit($pathToExcel);
                    foreach ($xx['files'] as $x) {
                        $this->importFile($x, $filename);
                    }


                    Report::where('state', config('importstatus.import_status.in_progress'))
                        ->where('currentuser', Auth::user()->id)
                        ->update([
                            'state' => config('importstatus.import_status.done')
                        ]);

                    uploadedFile::create([
                        'fileName' => $fileNameToStore,
                        'numberofimportedrows' => $this->rowscount
                    ]);

                    // send email
                    dispatch(new SendEmailJob(Auth::user()->getfilename()));

                    // finished
                    File::deleteDirectory($xx['folder']);

                    return response()->json(['success' => 'true', 'message' => 'Importing process has finished']);
                } else {
                    return response()->json(['success' => 'false', 'message' => 'Failed to import data because current user is already importig data and not finished yet']);
                }
            } else {
                $user = User::find($Userimportingdata);
                return response()->json(['success' => 'false', 'message' => 'Failed to import data because user ' . $user->name . ' is already importig data and not finished yet']);
            }
        } catch (Exception $ex) {
            Report::where('state', config('importstatus.import_status.in_progress'))
                ->where('currentuser', Auth::user()->id)
                ->update([
                    'state' => config('importstatus.import_status.failed'),
                    'description' => $ex->getMessage()
                ]);

            return response()->json([
                'success' => 'false',
                'error' => 'Un error happened please try again later or contact support!'
            ]);
        }
    }


    public function deleteFile($id)
    {
        $file = uploadedFile::findOrFail($id);

        $rows = Data::where('file', '=', $file->fileName)->delete();

        $file->delete();

        return response()->json('success');
    }
}
