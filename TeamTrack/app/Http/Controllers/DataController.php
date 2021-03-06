<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Team;
use App\User;
use App\Task;


class DataController extends Controller
{

    //The purpose of this Controller is to add Dummy Data to the database

    public function importData(){

        Team::create(['id'=>1, 'name' => 'Team 1', 'leader_id'=>2])
            ->create(['id'=>2, 'name' => 'Team 2', 'leader_id'=>3])
            ->create(['id'=>3, 'name' => 'Team 3', 'leader_id'=>2])
            ->create(['id'=>4, 'name' => 'Team 4', 'leader_id'=>2])
            ->create(['id'=>5, 'name' => 'Team 5', 'leader_id'=>2]);

        // id cannot be explicitly defined, team_user table relations added via email
        User::create(['name'=>'Tom Scott', 'email'=>'tomscott@gmail.com', 'password'=>'$2y$10$m.uScGQzKGfB7b.TO0WlxepfNskVgM.zlzT9iy7erO62vc2ee7nfe' ])
            ->create(['name'=>'Simon the slowloris', 'email'=>'simon@lorismail.com', 'password'=>'$2y$10$m.uScGQzKGfB7b.TO0WlxepfNskVgM.zlzT9iy7erO62vc2ee7nfe' ])
            ->create(['name'=>'Leonard', 'email'=>'leo@gmail.com', 'password'=>'$2y$10$m.uScGQzKGfB7b.TO0WlxepfNskVgM.zlzT9iy7erO62vc2ee7nfe' ])
            ->create(['name'=>'Dark Vader', 'email'=>'dark@vader.mail', 'password'=>'$2y$10$m.uScGQzKGfB7b.TO0WlxepfNskVgM.zlzT9iy7erO62vc2ee7nfe' ])
            ->create(['name'=>'Neon Cactus', 'email'=>'cactu@gmail.com', 'password'=>'$2y$10$m.uScGQzKGfB7b.TO0WlxepfNskVgM.zlzT9iy7erO62vc2ee7nfe' ]);

        // adds team_user table relations
        Team::addMemberByEmail('tomscott@gmail.com',1);
        Team::addMemberByEmail('tomscott@gmail.com',2);
        Team::addMemberByEmail('simon@lorismail.com',2);
        Team::addMemberByEmail('leo@gmail.com',3);
        Team::addMemberByEmail('dark@vader.mail',4);
        Team::addMemberByEmail('dark@vader.mail',5);
        Team::addMemberByEmail('cactu@gmail.com',5);

        //assign team leaders        

        return redirect('/teams');
    }

    public function emptyData(){
        //DB::delete('delete from users');
        DB::delete('delete from teams');
        DB::delete('delete from team_user');
        DB::delete('delete from tasks');
        DB::delete('delete from backlogs');
        DB::delete('delete from sprints');
        DB::delete('delete from comments');
        DB::delete('delete from settings');
        DB::delete('delete from tasks');
        
        return redirect('/teams');
    }

}
