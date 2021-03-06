<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subject;
use App\Chapter;
use App\Question;
use App\TestExam;
use App\Option;
class QuestionController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    // public function index(Request $request)
    // {
    // 	$questions = Question::orderBy('testexam_id','asc')->get();
    //     $trash_questions = Question::onlyTrashed()->get();
    //     $testexams = TestExam::orderBy('subject_id','asc')->get();
    // 	if(!empty($request->query('ex'))):
    // 		$testexam_id = $request->query('ex');
    // 		$questions = Question::where('testexam_id','=', $testexam_id)->get();
    // 		return view('admin.question',['questions' => $questions,'request' => $request, 'testexams' => $testexams, 'trash_questions' =>$trash_questions]);
    // 	else:
    // 		return view('admin.question',['questions' => $questions, 'request' => $request, 'testexams' => $testexams, 'trash_questions' =>$trash_questions]);
    // 	endif;	
    // }

    // public function add_question(Request $request){
    //     $request->validate(['testexam_id' =>'required']);
    //     $question = Question::firstOrCreate([
    //         'content' => $request->input('content'), 
    //         'testexam_id' =>$request->input('testexam_id'),
    //     ]);
    //     $question = Question::where([['content', $request->input('content')],['testexam_id', $request->input('testexam_id')]])->first();
    //     $question_id = $question->id;
    //     $option = new Option;
    //     $option->name = $request->name_option;
    //     $option->question_id = $question_id;
    //     if($request->input('answer') == 'option1'):
    //         $option->answer = $request->name_option[0];
    //     elseif($request->input('answer') == 'option2'):
    //         $option->answer = $request->name_option[1];
    //     elseif($request->input('answer') == 'option3'):
    //         $option->answer = $request->name_option[2];
    //     else:
    //         $option->answer = $request->name_option[3];     
    //     endif;

    //     $option->save();   
    //     return redirect()->back();
    // }

    // public function change_content(Request $request, $id){
    //     $question = Question::find($id);
    //     $question->content = $request->input('content');
    //     $question->save();
    //     return redirect()->back();
    // }

    // public function del_question($id){
    //     $question = Question::find($id)->delete();
    //     return redirect()->back();
    // }

    // public function restore_trash($id){
    //     $subject = Question::onlyTrashed()->where('id', $id)->restore();
    //     return redirect()->back();
    // }
    public function index(){
        $subjects = Subject::all();
        $chapters = Chapter::all();
        $trash_questions = Question::onlyTrashed()->get();
        return view('admin.question', ['subjects' => $subjects, 'chapters' => $chapters, 'trash_questions' => $trash_questions]);
    }
    public function change_content(Request $request ,$id){
        $question = Question::find($id);
        $question->content = $request->input('content');
        $question->option->name = $request->name_change;
        if($request->input('answer_change') == 'option1'):
            $question->option->answer = $request->name_change[0];
        elseif($request->input('answer_change') == 'option2'):
            $question->option->answer = $request->name_change[1];
        elseif($request->input('answer_change') == 'option3'):
            $question->option->answer = $request->name_change[2];
        else:
            $question->option->answer = $request->name_change[3];     
        endif;
        // $question->save();
        // return redirect()->back();
        $question->save();
        $question->option->save();
        return redirect()->back();
    }

    public function del_question($id){
        $question = Question::find($id)->delete();
        return redirect()->back();
    }

    public function add_question(Request $request){
        $request->validate(['chapter_id' =>'required'], ['chapter_id.required' => 'Chưa chọn đáp án đúng.Vui lòng chọn lại.']);
        $question = Question::firstOrCreate([
            'content' => $request->input('content'),
            'chapter_id' => $request->chapter_id,
        ]);
        $question_id = Question::where([['content',$request->input('content')],['chapter_id',$request->chapter_id]])->first()->id;
        $option = new Option;
        $option->question_id = $question_id;
        $option->name = $request->input('name');
        if($request->input('answer') == 'option1'):
            $option->answer = $request->name[0];
        elseif($request->input('answer') == 'option2'):
            $option->answer = $request->name[1];
        elseif($request->input('answer') == 'option3'):
            $option->answer = $request->name[2];
        else:
            $option->answer = $request->name[3];     
        endif;
        $option->save();
        return redirect()->back();
    }

    public function restore_trash($id){
        $question = Question::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back();
    }
}
