<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedAtToVisitorLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
}
