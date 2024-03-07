<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notificationQueue = 'emails';

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public $resource;
     public $type;
    public function __construct($resource,$type)
    {
        $this->resource = $resource;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       switch ($this->type) {
        case 1:
                $payment =$this->resource;
                $message =$payment->member?->member_name.' Has Paid '. number_format($payment->amount).' with payment reference '.$payment->payment_reference.' , Please Login To the system Verify and approve the payment';
                $subject ="Payment Approve/Reject Request";
                $receiver_name ="Fortunatus Shao";
                $receiver_email ="fortunatus.edes@gmail.com";
                //$receiver_email ="lupenza10@gmail.com";
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;
        
         case 2:
                $payment =$this->resource;
                $message ='Your Payment of '. number_format($payment->amount).' with payment reference '.$payment->payment_reference.', Paid On '.$payment->payment_date.' has been approved';
                $subject ="Payment Approved Notification";
                $receiver_name =$payment->member?->member_name;
                $receiver_email =$payment->member?->email;
                //$receiver_email ="luhaboy@gmail.com";
                Log::info('Tunatuma email inside job');
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;

         case 3:
                $payment =$this->resource;
                $message ='Your Payment of '. number_format($payment->amount).' with payment reference '.$payment->payment_reference.', Paid On '.$payment->payment_date.' has been rejected because of '.$payment->comment;
                $subject ="Payment Rejected Notification";
                $receiver_name =$payment->member?->member_name;
                $receiver_email =$payment->member?->email;
               // $receiver_email ="luhaboy@gmail.com";
                Log::info('Tunatuma email rejection inside job');
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;

         case 4:
                $guarantor =$this->resource;
                $message   =$guarantor->loan?->member?->member_name. " has requested a loan amount of". number_format($guarantor->loan?->amount) ." and request you to be his guarantor , please login to the system to approve/reject this request";
                $subject ="Loan Application Request Notification";
                $receiver_name =$guarantor->member?->member_name;
                $receiver_email =$guarantor->member?->email;
               // $receiver_email ="luhaboy@gmail.com";
                Log::info('Tunatuma email loan request inside job');
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;

         case 5:
                $guarantor =$this->resource;
                $message   =$guarantor->member?->member_name." has approved to guarantor the request you sent to him";
                $subject ="Loan Application Approved Notification";
                $receiver_name  =$guarantor->loan?->member?->member_name;
                $receiver_email =$guarantor->loan?->member?->email;
               // $receiver_email ="luhaboy@gmail.com";
                Log::info('Tunatuma email loan approve request inside job');
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;

         case 6:
                $guarantor =$this->resource;
                $message   =$guarantor->member?->member_name." has rejected to guarantor the request you sent to him because of ".$guarantor->comment;
                $subject ="Loan Application Rejected Notification";
                $receiver_name  =$guarantor->loan?->member?->member_name;
                $receiver_email =$guarantor->loan?->member?->email;
               // $receiver_email ="luhaboy@gmail.com";
                Log::info('Tunatuma email loan reject request inside job');
                $this->sendEmail($message,$subject,$receiver_name,$receiver_email);
            break;
        
        default:
            # code...
            break;
       } 
    }

    public function sendEmail($message,$email_subject,$receiver_name,$receiver_email){
        $data =array(
            'name' =>$receiver_name,
            'body' =>$message,
        );

        Mail::send('mails.mail_template',['data'=>$data],function($message) use ($email_subject,$receiver_name,$receiver_email) {
           $message->to($receiver_email, $receiver_name)->subject
              ($email_subject);
          // $message-bcc('lupenza10@gmail.com', 'Lupenza Luhangano');
           $message->from('non-reply@uskbrotherhood.co.tz','USK BrotherHood Team');
        });
    }
}
