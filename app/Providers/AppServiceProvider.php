<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DAO\Contracts\UserAccountDAOInterface;
use App\DAO\Contracts\ProfileDAOInterface;
use App\DAO\Contracts\RoleDAOInterface;
use App\DAO\Contracts\AuditLogDAOInterface;
use App\DAO\Contracts\FailedAttemptDAOInterface;
use App\DAO\Contracts\CareerDAOInterface;
use App\DAO\Contracts\SubjectDAOInterface;
use App\DAO\Contracts\AcademicPeriodDAOInterface;
use App\DAO\Contracts\SectionDAOInterface;
use App\DAO\Contracts\SectionEnrollmentDAOInterface;
use App\DAO\Contracts\TeacherSubjectDAOInterface;
use App\DAO\Contracts\ClassSessionDAOInterface;
use App\DAO\Contracts\AttendanceDAOInterface;
use App\DAO\UserAccountDAO;
use App\DAO\ProfileDAO;
use App\DAO\RoleDAO;
use App\DAO\AuditLogDAO;
use App\DAO\FailedAttemptDAO;
use App\DAO\CareerDAO;
use App\DAO\SubjectDAO;
use App\DAO\AcademicPeriodDAO;
use App\DAO\SectionDAO;
use App\DAO\SectionEnrollmentDAO;
use App\DAO\TeacherSubjectDAO;
use App\DAO\ClassSessionDAO;
use App\DAO\AttendanceDAO;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {
        // daos base //
        $this->app->bind(UserAccountDAOInterface::class, UserAccountDAO::class);
        $this->app->bind(ProfileDAOInterface::class, ProfileDAO::class);
        $this->app->bind(RoleDAOInterface::class, RoleDAO::class);
        $this->app->bind(AuditLogDAOInterface::class, AuditLogDAO::class);
        $this->app->bind(FailedAttemptDAOInterface::class, FailedAttemptDAO::class);

        // daos de dominio //
        $this->app->bind(CareerDAOInterface::class, CareerDAO::class);
        $this->app->bind(SubjectDAOInterface::class, SubjectDAO::class);
        $this->app->bind(AcademicPeriodDAOInterface::class, AcademicPeriodDAO::class);
        $this->app->bind(SectionDAOInterface::class, SectionDAO::class);
        $this->app->bind(SectionEnrollmentDAOInterface::class, SectionEnrollmentDAO::class);
        $this->app->bind(TeacherSubjectDAOInterface::class, TeacherSubjectDAO::class);
        $this->app->bind(ClassSessionDAOInterface::class, ClassSessionDAO::class);
        $this->app->bind(AttendanceDAOInterface::class, AttendanceDAO::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}