<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create( 'tbl_employeefamily', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');

                $table->uuid('pegawai_id')->nullable(true);
                $table->string("status_keluarga");
                $table->string("nama");
                $table->integer("umur");
                $table->string("tempat_lahir");
                $table->date("tanggal_lahir");
                $table->string("nomor_telpon");
                

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