<?php


namespace User\Api;


use Core\ApiController;
use MKrawczyk\FunQuery\FunQuery;

class User extends ApiController
{
    /**
     * Get basic informations about all users
     * @ApiEndpoint('type'=>'get','url'=>'user', 'description'=>'Get basic information about all users',
     *     'responses'=>[
     *          200=>[
     *              "content"=> [
     *                  "application/json"=> [
     *                      "schema"=>[
     *                          "type"=> "array",
     *                          "items"=> [
     *                              "type"=> "object",
     *                              "properties"=>[
     *                                  "id"=>["type"=>"number", "format"=>"int32"],
     *                                  "name"=>["type"=>"string"],
     *                                  "surname"=>["type"=>"string"],
     *                                  "mail"=>["type"=>"string", "format"=>"mail"],
     *                                  "link"=>["type"=>"string", "format"=>"url"]
     *                              ]
     *                          ]
     *                      ]
     *                  ]
     *              ]
     *          ]
     *     ]
     * )
     */
    public function getUsers()
    {
        return FunQuery::create((new \User\User())->getAll())->map(fn($x) => ['id' => $x->id, 'name' => $x->name, 'surname' => $x->surname, 'mail' => $x->mail, 'link' => $this->getBaseURL() . "user/" . $x->id]);
    }

}