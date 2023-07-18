<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('P_NUMBER');
            $table->string('AREA');
            $table->string('USAGE');
            $table->string('TOTAL_AREA');
            $table->string('PLOT_NUMBER');
            $table->string('EMIRATE');
            $table->string('NAME');
            $table->string('AREA_OWNED');
            $table->string('ADDRESS');
            $table->string('PHONE');
            $table->string('EMAIL');
            $table->string('FAX');
            $table->string('PO_BOX');
            $table->string('GENDER');
            $table->string('DOB');
            $table->string('MOBILE');
            $table->string('SECONDARY_MOBILE');
            $table->string('PASSPORT');
            $table->string('ISSUE_DATE');
            $table->string('EXPIRY_DATE');
            $table->string('PLACE_OF_ISSUE');
            $table->string('EMIRATES_ID_NUMBER');
            $table->string('EMIRATES_ID_EXPIRY_DATE');
            $table->string('RESIDENCE_COUNTRY');
            $table->string('NATIONALITY');
            $table->string('Master_Project');
            $table->string('Project');
            $table->string('Building_Name');
            $table->string('Agents');
            $table->string('Flat_Number');
            $table->string('No_of_Beds');
            $table->string('Floor');
            $table->string('registration_number');
            $table->string('lat');
            $table->string('lng');
            $table->string('file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
}
//P-NUMBER,AREA,USAGE,TOTAL_AREA,PLOT_NUMBER,EMIRATE,NAME,AREA_OWNED,ADDRESS,PHONE,EMAIL,FAX,PO_BOX,GENDER,DOB,MOBILE,SECONDARY_MOBILE,PASSPORT,ISSUE_DATE,EXPIRY_DATE,PLACE_OF_ISSUE,EMIRATES_ID_NUMBER,EMIRATES_ID_EXPIRY_DATE,RESIDENCE_COUNTRY,NATIONALITY,Master_Project,Project,Building_Name,Agents,Flat_Number,No_of_Beds,Floor,registration_number