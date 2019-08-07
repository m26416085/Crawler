<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;
use App\Search;

class EditSection extends Controller
{
    public function index(){
        
    }

    public function post(){
        $id = $_POST['id_section'];
        $sections = DB::table('searches')->get();
        foreach($sections as $section){
            if($section->id == $id){
                $keyword = $section->keyword;
            }
        }

        return view::make('editsection', compact('keyword', 'id'));
    }

    public function edit(){
        $id = $_POST['id_section'];
        $keyword = $_POST['keyword'];

        DB::table('searches')->where('id',$id)->update([
            'keyword' => $keyword
        ]);
        return view::make('editsection', compact('keyword', 'id'));
    }
}
