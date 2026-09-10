<?php

namespace App\Services;

use App\Traits\PingServer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LearnService
{
    use PingServer;

    public function __construct()
    {
        //
    }

    public function categories(): Collection| array
    {
        if (Cache::has('categories')) {
            return collect(Cache::get('categories'));
        }

        $response = $this->fetctApi('/categories');
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }
        $categories = $response['data']['categories'];
        Cache::put('categories', $categories, now()->addHour());

        return collect($categories);
    }

    // courses
    public function courses(): Collection| array
    {
        if (Cache::has('courses')) {
            return collect(Cache::get('courses'));
        }
        $response = $this->fetctApi('/courses');
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }
        $courses = $response['data'];
        Cache::put('courses', $courses, now()->addHour());

        return collect($courses);
    }

    // lessons for course with id
    public function lessons(string $coursId): Collection| array
    {
        if (Cache::has('lessons' . $coursId)) {
            return collect(Cache::get('lessons' . $coursId));
        }
        $response = $this->fetctApi('/courses-lessons/' . $coursId);
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $lessons = $response['data'];
        Cache::put('lessons' . $coursId, $lessons, now()->addHour());

        return collect($lessons);
    }

    // lessons without a course
    public function lessonWithoutCourse(): Collection| array
    {
        if (Cache::has('lessonsNoCourse')) {
            return collect(Cache::get('lessonsNoCourse'));
        }
        $response = $this->fetctApi('/lessons-without-course');
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $lessons = $response['data'];
        Cache::put('lessonsNoCourse', $lessons, now()->addHour());

        return collect($lessons);
    }

    public function course(string $courseId): Collection| array
    {
        if (Cache::has('course' . $courseId)) {
            return collect(Cache::get('course' . $courseId));
        }
        $response = $this->fetctApi('/course', [
            'courseId' => $courseId,
        ]);

        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
                'course' => [],
                'lessons' => [],
                'usersWhoPurchased' => [],
            ];
        }

        $course = $response['data'];
        Cache::put('course' . $courseId, $course, now()->addHour());

        return collect($course);
    }

    public function myCourses(): Collection| array
    {
        if (Cache::has('purchased' . auth()->user()->id)) {
            return collect(Cache::get('purchased' . auth()->user()->id));
        }

        $response = $this->fetctApi('/user-courses', [
            'userId' => auth()->user()->id,
        ]);
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $courses = $response['data']['courses'];

        Cache::put('purchased' . auth()->user()->id, $courses, now()->addHour());

        return collect($courses);
    }
}
