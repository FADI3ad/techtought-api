<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category','instructor')
            ->latest()
            ->paginate(10); 

        return view('courses.index', compact('courses'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric',
            'language' => 'nullable|string|max:50',
            'is_free' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('courses', $newImageName, 'public');
            $validated['image'] = $newImageName;
        }

    
        $validated['instructor_id'] = Auth::id();

        Course::create($validated);

        return redirect()->route('courses.index')->with('success','Course created successfully');
    }

 
    public function show($id)
    {
        $course = Course::with('category','instructor','sections')->findOrFail($id);
        return view('courses.show', compact('course'));
    }

  
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        if ($course->instructor_id != Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('courses.edit', compact('course','categories'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($course->instructor_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric',
            'language' => 'nullable|string|max:50',
            'is_free' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            
            Storage::delete("public/courses/$course->image");

            $image = $request->file('image');
            $newImageName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('courses', $newImageName, 'public');
            $validated['image'] = $newImageName;
        }

        $course->update($validated);

        return redirect()->route('courses.index')->with('success','Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->instructor_id != Auth::id()) {
            abort(403);
        }

        Storage::delete("public/courses/$course->image");
        $course->delete();

        return redirect()->route('courses.index')->with('success','Course deleted successfully');
    }

    public function myCourses()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->with('category','sections')
            ->latest()
            ->paginate(10); 
        return view('courses.my-courses', compact('courses'));
    }
}
