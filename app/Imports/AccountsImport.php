<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class AccountsImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public int $inserted = 0;
    public int $updated  = 0;
    public int $skipped  = 0;

    /**
     * Process each row.
     * Columns expected: account_id, investor_password, master_password
     * Upserts on account_id — updates passwords if the account already exists.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $accountId         = trim($row['account_id']         ?? '');
            $investorPassword  = trim($row['investor_password']  ?? '');
            $masterPassword    = trim($row['master_password']    ?? '');

            if (empty($accountId)) {
                $this->skipped++;
                continue;
            }

            $exists = DB::table('accounts')->where('account_id', $accountId)->exists();

            if ($exists) {
                DB::table('accounts')
                    ->where('account_id', $accountId)
                    ->update([
                        'investor_password' => $investorPassword,
                        'master_password'   => $masterPassword,
                        'updated_at'        => Carbon::now(),
                    ]);
                $this->updated++;
            } else {
                DB::table('accounts')->insert([
                    'account_id'        => $accountId,
                    'investor_password' => $investorPassword,
                    'master_password'   => $masterPassword,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ]);
                $this->inserted++;
            }
        }
    }
}
