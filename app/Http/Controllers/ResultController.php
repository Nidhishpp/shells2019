<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    
    public function resultRegisterView(Request $request)
    {
        
        $eventid=$request->$eventid;
        $event=Event::where('id',$eventid)->first();
        $round=$request->round;
        $eventtype=$request->eventtype;
        $no=$request->no;

        return View('resultpublish',compact('event','round','no'));

    }


    public function resultRegister(Request $request)
    {
        
        

        DB::beginTransaction();

        try{

            $result=new ResultsMain;

            $result->event_id=$request->eventid;
            $result->round_name=$request->roundname;

            $result->save;


            foreach($students as $student){

                $resultstudent=new ResultStudents;

                $resultstudent->result_main_id=$result->id;

                $resultstudent->student_name=$student->name;

                $resultstudent->college_username=$student->username;

                $resultstudent->save;

            }
            DB::commit();
        }
        catch(Exception $e){

            //rollback the transactions if any error occur
            DB::rollBack();
            return redirect('results/add');

        }
    }

    public function resultView(Request $request)
    {
        $resultmains=ResultsMain::all();

        $result=collect();

        foreach($resultmains as $key=> $resultmain){

            $subresult=collect();

            $subresult->eventname =Events::select('name')->where('id',$resultmain->event_id)->first();

            $subresult->roundname=$resultmain->round_name;

            $subresult->students=ResultsStudents::where('result_main_id',$resultmain->id)->get();

            $result->push($subresult());

        }

        dd($result);
    }

    public function registerNews(Request $request)
    {
        $body=$request->body;

        $title=$request->title;

        $date=Date.now;

    }

}
