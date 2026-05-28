<?php

namespace App\Console\Commands;

use App\Mail\TaskRemainderMail;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task notification emails based on interval';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // It sends notification by checking notification_interval, notification_start_date and assigned_date

        $today = now();

        $tasks = Task::whereDate('notification_start_date','<=', $today)
            ->whereDate('assigned_date', '>=', $today)
            ->with('creator', 'followers')->get();

        foreach($tasks as $task){
            // Prevent sending more than once per day
            if ($task->last_notified_at && $task->last_notified_at->isSameDay($today)) {
                continue;
            }

            $daysSinceStart = Carbon::parse($task->notification_start_date)->diffInDays($today);

            if ($daysSinceStart % $task->notification_interval == 0){
                $ccEmails = $task->followers
                    ->where('email', '!=', $task->creator->email)
                    ->where('email_verified_at', '!=', null)
                    ->pluck('email')->toArray();

                Mail::to($task->creator->email)
                    ->cc($ccEmails)
                    ->send(new TaskRemainderMail($task));

                $task->last_notified_at = now();
                $task->save();

                $this->info("Notification sent to creator ({$task->creator->email}) and CCed to followers.");
            }
        }

        // // below code is for testing email facilities where email can be sent to specific user
        // $task = Task::whereDate('notification_start_date','>=', $today)
        //     ->whereDate('assigned_date', '>=', $today)
        //     ->whereHas('creator', fn($q) => $q->where('email', 'user@gmail.com'))
        //     ->with('creator', 'followers')->first();

        // if (!$task) {
        //     $this->info("No task found for today.");
        //     return;
        // }

        // $ccEmails = $task->followers
        //     ->where('email', '!=', $task->creator->email)
        //     // ->where('email_verified_at', '!=', null)
        //     ->pluck('email')->toArray();

        // Mail::to($task->creator->email)
        //     ->cc($ccEmails)
        //     ->send(new TaskRemainderMail($task));

        // $task->last_notified_at = now();
        // $task->save();

        // $this->info("Notification sent to creator ({$task->creator->email}) and CCed to followers.");

        return 0;
    }
}
