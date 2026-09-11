<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountidToWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('withdrawals') && !Schema::hasColumn('withdrawals', 'accountid')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->string('accountid')->nullable()->after('payment_mode');
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
        if (Schema::hasTable('withdrawals') && Schema::hasColumn('withdrawals', 'accountid')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->dropColumn('accountid');
            });
        }
    }
}
