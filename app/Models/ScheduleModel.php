<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class ScheduleModel extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'start_time'];
}