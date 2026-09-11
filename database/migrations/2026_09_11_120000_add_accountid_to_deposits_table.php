<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountidToDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('deposits') && !Schema::hasColumn('deposits', 'accountid')) {
            Schema::table('deposits', function (Blueprint $table) {
                $table->string('accountid')->nullable()->after('txn_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('deposits') && Schema::hasColumn('deposits', 'accountid')) {
            Schema::table('deposits', function (Blueprint $table) {
                $table->dropColumn('accountid');
            });
        }
    }
}
