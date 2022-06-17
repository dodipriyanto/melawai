<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create( 'tbl_employee', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');

                $table->string("nik");
                $table->string("nama");
                $table->integer("umur");
                $table->text("alamat");
                $table->string("nomor_telpon");
                $table->date("tanggal_lahir");
                $table->string("tempat_lahir");
                $table->integer("is_have_family");
                $table->text("file_upload");


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