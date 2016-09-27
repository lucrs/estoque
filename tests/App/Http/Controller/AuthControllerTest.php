<?php

namespace App\Http\Controller;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends \TestCase
{
    use DatabaseTransactions;
    public function testLogin()
    {
        $data=[
            'username'=>'Lucas',
            'password'=>'123456',
        ];
        $user = $data;
        $user['password'] = bcrypt($user['password']);
        $user['email']=  'lucas.mech@hotmail.com';

        factory(User::class)->create($user);

        $this->post('auth/login',$data);
        $this->seeStatusCode(200);
        $this->seeJson([
            'username'=>'Lucas',
        ]);
    }
    public function testLoginWithEmail()
    {
        $data=[
            'username'=>'lucas.mech@hotmail.com',
            'password'=>'123456',
        ];

        $user = [
          'username'=>'email',
            'password'=> bcrypt($data['password']),
            'email'=>'lucas.mech@hotmail.com',

        ];

        factory(User::class)->create($user);

        $this->post('auth/login',$data);
        $this->seeStatusCode(200);
        $this->seeJson([
            'username'=>'Lucas',
        ]);
    }


}