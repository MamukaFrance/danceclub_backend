<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Course;

class CourseReserveButton extends Component
{
     public $course;
    /**
     * Create a new component instance.
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function isTeacher()
    {
        return auth()->id() === $this->course->teacher->user_id;
    }

    public function isFull()
    {
        return $this->course->remaining_seats <= 0;
    }

    public function isReserved()
    {
        return $this->course->is_reserved > 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.course-reserve-button');
    }
}
