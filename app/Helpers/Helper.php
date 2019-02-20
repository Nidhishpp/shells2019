<?php

namespace App\Helpers;

use App\Models\Events;
use App\Models\Student;
use App\Models\EventStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Helper
{

    public function eventListSort()
    {
        $user=Auth::user();

        $events=Events::all();

        foreach($events as $key=>$event){

            $eventstudent=EventStudent::where('event_id',$event->id)->get();

            if($eventstudent->isNotEmpty()){
                // if($event->exclusive == '1'){

                //     $events->forget($key);
                //     continue;

                // }
                if($event->groupevent =='1'){

                    $events->forget($key);
                    continue;

                }
                elseif($event->groupevent == '0' && $event->maxnumber <= $eventstudent->count()){

                    $events->forget($key);
                    continue;

                }

            }
        }
        return $events;

    }

    public function studentSort($request,$eventid)
    {
        $user=Auth::user();
        $sortedstudents =[];
        $i=0;
        $students=$user->student()->select('name','id')->get();
        $currentevent=Events::where('id',$eventid)->first();
        foreach($students as $key =>  $student){
                
                $eventstudent = EventStudent::where('student_id',$student->id)->get();
                $flag=0;
                if($eventstudent->isNotEmpty()){

                    foreach($eventstudent as  $es){

                        $flag=0;
                        
                        $event=Events::where('id',$es->event_id)->first();
                        if($event->exclusive == '1' || $es->event_id == $eventid || $currentevent->exclusive == '1'){

                            $flag=1;
                            
                        }
                    
                    }
                    if($flag==1){

                        $students->forget($key);
                        continue;
                    }

                }
                $sortedstudents[$i]=$student;
                $i++;
        }
        return $sortedstudents;

    }


    public function eventRegisterDetails()
    {
        $user =Auth::user();

        $events=Events::all();

        $eventstudents=EventStudent::where('college_id',$user->id)->get();

        $result = collect();

        foreach($events as $key => $event){

            $subresult =collect();

            $students = collect();
            foreach($eventstudents as $key => $eventstudent){

                
                if($event->id == $eventstudent->event_id){

                    // if($event->groupevent == 1){
                        $substudent = collect();

                        $student = Student::find($eventstudent->student_id);
                       
                        $substudent->name = $student->name;
                        $substudent->id = $student->id;
                        $students->push($substudent);
                        $subresult->groupid=$eventstudent->groupid;
                    // }

                }
            }
            if($students->isEmpty()){

                continue;

            }
            $subresult->eventname =$event->name;
            $subresult->eventlogo=$event->logo;
            $subresult->eventinfo=$event->info;
            $subresult->eventid=$event->id;
            $subresult->students=$students;
            $result->push($subresult);
        }

        return $result;
    }


    public function eventDelete($request){

        $eventid=$request->id;

        $user=Auth::user();

        $events=DB::tabele(eventstudent)->where([['college_id',$user->id],['event_id',$eventid]])->delete();

        return 'true';

    }


    
}