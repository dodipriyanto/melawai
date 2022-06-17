<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCovidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create( 'tbl_employeecovid', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');

                $table->string("pegawai_id");
                $table->date("tanggal_terjangkit")->nullable();
                $table->date("tanggal_sembuh")->nullable();
                

                $table->softDeletes();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

}