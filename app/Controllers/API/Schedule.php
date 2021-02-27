<?php

namespace App\Controllers\API;

use CodeIgniter\Controller;

use App\Models\ScheduleModel;


class Schedule extends BaseAPIController
{

	protected $model = '';
	
	public function __construct() {

		$this->model = new ScheduleModel();

	}

	public function index($id)
	{
		 echo $id;
echo "string";
exit();
        $data = $this->model->findAll();

        return $this->respond($data);

	}


	// get single
    public function show($id = null)
    {

        echo $id;
echo "string";
exit();
        $data = $model->getWhere(['id' => $id])->getResult();

        if($data) {
        
            return $this->respond($data);
        
        }else {
        
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create 
    public function create()
    {
        echo "create";
        echo  $_GET['id'];
        exit();
        $data = [
            'product_name' => $this->request->getVar('product_name'),
            'product_price' => $this->request->getVar('product_price')
        ];

        $this->model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
        
        return $this->respondCreated($response);
    }
 
    // update 
    public function update($id = null)
    {
        $input = $this->request->getRawInput();
        
        $data = [
            'product_name' => $input['product_name'],
            'product_price' => $input['product_price']
        ];
        
        $this->model->update($id, $data);
        
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];

        return $this->respond($response);
    }
 
    // delete 
    public function delete($id = null)
    {
        
        $data = $this->model->find($id);
        
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        
        }else{
        
            return $this->failNotFound('No Data Found with id '.$id);
        
        }
         
    }


}
