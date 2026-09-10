<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HelperService;
use App\Services\LearnService;
use App\Traits\PingServer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    use PingServer;
    //
    public function showCourses(LearnService $learn)
    {
        $courses = $learn->courses();

        if (Arr::exists($courses, 'error') && $courses['error'] == true) {
            return redirect()->back()->with('message', $courses['errorMessage']);
        }

        $info = json_decode($learn->courses());

        return view('admin.memebership.courses', [
            'courses' => $info->courses,
            'title' => 'Courses',
            'categories' => $learn->categories(),
        ]);
    }

    public function addCourse(Request $request)
    {
        if (empty($request->image_url) and !$request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpg,jpeg,png|max:1000',
            ]);
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
        } else {
            $path = $request->image_url;
        }

        //check if the course is piad or not
        $paidCourse = $request->amount != '' ? true : false;

        $response = $this->fetctApi('/add-course', [
            'title' => $request->title,
            'amount' => $request->amount,
            'image_url' => $path,
            'paidCourses' => $paidCourse,
            'category' => $request->category,
            'desc' => $request->desc
        ], 'POST');

        //return $response;
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("courses");
        return back()->with($respond['type'], $respond['message']);
    }

    public function updateCourse(Request $request)
    {
        if ($request->image_url == '' and !$request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpg,jpeg,png|max:1000',
            ]);
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
        } else {
            $path = $request->image_url;
        }

        //check if the course is piad or not
        $paidCourse = $request->amount != '' ? true : false;

        $response = $this->fetctApi('/update-course', [
            'course_id' => $request->course_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'image_url' => $path,
            'paidCourses' => $paidCourse,
            'category' => $request->category,
            'desc' => $request->desc
        ], 'POST');

        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("courses");
        HelperService::cacheForget("course" . $request->course_id);
        return back()->with($respond['type'], $respond['message']);
    }

    public function deleteCourse($coursId)
    {
        $res = $this->fetctApi('/course', [
            'courseId' => $coursId,
        ]);

        $info = json_decode($res);

        if (Storage::disk('public')->exists($info->data->course->id)) {
            Storage::disk('public')->delete($info->data->course->id);
        }

        $response = $this->fetctApi("/delete-course/$coursId", [], 'DEL');

        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("courses");
        HelperService::cacheForget("course" . $coursId);
        return back()->with($respond['type'], $respond['message']);
    }


    public function showLessons(LearnService $learn, string $courseId)
    {
        $lesson = $learn->lessons($courseId);

        if (Arr::exists($lesson, 'error') && $lesson['error'] == true) {
            return redirect()->back()->with('message', $lesson['errorMessage']);
        }

        $info = json_decode($learn->lessons($courseId));

        return view('admin.memebership.lessons', [
            'lessons' => $info->lessons->data,
            'course' => $info->course,
            'title' => 'Lessons'
        ]);
    }

    public function addLesson(Request $request)
    {
        if ($request->image_url == '' and !$request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpg,jpeg,png|max:1000',
            ]);
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
        } else {
            $path = $request->image_url;
        }
        if ($request->has('category')) {
            $cat = $request->category;
        } else {
            $cat = null;
        }

        $response = $this->fetctApi('/add-lesson', [
            'title' => $request->title,
            'length' => $request->length,
            'videolink' => $request->videolink,
            'preview' => $request->preview,
            'course_id' => $request->course_id,
            'desc' => $request->desc,
            'cat' => $cat,
            'thumbnail' => $path
        ], 'POST');

        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("lessons{$request->course_id}");
        HelperService::cacheForget("courses");
        return back()->with($respond['type'], $respond['message']);
    }

    public function updateLesson(Request $request)
    {
        if ($request->image_url == '' and !$request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpg,jpeg,png|max:1000',
            ]);
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
        } else {
            $path = $request->image_url;
        }

        if ($request->has('category')) {
            $cat = $request->category;
            $category = $request->category;
        } else {
            $cat = null;
            $category = null;
        }

        $response = $this->fetctApi('/update-lesson', [
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'length' => $request->length,
            'videolink' => $request->videolink,
            'preview' => $request->preview,
            'course_id' => $request->course_id,
            'desc' => $request->desc,
            'cat' => $cat,
            'course_category_id' =>  $category,
            'thumbnail' => $path
        ], 'POST');

        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("lessons{$request->course_id}");
        return back()->with($respond['type'], $respond['message']);
    }

    public function deleteLesson($lessonId, string $course_id)
    {
        $res = $this->fetctApi('/lesson', [
            'lessonId' => $lessonId,
        ]);

        $info = json_decode($res);

        if (Storage::disk('public')->exists($info->data->lesson->id)) {
            Storage::disk('public')->delete($info->data->lesson->id);
        }

        $response = $this->fetctApi("/delete-lesson/$lessonId", [], 'DEL');
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("lessons{$course_id}");
        HelperService::cacheForget('courses');
        return back()->with($respond['type'], $respond['message']);
    }



    public function addCategory(Request $request)
    {
        $response = $this->fetctApi('/add-category', [
            'category' => $request->category,
        ], 'POST');
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("categories");
        return back()->with($respond['type'], $respond['message']);
    }

    public function deleteCategory($id)
    {
        $response = $this->fetctApi("/delete-cat/$id", [], 'DEL');
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget("categories");
        return back()->with($respond['type'], $respond['message']);
    }


    public function category(LearnService $learn): View|RedirectResponse
    {
        $categories = $learn->categories();

        if (Arr::exists($categories, 'error') && $categories['error'] == true) {
            return redirect()->back()->with('message', $categories['errorMessage']);
        }

        return view('admin.memebership.category', [
            'categories' => $categories,
            'title' => 'Course Category'
        ]);
    }


    public function lessonWithoutCourse(LearnService $learn): View|RedirectResponse
    {
        $lesson = $learn->lessonWithoutCourse();

        if (Arr::exists($lesson, 'error') && $lesson['error'] == true) {
            return redirect()->back()->with('message', $lesson['errorMessage']);
        }

        $info = json_decode($lesson);
        return view('admin.memebership.lessons-without', [
            'title' => 'Lessons without courses',
            'lessons' => $info->lessons,
            'categories' => $info->categories,
        ]);
    }
}
