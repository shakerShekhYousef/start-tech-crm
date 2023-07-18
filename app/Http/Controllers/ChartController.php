<?php

namespace App\Http\Controllers;

use App\Models\booktable;
use ArielMejiaDev\LarapexCharts\LarapexChart;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ChartController extends Controller
{

    public function showbooksindex()
    {
        return view('showbooks');
    }

    public function showbooks()
    {
        $data = booktable::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                // $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {

        //Emirates
        $chart = (new LarapexChart)->pieChart()
            ->setTitle('Pie')
            ->addData([
                \App\Models\Data::where('EMIRATE', '=', 'Dubai')->count(),
                \App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count(),
                \App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count(),
            ])
            ->setColors(['#a5378f', '#ffc70b', '#cc2411'])
            ->setLabels(['Dubai', 'Sharjah', 'Abu Dhabi']);



        $chart1 = (new LarapexChart)->barChart()
            ->setTitle('Histogram')
            ->addBar('Dubai', [\App\Models\Data::where('EMIRATE', '=', 'Dubai')->count()])
            ->addBar('Sharjah', [\App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count()])
            ->addBar('Abu Dhabi', [\App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count()])
            ->setColors(['blue'])
            ->setLabels([' ']);
        //End Emirates
        //Nationality

        $chart2 = (new LarapexChart)->barChart()
            ->setTitle('Histogram')
            ->addBar('Russia', [\App\Models\Data::where('NATIONALITY', '=', 'Russia')->count()])
            ->addBar('Kyrgistan', [\App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count()])
            ->addBar('India', [\App\Models\Data::where('NATIONALITY', '=', 'India')->count()])
            ->addBar('Italy', [\App\Models\Data::where('NATIONALITY', '=', 'Italy')->count()])
            ->addBar('South Africa', [\App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count()])
            ->addBar('United Kingdom', [\App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count()])
            ->addBar('United States of America', [\App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count()])
            ->addBar('Pakistan', [\App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count()])
            ->addBar('China', [\App\Models\Data::where('NATIONALITY', '=', 'China')->count()])
            ->addBar('Afghanistan', [\App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count()])
            ->addBar('Kuwait', [\App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count()])
            ->addBar('Iran', [\App\Models\Data::where('NATIONALITY', '=', 'Iran')->count()])
            ->addBar('France', [\App\Models\Data::where('NATIONALITY', '=', 'France')->count()])
            ->addBar('Canada', [\App\Models\Data::where('NATIONALITY', '=', 'Canada')->count()])
            ->addBar('Jordan', [\App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count()])
            ->addBar('Kazakhstan', [\App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count()])
            ->addBar('Brunei', [\App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count()])
            ->addBar('Palestine', [\App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count()])
            ->addBar('Greece', [\App\Models\Data::where('NATIONALITY', '=', 'Greece')->count()])
            ->addBar('Lebanon', [\App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count()])
            ->addBar('South Korea', [\App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count()])
            ->addBar('Bangladesh', [\App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count()])
            ->addBar('United Arab Emirates', [\App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count()])
            ->addBar('Syria', [\App\Models\Data::where('NATIONALITY', '=', 'Syria')->count()])
            ->addBar('Northern Ireland', [\App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count()])
            ->addBar('Morocco', [\App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count()])
            ->setColors(['blue'])
            ->setLabels([' ']);

        $chart3 = (new LarapexChart)->pieChart()
            ->setTitle('Pie')
            ->addData([
                \App\Models\Data::where('NATIONALITY', '=', 'Russia')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'India')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Italy')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'China')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Iran')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'France')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Canada')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Greece')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Syria')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count(),
                \App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count(),
            ])
            ->setColors([
                '#a5378f', '#ffc70b', '#cc2411', '#f00', '#80a2c7', '#985dde', '#7b1dea',
                '#1dea3c', '#157123', '#437115', '#b1bf18', '#bf6218', '#254869', '#2fe8a0', '#de4f4f'
            ])
            ->setLabels([
                'Russia', 'Kyrgistan', 'India', 'Italy', 'South Africa', 'United Kingdom',
                'United States of America', 'Pakistan', 'China', 'Afghanistan', 'Kuwait', 'Iran', 'France', 'Canada', 'Jordan', 'Kazakhstan', 'Brunei', 'Palestine', 'Greece', 'Lebanon', 'South Korea', 'Bangladesh', 'United Arab Emirates', 'Syria', 'Northern Ireland', 'Morocco'
            ]);
        //End Nationality
        //Usage
        $chart4 = (new LarapexChart)->barChart()
            ->setTitle('Histogram')
            ->addBar('Residential', [\App\Models\Data::where('USAGE', '=', 'Residential')->count()])
            ->addBar('Building', [\App\Models\Data::where('USAGE', '=', 'Building')->count()])
            ->addBar('Flat', [\App\Models\Data::where('USAGE', '=', 'Flat')->count()])
            ->setColors(['blue'])
            ->setLabels([' ']);

        $chart5 = (new LarapexChart)->pieChart()
            ->setTitle('Pie')
            ->addData([
                \App\Models\Data::where('USAGE', '=', 'Residential')->count(),
                \App\Models\Data::where('USAGE', '=', 'Building')->count(),
                \App\Models\Data::where('USAGE', '=', 'Flat')->count(),
            ])
            ->setColors(['#ffc70b', '#cc2411', '#a5378f'])
            ->setLabels(['Residential', 'Building', 'Flat']);
        //End Usage

        return view('chart')->with('chart', $chart)->with('chart1', $chart1)
            ->with('chart2', $chart2)->with('chart3', $chart3)
            ->with('chart4', $chart4)->with('chart5', $chart5);
    }
}
