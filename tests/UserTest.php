<?php
namespace Tests;

class UserTest extends TestCase
{
    /**
     * /users [GET]
     */
    
    /**
     * @covers App\Providers\AuthServiceProvider
     * @covers App\Http\Controllers\UsersController::index
     */
    public function testShouldReturnAllUsers(){

        $this->get("http://localhost:8000/api/users", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'username',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * /user/id [GET]
     */

    /**
     * @covers App\Providers\AuthServiceProvider
     * @covers App\Http\Controllers\UsersController::show
     */
    public function testShouldReturnUser(){
        $this->get("http://localhost:8000/api/user/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'firstname',
                    'lastname',
                    'email',
                    'username'
                ]
            ]    
        );
        
    }

    /**
     * /user [POST]
     */

    /**
     * @covers App\Providers\AuthServiceProvider
     * @covers App\Http\Controllers\UsersController::create
     * @covers App\Mail\WelcomeUser
     * @covers App\Models\Users
     */
    public function testShouldCreateUser(){

        $parameters = [
            'firstname' => 'Test',
            'lastname' => 'Case',
            'email' => 'test@gmail.com',
            'username' => uniqid(),
            'password' => 'test123'
        ];

        $this->post("http://localhost:8000/api/user", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'firstname',
                    'lastname',
                    'email',
                    'username'
                ]
            ]    
        );
        
    }

    /**
     * /user/id [DELETE]
     */

     /**
     * @covers App\Providers\AuthServiceProvider
     * @covers App\Http\Controllers\UsersController::delete
     */
    public function testShouldDeleteUser(){
        
        $this->delete("http://localhost:8000/api/user/0", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'status',
                'message'
        ]);
    }
}
