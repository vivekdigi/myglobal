<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

  // public function verifyemail()
  // {

  //   return view('auth.verify-email', [
  //     'title' => 'Verify Your email address',
  //   ]);
  // }

  public function addusername(Request $request)
  {
    Validator::make($request, [
      'username' => ['required', 'unique:users,username'],
    ])->validate();

    User::where('id', Auth::user()->id)->update([
      'username' => $request['username'],
    ]);
    return redirect()->route('dashboard');
  }

  //send contact message to admin email
  public function sendcontact(Request $request)
  {

    $settings = Settings::where('id', '1')->first();

    $message = "$request->message";
    $subject = "Inquiry from $request->name with email $request->email";


    Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));

    return redirect()->back()
      ->with('success', ' Your message was sent successfully!');
  }


  //Get downlines level
  public function getdownlinesold($array, $parent = 0, $level = 0)
  {
    $referedMembers = '';
    foreach ($array as $entry) {
      if ($entry->ref_by == $parent) {

        if ($level == 0) {
          $levelQuote = "Direct referral";
        } else {
          $levelQuote = "Indirect referral level $level";
        }

        $referedMembers .= "
                  <tr>
                  <td> $entry->name $entry->l_name </td> 
                  <td> $levelQuote </td>" .
          '<td>' . $this->getUserParent($entry->id) . '</td>' .
          '<td>' . $this->getUserStatus($entry->id) . '</td>
                  <td>' . $this->getUserRegDate($entry->id) . '</td>
                  </tr>';

        $referedMembers .= $this->getdownlines($array, $entry->id, $level + 1);
      }

      if ($level == 6) {
        break;
      }
    }
    return $referedMembers;
  }
  public function getdownlines($array, $parent = 0, $level = 0)
  {
      $referedMembers = '';
      static $currency = null;
      if ($currency === null) {
          $settings = Settings::where('id', 1)->first();
          $currency = $settings->currency ?? '$';
      }

      foreach ($array as $entry) {
          if ($entry->ref_by == $parent) {

              // Level text
              $levelQuote = $level == 0 
                  ? "Direct referral" 
                  : "Indirect referral level $level";

              // Fetch account ID (from accountid column)
              $accountId = $entry->accountid ?? 'N/A';
              $mobile = $entry->phone ?? 'N/A';

              // Total deposit and total balance
              $totalDeposit = \App\Models\Deposit::where('user', $entry->id)->where('status', 'Processed')->sum('amount');
              $totalDepositFormatted = $currency . number_format($totalDeposit, 2);
              $totalBalanceFormatted = $currency . number_format($entry->account_bal ?? 0, 2);

              // Create table row
              $referedMembers .= "
                  <tr>
                      <td>$accountId</td>
                      <td>$entry->email</td>
                      <td>$mobile</td>
                      <td>$entry->name</td>
                      <td>$levelQuote</td>
                      <td>$totalDepositFormatted</td>
                      <td>$totalBalanceFormatted</td>
                      <td>".$this->getUserParent($entry->id)."</td>
                      <td>".$this->getUserStatus($entry->id)."</td>
                      <td>".$this->getUserRegDate($entry->id)."</td>
                  </tr>
              ";

              // Recursively load next level
              $referedMembers .= $this->getdownlines($array, $entry->id, $level + 1);
          }

          // Stop after level 6
          if ($level == 6) {
              break;
          }
      }

      return $referedMembers;
  }
  //Get user Parent
  function getUserParent($id)
  {
    $user = User::where('id', $id)->first();
    $parent = User::where('id', $user->ref_by)->first();
    if ($parent) {
      return "$parent->name $parent->l_name";
    } else {
      return "null";
    }
  }

  //Get user status
  function getUserStatus($id)
  {
    $user = User::where('id', $id)->first();

    return $user->status;
  }

  //Get User Registration Date
  function getUserRegDate($id)
  {
    $user = User::where('id', $id)->first();

    return $user->created_at;
  }
}
