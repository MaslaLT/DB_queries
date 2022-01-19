<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IntroLessonController extends Controller
{
    public function firstLesson()
    {
        $user = DB::select('select * from users where id = ?', [1]);
        $user2 = DB::connection('sqlite')->select('select * from users');

        dump("mysql", $user);
        dump("sqlite", $user2);
    }

    public function secondLesson()
    {
        /**
         * PDO query
         */
        $pdo = DB::connection()->getPdo();
        $pdoUsers = $pdo->query('select id, name from users')->fetchAll(2);

        dump('pdo', $pdoUsers);

        /**
         * DB facade (row query) query with bounded parameters '?'
         */
        $dbFacadeQuery = DB::select('select * from users where id = ? and name = ?', [1, 'test\'orosa']);
        dump('row select query', $dbFacadeQuery);

        /**
         * DB facade (row query) query with named bounded parameters '?'
         */
        $dbFacadeQueryWithNamedParameter = DB::select('select * from users where id = :id', ['id' => 1]);
        dump('row select query with named parameter', $dbFacadeQueryWithNamedParameter);

        /**
         * DB row query insert into users
         */
        $dbRowInsertQuery = DB::insert(
            'insert into users (name, email, password) values (?, ?, ?)', [
                'Artur', 'artur@mas.com', 'password'
            ]);
        dump('row insert user', $dbRowInsertQuery);

        /**
         * DB row query update users email named bounded parameter
         */
        $dbRowUpdateQuery = DB::update(
            'update users set email = "update@test.com" where email = :email', [
                'email' => 'artur@mas.com'
            ]);
        dump('row update user', $dbRowUpdateQuery);

        /**
         * DB row query delete user
         */
        $dbRowDeleteQuery = DB::delete('delete from users where email = ?', ['update@test.com']);
        dump('row delete query', $dbRowDeleteQuery);

        /**
         * DB query builder query
         */
        $queryBuilderSelect = DB::table('users')->select()->get();
        dump('QueryBuilder select all', $queryBuilderSelect);

        /**
         * Eloquent ORM query
         */
        $eloquentOrmQuery = User::all();
        dump('Eloquent ORM', $eloquentOrmQuery);
    }

    public function thirdLesson()
    {
        /**
         * DB transaction it is used to update more when one db record without errors
         * To roll back transaction db update need to return exception.
         */

        DB::insert(
            'insert into users (name, email, password) values (?, ?, ?)', [
            'Artur', 'artur@mas.com', 'password'
        ]);
        DB::transaction(function (){
            DB::table('users')->where('email', 'artur@mas.com')->update(['email' => 'testTransaction']);
        }, 5);

        try {
            DB::transaction(function (){
                $updateQuery = DB::table('users')->where('email', 'artur@masssss.com')->update(['email' => 'testTransaction']);
                if(!$updateQuery){
                    throw new \Exception;
                }
            }, 5);
        } catch (\Exception $e){
            DB::rollBack();
        }
        dump('DB transaction see debug bar');
        DB::delete('delete from users where email = ?', ['testTransaction']);
    }

    public function fourthLesson()
    {
        DB::delete('delete from comments');
        $comments = Comments::factory()->count(10)->make();
        foreach ($comments as $comment) {
            $comment->save();
        }
        dump(Comments::all());
    }
}
