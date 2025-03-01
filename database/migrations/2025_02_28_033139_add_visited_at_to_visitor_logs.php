<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitedAtToVisitorLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->timestamp('visited_at')->useCurrent()->after('ip_address');
        });
    }

    public function down()
    {
        Schema::table('visitor_logs', function (Blueprint $table) {
            $table->dropColumn('visited_at');
        });
    }
}
