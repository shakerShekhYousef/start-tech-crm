<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Data;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportExcelController extends Controller
{
  function index()
  {
    $c_data = DB::table('data')->get();
    return view('export_excel')->with('c_data', $c_data);
  }

  function excel(Request $request)
  {
    try {

      $emirates = $request->emirate;
      $area = $request->area;
      $residence = $request->residence;
      $search = $request->search;
      $startdate = $request->startdate;
      $enddate = $request->enddate;
      $monthfiltertext = $request->searchmonth;
      $filtertype = $request->filtertype;
      $searchdaytext = $request->searchday;


      $sdate = null;
      $edate = null;
      if (!is_null($startdate) && !is_null($enddate) && $filtertype == 0) {
          $sdate = Carbon::parse($startdate);
          $edate = Carbon::parse($enddate);
          if ($sdate->gt($edate))
              return response()->json(['message' => 'start date must smaller than end date']);
      }

      if (!is_null($startdate) && $filtertype == 1) {
          $sdate = Carbon::parse($startdate);
      }

      if (!is_null($monthfiltertext) && $filtertype == 1) {
          $request->validate(['searchmonth' => 'numeric']);
      }

      $query = Data::query();
      $columns = Data::columns;
      if (!is_null($search)) {
          for ($i = 0; $i < count($columns) - 1; $i++) {
              $query->orWhere(function ($query) use ($search, $columns, $i, $residence, $area, $emirates, $sdate, $edate, $monthfiltertext, $filtertype, $searchdaytext) {
                  $query->where($columns[$i], 'LIKE', '%' . $search . '%');
                  if (!is_null($residence) && $residence != "Show") {
                      $query->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
                  }
                  if (!is_null($area) && $area != "Show") {
                      $query->where('AREA', 'LIKE', '%' . $area . '%');
                  }
                  if (!is_null($emirates) && $emirates != "Show")
                      $query->where('EMIRATE', 'LIKE', '%' . $emirates . '%');

                  if (!is_null($sdate) && !is_null($edate) && $filtertype == 0)
                      $query->whereBetween('DOB', [$sdate, $edate]);

                  if (!is_null($monthfiltertext) && $filtertype == 2)
                      $query->whereMonth('DOB', '=', $monthfiltertext);

                  if (!is_null($searchdaytext) && $filtertype == 1)
                      $query->whereDay('DOB', '=', $searchdaytext);
              });
          }
      } else {
          if (!is_null($emirates) && $emirates != "Show")
              $query->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
          if (!is_null($area) && $area != "Show")
              $query->where('AREA', 'LIKE', '%' . $area . '%');
          if (!is_null($residence) && $residence != "Show") {
              $query->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
          }
          if (!is_null($sdate) && !is_null($edate) && $filtertype == 0) {
              $query->whereBetween('DOB', [$sdate, $edate]);
          }
          if (!is_null($monthfiltertext) && $filtertype == 2)
              $query->whereMonth('DOB', '=', $monthfiltertext);

          if (!is_null($searchdaytext) && $filtertype == 1)
              $query->whereDay('DOB', '=', $searchdaytext);
      }
      $data = $query->get();

      $random = rand();
      Excel::store(new DataExport($data), 'DR Export from Cleaning Data_' . $random . '.xlsx', 'exports');
      $filename = 'DR Export from Cleaning Data_' . $random . '.xlsx';
      return response()->json([
        'success' => true,
        'path' => url('/storage/exports/' . $filename),
        'file name' => $filename
      ], 200);
    } catch (Exception $ex) {
      return response()->json([
        'success' => false,
        'message' => $ex->getMessage(),

      ], 404);
    }
  }
}
