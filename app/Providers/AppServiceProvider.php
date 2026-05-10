<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $badgePendingTasks = 0;
                $badgeUnfilledAttendances = 0;
                $badgePendingRegistrations = 0;
                $badgeNeedGrading = 0;

                if ($user->role_id == 3) {
                    // Badge Pelaksana
                    $badgePendingTasks = \App\Models\TaskSubmission::where('user_id', $user->id)
                        ->whereIn('status', ['pending', 'returned'])
                        ->count();
                    
                    $badgeUnfilledAttendances = \App\Models\AttendanceAssignee::where('user_id', $user->id)
                        ->where('status', 'Belum Mengisi')
                        ->count();
                } elseif ($user->role_id == 1) {
                    // Badge Admin
                    $badgePendingRegistrations = \App\Models\PendingRegistration::count();
                }

                if (in_array($user->role_id, [1, 2])) {
                    // Badge Dosen/Admin: Tugas yang butuh dinilai (status 'submitted')
                    $query = \App\Models\TaskSubmission::where('status', 'submitted')->whereHas('task', function($q) use ($user) {
                        if ($user->role_id == 2) {
                            $q->where('divisi_id', $user->divisi_id)->orWhere('created_by', $user->id);
                        }
                    });
                    $badgeNeedGrading = $query->count();
                }

                $view->with(compact('badgePendingTasks', 'badgeUnfilledAttendances', 'badgePendingRegistrations', 'badgeNeedGrading'));
            }
        });
    }
}
