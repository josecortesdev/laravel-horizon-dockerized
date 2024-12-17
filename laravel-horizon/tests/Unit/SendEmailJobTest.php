<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Log;

class SendEmailJobTest extends TestCase
{
    /**
     * Test the SendEmailJob.
     *
     * @return void
     */
    public function testSendEmailJob()
    {
        Mail::fake();
        Log::shouldReceive('info')->once()->with('SendEmailJob is working! Email sent to josecortesdev@gmail.com');

        $job = new SendEmailJob('josecortesdev@gmail.com');
        $job->handle();

        Mail::assertSent(SampleMail::class, function ($mail) {
            return $mail->hasTo('josecortesdev@gmail.com');
        });
    }
}
