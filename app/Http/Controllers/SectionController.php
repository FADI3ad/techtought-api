namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
       $sections = Section::all();
        return view('sections.index', compact('sections'));
        return response()->json([
    'message' => 'hellon the section API'
    '
]);
    }

    public function show($id)
    {
        $section = Section::findOrFail($id);
        return view('sections.show', compact('section'));
    }

    public function store(Request $request)
    {
        Section::create([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return redirect()->back();
    }
}