<?php


namespace User\Api;


use Core\ApiController;
use Core\Exceptions\NotFoundException;
use MKrawczyk\FunQuery\FunQuery;

class UserApi extends ApiController
{
    /**
     * @ApiEndpoint('type'=>'get','url'=>'user','tags'=>['User'], 'description'=>'Get basic information about all users',
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
        return FunQuery::create((new \User\User())->getAll())->map(fn($x) => ['id' => $x->id, 'name' => $x->name, 'surname' => $x->surname, 'mail' => $x->mail, 'link' => $this->getBaseURL()."user/".$x->id]);
    }

    /**
     * @ApiEndpoint('type'=>'get','url'=>'user/{id}','tags'=>['User'], 'description'=>'Get basic information about one specific users',
     *     'parameters'=>[
     *     [
     *     'name'=>'id',
     *     'in'=>'path',
     *     'required'=>true
     *     ]
     *     ],
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
     *          ],
     *     404=>[]
     *     ]
     * )
     */
    public function getOneUser(int $id)
    {
        $item = (new \User\User())->getById($id);
        if (!$item)
            throw new NotFoundException();
        else
            return ['id' => $item->id, 'name' => $item->name, 'surname' => $item->surname, 'mail' => $item->mail, 'link' => $this->getBaseURL()."user/".$item->id];
    }
}